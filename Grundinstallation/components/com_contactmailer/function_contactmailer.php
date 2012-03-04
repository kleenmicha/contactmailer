<?php
/*
*@Titel:		ContactMailer for wBB
*@Filename:		function_contactmailer.php
*@Version:		1.5
*@Rev:			107
*@Autor:		Michael (KleenMicha) Schüler
*@letzte Änderung:	04. Maerz 2012 um 13:19Uhr
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

//using schema from floodcontrol (./acp/lib/functions.php by Burntime)
function flood($userid, $ipaddress, $blocktime) {
	global $db, $n, $blocktime;

	if($userid != 0) $result = $db->query_first("SELECT postid FROM bb".$n."_contactpost WHERE userid='". (int) $userid."' AND postdate>='".(time() - $blocktime)."'", 1);	
	else $result = $db->query_first("SELECT postid FROM bb".$n."_contactpost WHERE ipaddresse='$ipaddress' AND postdate>='".(time() - $blocktime)."'", 1);
	
	if ($result['postid']) return true;
	else return false;	
}
	
// Using xml_parser example from php.net
class chooseLine {
	function chooseLine ($aa) {
		foreach ($aa as $k=>$v) $this->$k = $aa[$k];
	}
}

function readinSetup($setupfile) {
	$handle = @fopen ($setupfile, "r");

	$data = fread ($handle, filesize($setupfile));
	fclose ($handle);

	$parser = xml_parser_create();
	xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	xml_parse_into_struct($parser, $data, $values, $tags);
	xml_parser_free($parser);
	
	foreach ($tags as $key=>$val) {
		if ($key == "installer" || $key == "informel") {
			$molranges = $val;
			for ($i=0; $i < 2; $i+=2) {
				$offset = $molranges[$i] + 1;
				$len = $molranges[$i + 1] - $offset;
				$tdb[] = parseLine(array_slice($values, $offset, $len));
			}
		}
		else continue;
	}
	return $tdb;
}

function parseLine($mvalues) {
	for ($i=0; $i < count($mvalues); $i++) $mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
	return new chooseLine($mol);
}
?>