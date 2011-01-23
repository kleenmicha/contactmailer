<?php
/*
*@Titel:		ContactMailer for wBB
*@Filename:		acp_contact.php
*@Version:		1.2.1
*@Rev:			106
*@Autor:		Michael (KleenMicha) Schüler
*@letzte Änderung:	08. Dezember 2006 um 15:26Uhr
*
* @Hinweis zur Nutzung
* - Der Copyright im Fußbereich darf weder entfernt noch verfremdet werden. Ist eine Entfernung gewünscht so bitte mit mir in Kontakt treten.
* - Es ist nicht erlaubt den gesamten Code oder nur Teile hieraus zu entnehmen und als den eigenen auszugeben
* - Es ist erlaubt das Anleitungs-System die eigenen Wünschen entsprechend anzupassen/zu verändern
* - Es ist nicht erlaubt diese Hinweise hier zu entfernen
*
* @Hinweise zum Ursprung des Codes:
* - Diverse Codebestandteile entstammen aus dem WoltLab BurningBoard daher ist es nicht erlaubt Bestandteile außrhalb des WoltLab BurningBoardes zu verwenden
* - Der Autur eignet sich auch mit diesem Copyright diese Teile nicht an
* - Weitere Hinweise zur WoltLab Lizens zur Nutzung des BurningBoardes gibt es unter:
*   http://www.woltlab.de/products/burning_board/license.php
*
*/

require('./global.php');
require_once('./../components/com_contactmailer/function_contactmailer.php');

if(!checkAdminPermissions("a_can_contact_edit")) access_error(1);

$lang->load('ACP_CONTACT,CONTACT,MISC');

$do = readinSetup('./../components/com_contactmailer/contactmailer.xml');
$author = utf8_decode($do[0]->author);
$lang->items['LANG_CONTACT_COPY'] = $lang->get("LANG_CONTACT_COPY", array('$authornick' => $do[0]->authornick, '$version' => $do[0]->version, '$name' => $do[0]->name, '$year' => $do[0]->year, '$authorurl' => $do[0]->authorurl, '$datum' => $do[0]->versionsdate));

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else $action = 'options';

if (isset($_REQUEST['postid'])) $postid = (int) $_REQUEST['postid'];
else $postid = 0;

//view contactmailer settings (using parts of ./acp/options.php -> $Author: Burntime$ )
if ($action == 'options') {
	
	if (isset($_POST['send'])) {
		if (is_array($_POST['option'])) {
		 reset($_POST['option']);
		 while (list($conid, $value) = each($_POST['option'])) $db->query("UPDATE bb".$n."_contactsettings SET value='".addslashes($value)."' WHERE conid='". (int) $conid."'");
		}
		header("Location: acp_contact.php?action=options&sid=$session[hash]");
		exit();	
	}
	
	$results = $db->query("SELECT * FROM bb".$n."_contactsettings");
	while($row = $db->fetch_array($results)){
		if ($row['optioncode'] == "text") $optioncode = "<input type=\"text\" name=\"option[$row[conid]]\" value=\"".htmlconverter($row['value'])."\" size=\"35\" />";
		elseif ($row['optioncode'] == "truefalse") $optioncode = "<input type=\"radio\" name=\"option[".$row['conid']."]\" id=\"radio_".$row['conid']."_1\" value=\"1\"".(($row['value'] == 1) ? ("checked=\"checked\"") : (""))." /><label for=\"radio_".$row['conid']."_1\"> ".$lang->items['LANG_ACP_GLOBAL_YES']."</label> <input type=\"radio\" name=\"option[".$row['conid']."]\" id=\"radio_".$row['conid']."_2\" value=\"0\"".(($row['value'] == 0) ? ("checked=\"checked\"") : (""))." /><label for=\"radio_".$row['conid']."_2\"> ".$lang->items['LANG_ACP_GLOBAL_NO']."</label>";
		elseif ($row['optioncode'] == "textarea") $optioncode = "<textarea name=\"option[$row[conid]]\" rows=\"8\" cols=\"50\">".htmlconverter($row['value'])."</textarea>";
		else eval("\$optioncode = \"$row[optioncode]\";");
		
		$varname = wbb_strtoupper($row['varname']);
		$row['title'] = $lang->get("LANG_ACP_CONTACT_OPTIONS_".$varname);
		$row['description'] = $lang->get("LANG_ACP_CONTACT_OPTIONS_".$varname."_DESC");
					
		eval("\$contact_optionsbit .= \"".$tpl->get("acp_contact_optionsbit", 1)."\";");
	}
	
	eval("\$tpl->output(\"".$tpl->get("acp_contact_options", 1)."\",1);");
}

//Übersicht der eingegangenen mails
if ($action == 'posts') {
	if (isset($_REQUEST['page'])) $page = (int) $_REQUEST['page'];
	elseif ($_REQUEST['page'] == 0) $page = 1;
	else $page = 1;
	
	$postsperpage = 20;

	list($postcount) = $db->query_first("SELECT count(postid) FROM bb".$n."_contactpost");
		
	$result = $db->query("SELECT * FROM bb".$n."_contactpost", $postsperpage, $postsperpage * ($page - 1));
	while($row = $db->fetch_array($result)) {
		$dates = date('d.m.Y', $row['postdate']);
		$content = wbb_substr($row['post'],0,30).'... ';
		$count++;
		
		eval("\$contact_postsbit .= \"".$tpl->get("acp_contact_postsbit", 1)."\";");    
	}
	
	$pages = ceil($postcount/$postsperpage);
	if ($page > $pages) $page = 1;
	if ($pages > 1) $pagelink = makePageLink( "acp_contact.php?action=posts&sid=$session[hash]", $page, $pages, $showpagelinks-1);
	else $pagelink = '';

	eval("\$tpl->output(\"".$tpl->get("acp_contact_posts", 1)."\",1);");
}

//Detailierte Ansicht der eingegangenen Mails
if ($action == 'viewdetail') {
	$result = $db->query("SELECT * FROM bb".$n."_contactpost WHERE postid='$postid'");
	while($row = $db->fetch_array($result)) {
		$dates = date('d.m.Y', $row['postdate']);
		$time = date('H:i', $row['postdate'])."Uhr";
		if($row['street'] != '')	eval("\$home .= \"".$tpl->get("acp_contact_postdetail_home", 1)."\";");
		if($row['phone'] != '')		eval("\$phone .= \"".$tpl->get("acp_contact_postdetail_phone", 1)."\";");
		if($row['fax'] != '')		eval("\$fax .= \"".$tpl->get("acp_contact_postdetail_fax", 1)."\";");
		$post = nl2br($row[post]);
		
		eval("\$tpl->output(\"".$tpl->get("acp_contact_postdetail", 1)."\",1);"); 
	}
}

//Löschen einer nachricht 
if ($action == 'delmail') {
	if (isset($_POST['send'])) {
		$db->query("DELETE FROM bb".$n."_contactpost WHERE postid='$postid'");
		header("Location: acp_contact.php?action=posts&sid=$session[hash]");
		exit();
	}
	eval("\$tpl->output(\"".$tpl->get("acp_contact_maildel", 1)."\",1);"); 
}


//auf eine eMailantworten
if ($action == 'answer') {
	if (isset($_POST['send'])) {
		$header1.="From: \"$name\" <$email>\n MIME-Version: 1.0\n Content-Type: text/html\n X-Mailer: PHP/".phpversion();
		$mes = "\nAnfrage: ".$text;
		mail($webmastermail,$betreff,$mes,$header1);
		header("Location: acp_contact.php?action=posts&sid=$session[hash]");
		exit();
	}
	
	$result = $db->query("SELECT userid, username, title FROM bb".$n."_contactpost WHERE postid='$postid'");
	while($row = $db->fetch_array($result)) {
		if($betreff=='') $betreff = "Re: ".$row['title'];
		else $betreff = htmlconverter($_POST['betreff']);
		if (isset($_POST['text'])) $text = htmlconverter($_POST['text']);
	
		eval("\$tpl->output(\"".$tpl->get("acp_contact_answer", 1)."\",1);");
	}
}
?>