<?php
//trigger `schedule01.php` schedule script
include ('../main.inc.php');
if (hpl_scheduler :: yield(__DIR__ . '/schedule01.php?test=1')) {
	exit ('Trigger the schedule script!');
} else {
	exit ('Trigger failed!');
}
?>
