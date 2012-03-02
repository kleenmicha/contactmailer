<?php
/*
*@Titel:		ContactMailer for wBB
*@Filename:		contact.php
*@Version:		1.5
*@Rev:			107
*@Autor:		Michael (KleenMicha) Sch¸ler
*@letzte ƒnderung:	22. Januar 2010 um 14:26Uhr															
*
*@Hinweis zur Nutzung
* - Der Copyright im Fuﬂbereich darf weder entfernt noch verfremdet werden. Ist eine Entfernung gew¸nscht so bitte mit mir in Kontakt treten.
* - Es ist nicht erlaubt den gesamten Code oder nur Teile hieraus zu entnehmen und als den eigenen auszugeben	.
* - Es ist erlaubt die Contactmailer den eigenen W¸nschen entsprechend anzupassen/zu ver‰ndern.
* - Es ist nicht erlaubt diese Hinweise hier zu entfernen.
*
* @Hinweise zum Ursprung des Codes:
* - Diverse Codebestandteile entstammen aus dem WoltLab BurningBoard daher ist es nicht
*   erlaubt Bestandteile auﬂrhalb des WoltLab BurningBoardes zu verwenden.
* - Der Autur eignet sich auch mit diesem Copyright diese Teile nicht an.
* - Weitere Hinweise zur WoltLab Lizens zur Nutzung des BurningBoardes gibt es unter: 
*   http://www.woltlab.de/products/burning_board/license.php
*
*/

$filename = 'contact.php';

// Einbinden benˆtigter Dateien
require('./global.php');
require('./components/com_contactmailer/function_contactmailer.php');
ini_set('display_errors',1);

if(!$wbbuserdata['can_use_contact']) access_error();

// Laden der Sprachkategorie
$lang->load('contact');

$randomNum = rand(0,99);
$randomNum2 = rand(0,99);

$randomNum3  = $randomNum + $randomNum2;
$randomNumTotal = base64_encode($randomNum + $randomNum2);

/* Wenn kein Copyright mehr vorhanden sein soll dann den folgenden Teil auskommentieren */
//Einlesen der Informationsdatei
$do = readinSetup('components/com_contactmailer/contactmailer.xml');
$author = utf8_decode($do[0]->author);
$lang->items['LANG_CONTACT_COPY'] = $lang->get("LANG_CONTACT_COPY", array('$authornick' => $do[0]->authornick, '$version' => $do[0]->version, '$name' => $do[0]->name, '$year' => $do[0]->year, '$authorurl' => $do[0]->authorurl, '$datum' => $do[0]->versionsdate));

if (isset($_POST['anrede'])) $anrede = htmlconverter($_POST['anrede']);
else $anrede = '';
if (isset($_POST['name'])) $name = htmlconverter($_POST['name']);
else $name = '';
if (isset($_POST['vorname'])) $vorname = htmlconverter($_POST['vorname']);
else $vorname = '';
if (isset($_POST['email'])) $email = htmlconverter($_POST['email']);
else $email = '';
if (isset($_POST['street'])) $street = htmlconverter($_POST['street']);
else $street = '';
if (isset($_POST['streetn'])) $streetn = htmlconverter($_POST['streetn']);
else $streetn = '';
if (isset($_POST['plz'])) $plz = htmlconverter($_POST['plz']);
else $plz = '';
if (isset($_POST['ort'])) $ort = htmlconverter($_POST['ort']);
else $ort = '';
if (isset($_POST['phone'])) $phone = htmlconverter($_POST['phone']);
else $phone = '';
if (isset($_POST['fax'])) $fax = htmlconverter($_POST['fax']);
else $fax = '';
if (isset($_POST['betreff'])) $betreff = htmlconverter($_POST['betreff']);
else $betreff = '';
if (isset($_POST['text'])) $text = htmlconverter($_POST['text']);
else $text = '';
if (!isset($wbbuserdata['username'])) $username = 'Gast';
else $username = $wbbuserdata['username'];
if (isset($_POST['addinfo'])) $addinfo = htmlconverter($_POST['addinfo']);
if (isset($_POST['private_key'])) $private_key = htmlconverter($_POST['private_key']);

$contact_errors = '';
$contact_error	= '';
$contact_preview= '';
$contact_send	= '';
$colem = '';
$checkbox = array("", "");
	
if($anrede=='Herr') $checkbox[0] = 'checked="checked"';
elseif($anrede=='Frau') $checkbox[1] = 'checked="checked"';

$result = $db->query("SELECT value FROM bb".$n."_contactsettings");
while($row = $db->fetch_array($result)) $conset[] = $row['value'];

if(isset($_POST['preview'])) {
	if(!isset($anrede)) $anrede = $lang->get('LANG_CONTACT_PLEASE');
		
	if(isset($name) || $vorname) $nv = $name.", ".$vorname;
	else $nv = '<span class="failure">'.$lang->get('LANG_CONTACT_KNAME').'</span>';

    if(isset($email)) $em = $email;
	else $em = '<span class="failure">'.$lang->get('LANG_CONTACT_KEMAIL').'</span>';

	if(isset($street) || isset($streetn)) $adr = $street." / ".$streetn;
	else $adr = $lang->get('LANG_CONTACT_KEIN');

	if(isset($plz) || isset($ort)) $home = $plz." / ".$ort;
	else $home = $lang->get('LANG_CONTACT_KEIN');
	
	if(isset($phone))	$ph = $phone;
	else $ph = $lang->get('LANG_CONTACT_KEIN');

	if(isset($fax)) $pf = $fax;
	else $pf = $lang->get('LANG_CONTACT_KEIN');
	
	if(isset($betreff)) $betref = $betreff;
	else $betref = '<span class="failure">'.$lang->get('LANG_CONTACT_KSUB').'</span>';
	
	$textpre = nl2br(htmlentities(addslashes(chop($text))));
	$commento = '<span class="failure">'.$lang->get('LANG_CONTACT_KTEXT').'</span>';
	
	if($text) $textp = $textpre;
	else $textp = $commento;
	
	eval("\$contact_preview = \"".$tpl->get("contact_preview")."\";");
}

if(isset($_POST['send'])) {
	if(!$text || !$betreff || !$name || !$vorname || !$anrede || !$email) {
		$colem = ' failure';
		$contact_errors.= $lang->items['LANG_CONTACT_ERROR1'];
	}
	else {
		if(!eregi("^[a-z0-9]+([-_\.]?[a-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}", $email) && $contact_errors == '') {
			$coleem = ' failure';
			$contact_errors.= $lang->get("LANG_CONTACT_ERROR2", array('$email' => $email));
		}
		
	}
	$ipadress = getenv(REMOTE_ADDR);
	$blocktime = $conset[0];
	if (flood($wbbuserdata['userid'], $ipaddress, $blocktime) == true) $contact_errors.= $lang->get("LANG_CONTACT_ERROR3", array('$blocktime' => $blocktime));
	
	if (base64_decode($addinfo) <> $private_key) $contact_errors.= $lang->get("LANG_CONTACT_ERROR4");
	
	if($contact_errors != '') eval("\$contact_error = \"".$tpl->get("contact_error")."\";");
	else {
		//insert content into db
		$db->query("INSERT INTO bb".$n."_contactpost (userid, username,ipadresse, name, vorname,  email, street, streetn, plz, ort, phone, fax, title, post, postdate) VALUES ('$wbbuserdata[userid]', '$username', '".addslashes($ipadress)."', '".addslashes($name)."', '".addslashes($vorname)."', '".addslashes($email)."', '".addslashes($street)."', '".addslashes($streetn)."', '".addslashes($plz)."', '".addslashes($ort)."', '".addslashes($phone)."', '".addslashes($fax)."', '".addslashes($betreff)."', '".addslashes($text)."','".time()."')");
		
		//send mail to admin
		$header1 = "From: \"$vorname $name\" <$email>\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=iso-8859-1' . "\r\n" . "X-Mailer: PHP/".phpversion();
		$anr = "\nAnrede: ". $anrede. "\nName: ". $name ."\nVorname: ". $vorname;
		$ema = "\nE-Mail-Adresse: ".$email;
		if($conset[1] == 1) $stree = "\nStraﬂe/Nummer: ". $street . $streetn ."\nPLZ/Ort: ". $plz . $ort;
		else $stree = '';
		if($conset[2] == 1) $phon = "\nTelefon: ". $phone;
		else $phon = '';
		if($conset[3] == 1) $telef = "\nTelefax: ". $fax;
		else $telef='';
		$mes = "\nAnfrage: ".$text;
		$nachricht1.= $anr . $ema . $stree . $phon . $telef . $mes;
		$nachricht1 = nl2br($nachricht1);
		mail($webmastermail,$betreff,$nachricht1,$header1);
		
		//send thanksmail to user
		$anr2 = $anrede." ".$name ." ".$vorname;
		$header2 = "From: <$conset[4]>\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=iso-8859-1' . "\r\n" . "X-Mailer: PHP/".phpversion();
		$subject2 = "Danke f¸r die Anfrage: ". $betreff;
		$danke = $lang->get("LANG_CONTACT_THANKS", array('$anr' => $anr2, '$nachricht1' => $nachricht1));
		$an2 = "\"$name\" <$email>";
		mail($email,$subject2,$danke,$header2);
		eval("\$contact_send = \"".$tpl->get("contact_send")."\";");	
	}
}

eval("\$tpl->output(\"".$tpl->get("contact")."\");");
?>