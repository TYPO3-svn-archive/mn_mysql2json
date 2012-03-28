<?php

########################################################################
# Extension Manager/Repository config file for ext "mn_mysql2json".
#
# Auto generated 28-03-2012 16:27
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'MySQL to JSON',
	'description' => 'An eID call of any table in MySQL to get the data back as JSON. The tables in MySQL that are allowed are configurable, defaults are tt_content and pages. The request is being made like this:

http://yourdomain/?eID=tx_mnmysql2json_Table&tx_mnmysql2json[action]=getTable&tx_mnmysql2json[tableName]=pages&tx_mnmysql2json[fields]=title,pid,uid

You can use all parameters that are use in a MySQL query so in this case if you would like to use where you just add, tx_mnmysql2json[where]= uid = 21',
	'category' => 'misc',
	'author' => 'Mattias Nilsson',
	'author_email' => 'tollepjaer@gmail.com',
	'shy' => '',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '2.1.0',
	'constraints' => array(
		'depends' => array(
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:8:{s:9:"ChangeLog";s:4:"2890";s:10:"README.txt";s:4:"ee2d";s:19:"class.Table_eid.php";s:4:"32ee";s:21:"ext_conf_template.txt";s:4:"dfdc";s:12:"ext_icon.gif";s:4:"4758";s:17:"ext_localconf.php";s:4:"c75c";s:14:"doc/manual.pdf";s:4:"4085";s:14:"doc/manual.sxw";s:4:"64f3";}',
	'suggests' => array(
	),
);

?>