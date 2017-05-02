<?php
/*
>> Information

	Title		: hpl_scheduler function
	Revision	: 1.2.0
	Notes		:

	Revision History:
	When			Create		When		Edit		Description
	---------------------------------------------------------------------------
	12-07-2016		Poen		12-07-2016	Poen		Create the program.
	12-08-2016		Poen		12-08-2016	Poen		Debug yield function.
	03-27-2017		Poen		03-27-2017	Poen		Fix command function error message.
	---------------------------------------------------------------------------

>> About

	GitHub : https://github.com/poen0121/scheduler

	Scheduler the operation mode by CGI.

	Yield function with CURL support.

>> Usage Function

	==============================================================
	Include file
	Usage : include('scheduler/main.inc.php');
	==============================================================

	==============================================================
	A generator function.
	Usage : hpl_scheduler::yield($scriptName);
	Param : string $scriptName (script name)
	Return : boolean
	Return Note : Returns FALSE on error.
	--------------------------------------------------------------
	Example : __FILE__ >> /var/www/schedule01.php
	hpl_scheduler::yield('schedule01.php');
	Output >> TRUE
	Example : __FILE__ >> /var/www/schedule01.php
	hpl_scheduler::yield('../schedule01.php');
	Output >> TRUE
	Example : __FILE__ >> /var/www/schedule01.php
	hpl_scheduler::yield(__FILE__);
	Output >> TRUE
	==============================================================

	==============================================================
	The scheduler command for the script.
	Usage : hpl_scheduler::command($switch,$interval);
	Param : boolean $switch (open or close the script) : Default false
	Note : $switch `true` is open the schedule script.
	Note : $switch `false` is close the schedule script.
	Param : integer $interval (by the switch to open the interval the number of minutes 1 ~ 31536000) : Default 1
	Return : boolean
	--------------------------------------------------------------
	Example : Open the schedule script.
	hpl_scheduler::command(true,5);
	Output >> TRUE
	Example : Close the schedule script.
	hpl_scheduler::command(false);
	Output >> FALSE
	==============================================================

>> Example

	Schedule script.
	eg: file `schedule01.php`
	--------------------------------------------------------------
	<?php
	include('scheduler/main.inc.php');
	hpl_scheduler::command(true,5);
	error_log('Message : Test time ['.time().']'.PHP_EOL, 3, './schedule01.log');
	?>
	--------------------------------------------------------------

	Trigger script.
	eg: file `trigger.php`
	--------------------------------------------------------------
	<?php
	include('scheduler/main.inc.php');
	hpl_scheduler::yield('schedule01.php');
	?>
	--------------------------------------------------------------

*/
?>