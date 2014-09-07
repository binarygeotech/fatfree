<?php

/*
<<<<<<< HEAD
	Copyright (c) 2009-2014 F3::Factory/Bong Cosca, All rights reserved.
=======
	Copyright (c) 2009-2012 F3::Factory/Bong Cosca, All rights reserved.
>>>>>>> 3.0.4 release

	This file is part of the Fat-Free Framework (http://fatfree.sf.net).

	THE SOFTWARE AND DOCUMENTATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF
	ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
	IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR
	PURPOSE.

	Please see the license.txt file for more information.
*/

//! Custom logger
class Log {

	protected
		//! File name
		$file;

	/**
<<<<<<< HEAD
	*	Write specified text to log file
	*	@return string
	*	@param $text string
	*	@param $format string
=======
		Write specified text to log file
		@return string
		@param $text string
		@param $format string
>>>>>>> 3.0.4 release
	**/
	function write($text,$format='r') {
		$fw=Base::instance();
		$fw->write(
			$this->file,
			date($format).
				(isset($_SERVER['REMOTE_ADDR'])?
					(' ['.$_SERVER['REMOTE_ADDR'].']'):'').' '.
			trim($text).PHP_EOL,
			TRUE
		);
	}

	/**
<<<<<<< HEAD
	*	Erase log
	*	@return NULL
=======
		Erase log
		@return NULL
>>>>>>> 3.0.4 release
	**/
	function erase() {
		@unlink($this->file);
	}

	/**
<<<<<<< HEAD
	*	Instantiate class
	*	@param $file string
=======
		Instantiate class
		@param $file string
>>>>>>> 3.0.4 release
	**/
	function __construct($file) {
		$fw=Base::instance();
		if (!is_dir($dir=$fw->get('LOGS')))
			mkdir($dir,Base::MODE,TRUE);
		$this->file=$dir.$file;
	}

}
