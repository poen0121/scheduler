<?php
if (!class_exists('hpl_scheduler')) {
	include (strtr(dirname(__FILE__), '\\', '/') . '/system/path/main.inc.php');
	/**
	 * @about - scheduler the operation mode.
	 */
	class hpl_scheduler {
		/** A generator function.
		 * @access - public function
		 * @param - string $scriptName (script name)
		 * @return - boolean|error
		 * @usage - hpl_scheduler::yield($scriptName);
		 */
		public static function yield($scriptName = null) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: string2error(0)) {
				if (hpl_path :: is_absolute($scriptName) || !hpl_path :: is_files($scriptName) || (!hpl_path :: is_root_model($scriptName) && !hpl_path :: is_relative($scriptName))) {
					hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Invalid argument', E_USER_WARNING, 1);
				} else {
					$url = hpl_path :: absolute($scriptName);
					if ($url !== false) {
						$ch = curl_init();
						if (strpos($url, 'https://', 0) === 0) { //SSL
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
							curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
						}
						// set URL and other appropriate options
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_HEADER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
						curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
						curl_setopt($ch, CURLOPT_TIMEOUT, 3);
						curl_exec($ch);
						$http_error = curl_getinfo($ch, CURLINFO_HTTP_CODE);
						$curl_error = curl_errno($ch);
						$result = (!$curl_error && $http_error !== 200 ? false : (!$curl_error || $curl_error === 28 ? true : false));
						if (!$result) {
							hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): ' . (!$curl_error ? 'HTTP [' . $http_error . '] ' : 'CURL [' . $curl_error . '] ') . 'initiate failed for ' . hpl_path :: norm($scriptName), E_USER_WARNING, 1);
						}
						curl_close($ch);
						return $result;
					}
				}
			}
			return false;
		}
		/** The scheduler command for the script.
		 * @access - public function
		 * @param - boolean $switch (open or close the script) : Default false
		 * @note - $switch `true` is open the schedule script.
		 * @note - $switch `false` is close the schedule script.
		 * @param - integer $interval (by the switch to open the interval the number of minutes 1 ~ 31536000) : Default 1
		 * @return - boolean
		 * @usage - hpl_scheduler::command($switch,$interval);
		 */
		public static function command($switch = false, $interval = 1) {
			if (!hpl_func_arg :: delimit2error() && !hpl_func_arg :: bool2error(0) && !hpl_func_arg :: int2error(1)) {
				if ($interval < 1 || $interval > 31536000) {
					hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): The parameter 2 number should be 1 ~ 31536000', E_USER_WARNING, 1);
				}
				elseif (!isset ($_SERVER['SCRIPT_NAME']) || (isset ($_SERVER['SCRIPT_NAME']) && !is_string($_SERVER['SCRIPT_NAME']))) {
					hpl_error :: cast(__CLASS__ . '::' . __FUNCTION__ . '(): Can not capture the current script name', E_USER_ERROR, 1);
				}
				elseif ($switch) {
					ignore_user_abort(1); //run script in background
					set_time_limit(0); //run script forever
					sleep($interval * 60); //interval time
					//note : this function does not capture the actual location of debug_backtrace [file,line]
					register_shutdown_function(__CLASS__ . '::yield', $_SERVER['SCRIPT_NAME']);
					return true;
				}
			}
			return false;
		}
	}
}
?>