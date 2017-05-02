# scheduler
PHP Library ( PHP >= 5 ) CGI
    
> About

	Scheduler the operation mode by CGI.

	Yield function with CURL support.
	
> Learning Documents
	
	Please read `readme.php` document.
	
> Example : demo

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
