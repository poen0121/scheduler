<?php
//schedule script
include ('../main.inc.php');
include ('./conf.php');
if (hpl_scheduler :: command($CONF['Enabled'], 5)) {
	error_log('Message : Test time [' . time() . '] GET ' . json_encode($_GET) . PHP_EOL, 3, './schedule01.log');
	exit ('Enable the schedule script!');
} else {
	exit ('Scheduled script disabled!');
}
?>
