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

//! PHP magic wrapper
abstract class Magic implements ArrayAccess {

	/**
<<<<<<< HEAD
	*	Return TRUE if key is not empty
	*	@return bool
	*	@param $key string
=======
		Return TRUE if key is not empty
		@return bool
		@param $key string
>>>>>>> 3.0.4 release
	**/
	abstract function exists($key);

	/**
<<<<<<< HEAD
	*	Bind value to key
	*	@return mixed
	*	@param $key string
	*	@param $val mixed
=======
		Bind value to key
		@return mixed
		@param $key string
		@param $val mixed
>>>>>>> 3.0.4 release
	**/
	abstract function set($key,$val);

	/**
<<<<<<< HEAD
	*	Retrieve contents of key
	*	@return mixed
	*	@param $key string
	**/
	abstract function &get($key);

	/**
	*	Unset key
	*	@return NULL
	*	@param $key string
=======
		Retrieve contents of key
		@return mixed
		@param $key string
	**/
	abstract function get($key);

	/**
		Unset key
		@return NULL
		@param $key string
>>>>>>> 3.0.4 release
	**/
	abstract function clear($key);

	/**
<<<<<<< HEAD
	*	Convenience method for checking property value
	*	@return mixed
	*	@param $key string
	**/
	function offsetexists($key) {
		return Base::instance()->visible($this,$key)?
			isset($this->$key):$this->exists($key);
	}

	/**
	*	Convenience method for assigning property value
	*	@return mixed
	*	@param $key string
	*	@param $val scalar
	**/
	function offsetset($key,$val) {
		return Base::instance()->visible($this,$key)?
			($this->key=$val):$this->set($key,$val);
	}

	/**
	*	Convenience method for retrieving property value
	*	@return mixed
	*	@param $key string
	**/
	function &offsetget($key) {
		if (Base::instance()->visible($this,$key))
			$val=&$this->$key;
		else
			$val=&$this->get($key);
		return $val;
	}

	/**
	*	Convenience method for removing property value
	*	@return NULL
	*	@param $key string
	**/
	function offsetunset($key) {
		if (Base::instance()->visible($this,$key))
			unset($this->$key);
		else
			$this->clear($key);
	}

	/**
	*	Alias for offsetexists()
	*	@return mixed
	*	@param $key string
	**/
	function __isset($key) {
		return $this->offsetexists($key);
	}

	/**
	*	Alias for offsetset()
	*	@return mixed
	*	@param $key string
	*	@param $val scalar
	**/
	function __set($key,$val) {
		return $this->offsetset($key,$val);
	}

	/**
	*	Alias for offsetget()
	*	@return mixed
	*	@param $key string
	**/
	function &__get($key) {
		$val=&$this->offsetget($key);
		return $val;
	}

	/**
	*	Alias for offsetunset()
	*	@return NULL
	*	@param $key string
=======
		Return TRUE if property has public visibility
		@return bool
		@param $Key string
	**/
	private function visible($key) {
		if (property_exists($this,$key)) {
			$ref=new \ReflectionProperty(get_class($this),$key);
			$out=$ref->ispublic();
			unset($ref);
			return $out;
		}
		return FALSE;
	}

	/**
		Convenience method for checking property value
		@return mixed
		@param $key string
	**/
	function offsetexists($key) {
		return $this->visible($key)?isset($this->$key):$this->exists($key);
	}

	/**
		Alias for offsetexists()
		@return mixed
		@param $key string
	**/
	function __isset($key) {
		return $this->offsetexists($key);
	}

	/**
		Convenience method for assigning property value
		@return mixed
		@param $key string
		@param $val scalar
	**/
	function offsetset($key,$val) {
		return $this->visible($key)?($this->key=$val):$this->set($key,$val);
	}

	/**
		Alias for offsetset()
		@return mixed
		@param $key string
		@param $val scalar
	**/
	function __set($key,$val) {
		return $this->offsetset($key,$val);
	}

	/**
		Convenience method for retrieving property value
		@return mixed
		@param $key string
	**/
	function offsetget($key) {
		return $this->visible($key)?$this->$key:$this->get($key);
	}

	/**
		Alias for offsetget()
		@return mixed
		@param $key string
	**/
	function __get($key) {
		return $this->offsetget($key);
	}

	/**
		Convenience method for checking property value
		@return NULL
		@param $key string
	**/
	function offsetunset($key) {
		if ($this->visible($key))
			unset($this->$key);
		else
			$this->clear($key);
	}

	/**
		Alias for offsetunset()
		@return NULL
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function __unset($key) {
		$this->offsetunset($key);
	}

}
