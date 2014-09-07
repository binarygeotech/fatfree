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

//! Unit test kit
class Test {

<<<<<<< HEAD
	//@{ Reporting level
	const
		FLAG_False=0,
		FLAG_True=1,
		FLAG_Both=2;
	//@}

	protected
=======
	private
>>>>>>> 3.0.4 release
		//! Test results
		$data=array();

	/**
<<<<<<< HEAD
	*	Return test results
	*	@return array
=======
		Return test results
		@return array
>>>>>>> 3.0.4 release
	**/
	function results() {
		return $this->data;
	}

	/**
<<<<<<< HEAD
	*	Evaluate condition and save test result
	*	@return object
	*	@param $cond bool
	*	@param $text string
	**/
	function expect($cond,$text=NULL) {
		$out=(bool)$cond;
		if ($this->level==$out || $this->level==self::FLAG_Both) {
			$data=array('status'=>$out,'text'=>$text,'source'=>NULL);
			foreach (debug_backtrace() as $frame)
				if (isset($frame['file'])) {
					$data['source']=Base::instance()->
						fixslashes($frame['file']).':'.$frame['line'];
					break;
				}
			$this->data[]=$data;
		}
		return $this;
	}

	/**
	*	Append message to test results
	*	@return NULL
	*	@param $text string
=======
		Evaluate condition and save test result
		@return NULL
		@param $cond bool
		@param $text string
	**/
	function expect($cond,$text=NULL) {
		$out=(bool)$cond;
		foreach (debug_backtrace() as $frame)
			if (isset($frame['file'])) {
				$this->data[]=array(
					'status'=>$out,
					'text'=>$text,
					'source'=>Base::instance()->
						fixslashes($frame['file']).':'.$frame['line']
				);
				break;
			}
	}

	/**
		Push message to test results
		@return NULL
		@param $text string
>>>>>>> 3.0.4 release
	**/
	function message($text) {
		$this->expect(TRUE,$text);
	}

<<<<<<< HEAD
	/**
	*	Class constructor
	*	@return NULL
	*	@param $level int
	**/
	function __construct($level=self::FLAG_Both) {
		$this->level=$level;
	}

=======
>>>>>>> 3.0.4 release
}
