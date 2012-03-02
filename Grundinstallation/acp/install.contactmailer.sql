#
# Tabellenstruktur für Tabelle `bb1_contactpost`
#

DROP TABLE IF EXISTS bb1_contactpost;
CREATE TABLE bb1_contactpost (
 postid int(11) NOT NULL auto_increment,
 userid int(11) NOT NULL default 0,
 username varchar(50) NOT NULL default '',
 ipadresse varchar(16) NOT NULL default '',
 name varchar(255) NOT NULL default '',
 vorname varchar(255) NOT NULL default '',
 email varchar(255) NOT NULL default '',
 street varchar(255) NOT NULL default '',
 streetn varchar(11) NOT NULL default '',
 plz varchar(5) NOT NULL default '',
 ort varchar(255) NOT NULL default '',
 phone varchar(11) NOT NULL default '',
 fax varchar(11) NOT NULL default '',
 title text NOT NULL,
 post text NOT NULL,
 postdate int(11) NOT NULL default 0,
 PRIMARY KEY  (postid)
);

#
# Tabellenstruktur für Tabelle `bb1_contactsettings`
#

DROP TABLE IF EXISTS bb1_contactsettings;
CREATE TABLE bb1_contactsettings (
 conid int(11) NOT NULL auto_increment, 
 varname varchar(250) NOT NULL, 
 value text NOT NULL, 
 optioncode text NOT NULL, 
 PRIMARY KEY (conid)
);

INSERT INTO bb1_contactsettings (conid, varname, value, optioncode) VALUES 
(1, 'blocktime', '60', 'text'),
(2, 'show_adr', 0, 'truefalse'),
(3, 'show_phone', 0, 'truefalse'),
(4, 'show_fax', 0, 'truefalse'),
(5, 'sendname', 'noreply', 'text');
