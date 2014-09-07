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

//! Session-based pseudo-mapper
class Basket {

<<<<<<< HEAD
	//@{ Error messages
	const
		E_Field='Undefined field %s';
	//@}

=======
>>>>>>> 3.0.4 release
	protected
		//! Session key
		$key,
		//! Current item identifier
		$id,
		//! Current item contents
		$item=array();

	/**
<<<<<<< HEAD
	*	Return TRUE if field is defined
	*	@return bool
	*	@param $key string
=======
		Return TRUE if field is defined
		@return bool
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function exists($key) {
		return array_key_exists($key,$this->item);
	}

	/**
<<<<<<< HEAD
	*	Assign value to field
	*	@return scalar|FALSE
	*	@param $key string
	*	@param $val scalar
=======
		Assign value to field
		@return scalar|FALSE
		@param $key string
		@param $val scalar
>>>>>>> 3.0.4 release
	**/
	function set($key,$val) {
		return ($key=='_id')?FALSE:($this->item[$key]=$val);
	}

	/**
<<<<<<< HEAD
	*	Retrieve value of field
	*	@return scalar|FALSE
	*	@param $key string
=======
		Retrieve value of field
		@return scalar|FALSE
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function get($key) {
		if ($key=='_id')
			return $this->id;
		if (array_key_exists($key,$this->item))
			return $this->item[$key];
		user_error(sprintf(self::E_Field,$key));
		return FALSE;
	}

	/**
<<<<<<< HEAD
	*	Delete field
	*	@return NULL
	*	@param $key string
=======
		Delete field
		@return NULL
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function clear($key) {
		unset($this->item[$key]);
	}

	/**
<<<<<<< HEAD
	*	Return items that match key/value pair;
	*	If no key/value pair specified, return all items
	*	@return array|FALSE
	*	@param $key string
	*	@param $val mixed
	**/
	function find($key=NULL,$val=NULL) {
		if (isset($_SESSION[$this->key])) {
			$out=array();
			foreach ($_SESSION[$this->key] as $id=>$item)
				if (!isset($key) ||
					array_key_exists($key,$item) && $item[$key]==$val) {
					$obj=clone($this);
					$obj->id=$id;
					$obj->item=$item;
					$out[]=$obj;
				}
			return $out;
		}
=======
		Return item that matches key/value pair
		@return object|FALSE
		@param $key string
		@param $val mixed
	**/
	function find($key,$val) {
		if (isset($_SESSION[$this->key]))
			foreach ($_SESSION[$this->key] as $id=>$item)
				if ($item[$key]==$val) {
					$obj=clone($this);
					$obj->id=$id;
					$obj->item=$item;
					return $obj;
				}
>>>>>>> 3.0.4 release
		return FALSE;
	}

	/**
<<<<<<< HEAD
	*	Return first item that matches key/value pair
	*	@return object|FALSE
	*	@param $key string
	*	@param $val mixed
	**/
	function findone($key,$val) {
		return ($data=$this->find($key,$val))?$data[0]:FALSE;
	}

	/**
	*	Map current item to matching key/value pair
	*	@return array
	*	@param $key string
	*	@param $val mixed
	**/
	function load($key,$val) {
		if ($found=$this->find($key,$val)) {
			$this->id=$found[0]->id;
			return $this->item=$found[0]->item;
=======
		Map current item to matching key/value pair
		@return array
		@param $key string
		@param $val mixed
	**/
	function load($key,$val) {
		if ($found=$this->find($key,$val)) {
			$this->id=$found->id;
			return $this->item=$found->item;
>>>>>>> 3.0.4 release
		}
		$this->reset();
		return array();
	}

	/**
<<<<<<< HEAD
	*	Return TRUE if current item is empty/undefined
	*	@return bool
=======
		Return TRUE if current item is empty/undefined
		@return bool
>>>>>>> 3.0.4 release
	**/
	function dry() {
		return !$this->item;
	}

	/**
<<<<<<< HEAD
	*	Return number of items in basket
	*	@return int
=======
		Return number of items in basket
		@return int
>>>>>>> 3.0.4 release
	**/
	function count() {
		return isset($_SESSION[$this->key])?count($_SESSION[$this->key]):0;
	}

	/**
<<<<<<< HEAD
	*	Save current item
	*	@return array
	**/
	function save() {
		if (!$this->id)
			$this->id=uniqid(NULL,TRUE);
		$_SESSION[$this->key][$this->id]=$this->item;
		return $this->item;
	}

	/**
	*	Erase item matching key/value pair
	*	@return bool
	*	@param $key string
	*	@param $val mixed
	**/
	function erase($key,$val) {
		$found=$this->find($key,$val);
		if ($found && $id=$found[0]->id) {
=======
		Save current item
		@return array
	**/
	function save() {
		if (!$this->id)
			$this->id=uniqid();
		return $_SESSION[$this->key][$this->id]=$this->item;
	}

	/**
		Erase item matching key/value pair
		@return bool
		@param $key string
		@param $val mixed
	**/
	function erase($key,$val) {
		if ($id=$this->find($key,$val)->id) {
>>>>>>> 3.0.4 release
			unset($_SESSION[$this->key][$id]);
			if ($id==$this->id)
				$this->reset();
			return TRUE;
		}
		return FALSE;
	}

	/**
<<<<<<< HEAD
	*	Reset cursor
	*	@return NULL
=======
		Reset cursor
		@return NULL
>>>>>>> 3.0.4 release
	**/
	function reset() {
		$this->id=NULL;
		$this->item=array();
	}

	/**
<<<<<<< HEAD
	*	Empty basket
	*	@return NULL
=======
		Empty basket
		@return NULL
>>>>>>> 3.0.4 release
	**/
	function drop() {
		unset($_SESSION[$this->key]);
	}

	/**
<<<<<<< HEAD
	*	Hydrate item using hive array variable
	*	@return NULL
	*	@param $key string
=======
		Hydrate item using hive array variable
		@return NULL
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function copyfrom($key) {
		foreach (\Base::instance()->get($key) as $key=>$val)
			$this->item[$key]=$val;
	}

	/**
<<<<<<< HEAD
	*	Populate hive array variable with item contents
	*	@return NULL
	*	@param $key string
=======
		Populate hive array variable with item contents
		@return NULL
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function copyto($key) {
		$var=&\Base::instance()->ref($key);
		foreach ($this->item as $key=>$field)
			$var[$key]=$field;
	}

	/**
<<<<<<< HEAD
	*	Check out basket contents
	*	@return array
=======
		Check out basket contents
		@return array
>>>>>>> 3.0.4 release
	**/
	function checkout() {
		if (isset($_SESSION[$this->key])) {
			$out=$_SESSION[$this->key];
			unset($_SESSION[$this->key]);
			return $out;
		}
		return array();
	}

	/**
<<<<<<< HEAD
	*	Instantiate class
	*	@return void
	*	@param $key string
=======
		Instantiate class
		@return void
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function __construct($key='basket') {
		$this->key=$key;
		@session_start();
		Base::instance()->sync('SESSION');
		$this->reset();
	}

}
