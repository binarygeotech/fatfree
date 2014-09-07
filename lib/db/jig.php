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

namespace DB;

//! Flat-file DB wrapper
class Jig {

	//@{ Storage formats
	const
		FORMAT_JSON=0,
		FORMAT_Serialized=1;
	//@}

	protected
<<<<<<< HEAD
		//! UUID
		$uuid,
=======
>>>>>>> 3.0.4 release
		//! Storage location
		$dir,
		//! Current storage format
		$format,
		//! Jig log
		$log;

	/**
<<<<<<< HEAD
	*	Read data from file
	*	@return array
	*	@param $file string
	**/
	function read($file) {
=======
		Read data from file
		@return array
		@param $file string
		@param $frame string
	**/
	function read($file,$frame=NULL) {
>>>>>>> 3.0.4 release
		$fw=\Base::instance();
		if (!is_file($dst=$this->dir.$file))
			return array();
		$raw=$fw->read($dst);
		switch ($this->format) {
			case self::FORMAT_JSON:
				$data=json_decode($raw,TRUE);
				break;
			case self::FORMAT_Serialized:
				$data=$fw->unserialize($raw);
				break;
		}
		return $data;
	}

	/**
<<<<<<< HEAD
	*	Write data to file
	*	@return int
	*	@param $file string
	*	@param $data array
	**/
	function write($file,array $data=NULL) {
=======
		Write data to file
		@return int
		@param $file string
		@param $data array
		@param $frame string
	**/
	function write($file,array $data=NULL,$frame=NULL) {
>>>>>>> 3.0.4 release
		$fw=\Base::instance();
		switch ($this->format) {
			case self::FORMAT_JSON:
				$out=json_encode($data,@constant('JSON_PRETTY_PRINT'));
				break;
			case self::FORMAT_Serialized:
				$out=$fw->serialize($data);
				break;
		}
<<<<<<< HEAD
		return $fw->write($this->dir.$file,$out);
	}

	/**
	*	Return directory
	*	@return string
	**/
	function dir() {
		return $this->dir;
	}

	/**
	*	Return UUID
	*	@return string
	**/
	function uuid() {
		return $this->uuid;
	}

	/**
	*	Return SQL profiler results
	*	@return string
=======
		$out=$fw->write($this->dir.$file,$out);
		return $out;
	}

	/**
		Return SQL profiler results
		@return string
>>>>>>> 3.0.4 release
	**/
	function log() {
		return $this->log;
	}

	/**
<<<<<<< HEAD
	*	Jot down log entry
	*	@return NULL
	*	@param $frame string
=======
		Jot down log entry
		@return NULL
		@param $frame string
>>>>>>> 3.0.4 release
	**/
	function jot($frame) {
		if ($frame)
			$this->log.=date('r').' '.$frame.PHP_EOL;
	}

	/**
<<<<<<< HEAD
	*	Clean storage
	*	@return NULL
	**/
	function drop() {
		if ($glob=@glob($this->dir.'/*',GLOB_NOSORT))
			foreach ($glob as $file)
				@unlink($file);
	}

	/**
	*	Instantiate class
	*	@param $dir string
	*	@param $format int
=======
		Clean storage
		@return NULL
	**/
	function drop() {
		foreach (glob($this->dir.'/*',GLOB_NOSORT) as $file)
			@unlink($file);
	}

	/**
		Instantiate class
		@param $dir string
		@param $format int
>>>>>>> 3.0.4 release
	**/
	function __construct($dir,$format=self::FORMAT_JSON) {
		if (!is_dir($dir))
			mkdir($dir,\Base::MODE,TRUE);
<<<<<<< HEAD
		$this->uuid=\Base::instance()->hash($this->dir=$dir);
=======
		$this->dir=$dir;
>>>>>>> 3.0.4 release
		$this->format=$format;
	}

}
