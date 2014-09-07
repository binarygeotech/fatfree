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

//! Simple cursor implementation
abstract class Cursor extends \Magic {

	//@{ Error messages
	const
		E_Field='Undefined field %s';
	//@}

	protected
		//! Query results
		$query=array(),
		//! Current position
<<<<<<< HEAD
		$ptr=0,
		//! Event listeners
		$trigger=array();

	/**
	*	Return database type
	*	@return string
	**/
	abstract function dbtype();

	/**
	*	Return fields of mapper object as an associative array
	*	@return array
	*	@param $obj object
=======
		$ptr=0;

	/**
		Return fields of mapper object as an associative array
		@return array
		@param $obj object
>>>>>>> 3.0.4 release
	**/
	abstract function cast($obj=NULL);

	/**
<<<<<<< HEAD
	*	Return records (array of mapper objects) that match criteria
	*	@return array
	*	@param $filter string|array
	*	@param $options array
	*	@param $ttl int
	**/
	abstract function find($filter=NULL,array $options=NULL,$ttl=0);

	/**
	*	Count records that match criteria
	*	@return int
	*	@param $filter array
	*	@param $ttl int
	**/
	abstract function count($filter=NULL,$ttl=0);

	/**
	*	Insert new record
	*	@return array
=======
		Return records (array of mapper objects) that match criteria
		@return array
		@param $filter string|array
		@param $options array
	**/
	abstract function find($filter=NULL,array $options=NULL);

	/**
		Insert new record
		@return array
>>>>>>> 3.0.4 release
	**/
	abstract function insert();

	/**
<<<<<<< HEAD
	*	Update current record
	*	@return array
=======
		Update current record
		@return array
>>>>>>> 3.0.4 release
	**/
	abstract function update();

	/**
<<<<<<< HEAD
	*	Hydrate mapper object using hive array variable
	*	@return NULL
	*	@param $key string
	*	@param $func callback
	**/
	abstract function copyfrom($key,$func=NULL);

	/**
	*	Populate hive array variable with mapper fields
	*	@return NULL
	*	@param $key string
	**/
	abstract function copyto($key);

	/**
	*	Return TRUE if current cursor position is not mapped to any record
	*	@return bool
	**/
	function dry() {
		return empty($this->query[$this->ptr]);
	}

	/**
	*	Return first record (mapper object) that matches criteria
	*	@return object|FALSE
	*	@param $filter string|array
	*	@param $options array
	*	@param $ttl int
	**/
	function findone($filter=NULL,array $options=NULL,$ttl=0) {
		return ($data=$this->find($filter,$options,$ttl))?$data[0]:FALSE;
	}

	/**
	*	Return array containing subset of records matching criteria,
	*	total number of records in superset, specified limit, number of
	*	subsets available, and actual subset position
	*	@return array
	*	@param $pos int
	*	@param $size int
	*	@param $filter string|array
	*	@param $options array
	*	@param $ttl int
	**/
	function paginate(
		$pos=0,$size=10,$filter=NULL,array $options=NULL,$ttl=0) {
		$total=$this->count($filter,$ttl);
		$count=ceil($total/$size);
		$pos=max(0,min($pos,$count-1));
=======
		Return TRUE if current cursor position is not mapped to any record
		@return bool
	**/
	function dry() {
		return empty($this->query[$this->ptr]);
	}

	/**
		Return first record (mapper object) that matches criteria
		@return object|FALSE
		@param $filter string|array
		@param $options array
	**/
	function findone($filter=NULL,array $options=NULL) {
		return ($data=$this->find($filter,$options))?$data[0]:FALSE;
	}

	/**
		Return records (array of associative arrays) that match criteria
		@return array
		@param $filter string|array
		@param $options array
	**/
	function afind($filter=NULL,array $options=NULL) {
		return array_map(array($this,'cast'),$this->find($filter,$options));
	}

	/**
		Return first record (associative array) that matches criteria
		@return array|FALSE
		@param $filter string|array
		@param $options array
	**/
	function afindone($filter=NULL,array $options=NULL) {
		return ($found=$this->findone($filter,$options))?
			$found->cast():FALSE;
	}

	/**
		Return array containing subset of records matching criteria,
		number of subsets available, and actual subset position
		@return array
		@param $pos int
		@param $size int
		@param $filter string|array
		@param $options array
	**/
	function paginate($pos=0,$size=10,$filter=NULL,array $options=NULL) {
>>>>>>> 3.0.4 release
		return array(
			'subset'=>$this->find($filter,
				array_merge(
					$options?:array(),
					array('limit'=>$size,'offset'=>$pos*$size)
<<<<<<< HEAD
				),
				$ttl
			),
			'total'=>$total,
			'limit'=>$size,
			'count'=>$count,
			'pos'=>$pos<$count?$pos:0
=======
				)
			),
			'count'=>($count=ceil($this->count($filter,$options)/$size)),
			'pos'=>($pos && $pos<$count?$pos:NULL)
>>>>>>> 3.0.4 release
		);
	}

	/**
<<<<<<< HEAD
	*	Map to first record that matches criteria
	*	@return array|FALSE
	*	@param $filter string|array
	*	@param $options array
	*	@param $ttl int
	**/
	function load($filter=NULL,array $options=NULL,$ttl=0) {
		return ($this->query=$this->find($filter,$options,$ttl)) &&
=======
		Map to first record that matches criteria
		@return array|FALSE
		@param $filter string|array
		@param $options array
	**/
	function load($filter=NULL,array $options=NULL) {
		return ($this->query=$this->find($filter,$options)) &&
>>>>>>> 3.0.4 release
			$this->skip(0)?$this->query[$this->ptr=0]:FALSE;
	}

	/**
<<<<<<< HEAD
	*	Return the count of records loaded
	*	@return int
	**/
	function loaded() {
		return count($this->query);
	}

	/**
	*	Map to first record in cursor
	*	@return mixed
	**/
	function first() {
		return $this->skip(-$this->ptr);
	}

	/**
	*	Map to last record in cursor
	*	@return mixed
	**/
	function last() {
		return $this->skip(($ofs=count($this->query)-$this->ptr)?$ofs-1:0);
	}

	/**
	*	Map to nth record relative to current cursor position
	*	@return mixed
	*	@param $ofs int
=======
		Move pointer to first record in cursor
		@return mixed
	**/
	function first() {
		return $this->query[$this->ptr=0];
	}

	/**
		Move pointer to last record in cursor
		@return mixed
	**/
	function last() {
		return $this->query[$this->ptr=($ctr=count($this->query))?$ctr-1:0];
	}

	/**
		Map to nth record relative to current cursor position
		@return mixed
		@param $ofs int
>>>>>>> 3.0.4 release
	**/
	function skip($ofs=1) {
		$this->ptr+=$ofs;
		return $this->ptr>-1 && $this->ptr<count($this->query)?
			$this->query[$this->ptr]:FALSE;
	}

	/**
<<<<<<< HEAD
	*	Map next record
	*	@return mixed
=======
		Map next record
		@return mixed
>>>>>>> 3.0.4 release
	**/
	function next() {
		return $this->skip();
	}

	/**
<<<<<<< HEAD
	*	Map previous record
	*	@return mixed
=======
		Map previous record
		@return mixed
>>>>>>> 3.0.4 release
	**/
	function prev() {
		return $this->skip(-1);
	}

	/**
<<<<<<< HEAD
	*	Save mapped record
	*	@return mixed
=======
		Save mapped record
		@return mixed
>>>>>>> 3.0.4 release
	**/
	function save() {
		return $this->query?$this->update():$this->insert();
	}

	/**
<<<<<<< HEAD
	*	Delete current record
	*	@return int|bool
=======
		Delete current record
		@return int|bool
>>>>>>> 3.0.4 release
	**/
	function erase() {
		$this->query=array_slice($this->query,0,$this->ptr,TRUE)+
			array_slice($this->query,$this->ptr,NULL,TRUE);
		$this->ptr=0;
	}

	/**
<<<<<<< HEAD
	*	Define onload trigger
	*	@return callback
	*	@param $func callback
	**/
	function onload($func) {
		return $this->trigger['load']=$func;
	}

	/**
	*	Define beforeinsert trigger
	*	@return callback
	*	@param $func callback
	**/
	function beforeinsert($func) {
		return $this->trigger['beforeinsert']=$func;
	}

	/**
	*	Define afterinsert trigger
	*	@return callback
	*	@param $func callback
	**/
	function afterinsert($func) {
		return $this->trigger['afterinsert']=$func;
	}

	/**
	*	Define oninsert trigger
	*	@return callback
	*	@param $func callback
	**/
	function oninsert($func) {
		return $this->afterinsert($func);
	}

	/**
	*	Define beforeupdate trigger
	*	@return callback
	*	@param $func callback
	**/
	function beforeupdate($func) {
		return $this->trigger['beforeupdate']=$func;
	}

	/**
	*	Define afterupdate trigger
	*	@return callback
	*	@param $func callback
	**/
	function afterupdate($func) {
		return $this->trigger['afterupdate']=$func;
	}

	/**
	*	Define onupdate trigger
	*	@return callback
	*	@param $func callback
	**/
	function onupdate($func) {
		return $this->afterupdate($func);
	}

	/**
	*	Define beforeerase trigger
	*	@return callback
	*	@param $func callback
	**/
	function beforeerase($func) {
		return $this->trigger['beforeerase']=$func;
	}

	/**
	*	Define aftererase trigger
	*	@return callback
	*	@param $func callback
	**/
	function aftererase($func) {
		return $this->trigger['aftererase']=$func;
	}

	/**
	*	Define onerase trigger
	*	@return callback
	*	@param $func callback
	**/
	function onerase($func) {
		return $this->aftererase($func);
	}

	/**
	*	Reset cursor
	*	@return NULL
=======
		Reset cursor
		@return NULL
>>>>>>> 3.0.4 release
	**/
	function reset() {
		$this->query=array();
		$this->ptr=0;
	}

}
