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

//! MongoDB wrapper
<<<<<<< HEAD
class Mongo {
=======
class Mongo extends \MongoDB {
>>>>>>> 3.0.4 release

	//@{
	const
		E_Profiler='MongoDB profiler is disabled';
	//@}

<<<<<<< HEAD
	protected
		//! UUID
		$uuid,
		//! Data source name
		$dsn,
		//! MongoDB object
		$db,
=======
	private
>>>>>>> 3.0.4 release
		//! MongoDB log
		$log;

	/**
<<<<<<< HEAD
	*	Return data source name
	*	@return string
	**/
	function dsn() {
		return $this->dsn;
	}

	/**
	*	Return UUID
	*	@return string
	**/
	function uuid() {
		return $this->uuid;
	}

	/**
	*	Return MongoDB profiler results
	*	@return string
	**/
	function log() {
=======
		Return MongoDB profiler results
		@return string
	**/
	function log() {
		$fw=\Base::instance();
>>>>>>> 3.0.4 release
		$cursor=$this->selectcollection('system.profile')->find();
		foreach (iterator_to_array($cursor) as $frame)
			if (!preg_match('/\.system\..+$/',$frame['ns']))
				$this->log.=date('r',$frame['ts']->sec).' ('.
					sprintf('%.1f',$frame['millis']).'ms) '.
					$frame['ns'].' ['.$frame['op'].'] '.
					(empty($frame['query'])?
						'':json_encode($frame['query'])).
					(empty($frame['command'])?
						'':json_encode($frame['command'])).
					PHP_EOL;
		return $this->log;
	}

	/**
<<<<<<< HEAD
	*	Intercept native call to re-enable profiler
	*	@return int
	**/
	function drop() {
		$out=$this->db->drop();
=======
		Intercept native call to re-enable profiler
		@return int
	**/
	function drop() {
		$out=parent::drop();
>>>>>>> 3.0.4 release
		$this->setprofilinglevel(2);
		return $out;
	}

	/**
<<<<<<< HEAD
	*	Redirect call to MongoDB object
	*	@return mixed
	*	@param $func string
	*	@param $args array
	**/
	function __call($func,array $args) {
		return call_user_func_array(array($this->db,$func),$args);
	}

	/**
	*	Instantiate class
	*	@param $dsn string
	*	@param $dbname string
	*	@param $options array
	**/
	function __construct($dsn,$dbname,array $options=NULL) {
		$this->uuid=\Base::instance()->hash($this->dsn=$dsn);
		$class=class_exists('\MongoClient')?'\MongoClient':'\Mongo';
		$this->db=new \MongoDB(new $class($dsn,$options?:array()),$dbname);
=======
		Instantiate class
		@param $dsn string
		@param $dbname string
		@param $options array
	**/
	function __construct($dsn,$dbname,array $options=NULL) {
		$class=class_exists('\MongoClient')?'\MongoClient':'\Mongo';
		parent::__construct(new $class($dsn,$options?:array()),$dbname);
>>>>>>> 3.0.4 release
		$this->setprofilinglevel(2);
	}

}
