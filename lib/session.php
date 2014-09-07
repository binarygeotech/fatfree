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

//! Cache-based session handler
class Session {

<<<<<<< HEAD
	protected
		//! Session ID
		$sid;

	/**
	*	Open session
	*	@return TRUE
	*	@param $path string
	*	@param $name string
=======
	/**
		Open session
		@return TRUE
		@param $path string
		@param $name string
>>>>>>> 3.0.4 release
	**/
	function open($path,$name) {
		return TRUE;
	}

	/**
<<<<<<< HEAD
	*	Close session
	*	@return TRUE
=======
		Close session
		@return TRUE
>>>>>>> 3.0.4 release
	**/
	function close() {
		return TRUE;
	}

	/**
<<<<<<< HEAD
	*	Return session data in serialized format
	*	@return string|FALSE
	*	@param $id string
	**/
	function read($id) {
		if ($id!=$this->sid)
			$this->sid=$id;
=======
		Return session data in serialized format
		@return string|FALSE
		@param $id string
	**/
	function read($id) {
>>>>>>> 3.0.4 release
		return Cache::instance()->exists($id.'.@',$data)?$data['data']:FALSE;
	}

	/**
<<<<<<< HEAD
	*	Write session data
	*	@return TRUE
	*	@param $id string
	*	@param $data string
	**/
	function write($id,$data) {
		$fw=Base::instance();
		$sent=headers_sent();
		$headers=$fw->get('HEADERS');
		$csrf=$fw->hash($fw->get('ROOT').$fw->get('BASE')).'.'.
			$fw->hash(mt_rand());
		$jar=$fw->get('JAR');
		if ($id!=$this->sid)
			$this->sid=$id;
		Cache::instance()->set($id.'.@',
			array(
				'data'=>$data,
				'csrf'=>$sent?$this->csrf():$csrf,
=======
		Write session data
		@return TRUE
		@param $id string
		@param $data string
	**/
	function write($id,$data) {
		$fw=Base::instance();
		$headers=$fw->get('HEADERS');
		$jar=session_get_cookie_params();
		Cache::instance()->set($id.'.@',
			array(
				'data'=>$data,
>>>>>>> 3.0.4 release
				'ip'=>$fw->get('IP'),
				'agent'=>isset($headers['User-Agent'])?
					$headers['User-Agent']:'',
				'stamp'=>time()
			),
<<<<<<< HEAD
			$jar['expire']?($jar['expire']-time()):0
=======
			$jar['lifetime']
>>>>>>> 3.0.4 release
		);
		return TRUE;
	}

	/**
<<<<<<< HEAD
	*	Destroy session
	*	@return TRUE
	*	@param $id string
	**/
	function destroy($id) {
		Cache::instance()->clear($id.'.@');
		setcookie(session_name(),'',strtotime('-1 year'));
		unset($_COOKIE[session_name()]);
		header_remove('Set-Cookie');
=======
		Destroy session
		@return TRUE
		@param $id string
	**/
	function destroy($id) {
		Cache::instance()->clear($id.'.@');
>>>>>>> 3.0.4 release
		return TRUE;
	}

	/**
<<<<<<< HEAD
	*	Garbage collector
	*	@return TRUE
	*	@param $max int
=======
		Garbage collector
		@return TRUE
		@param $max int
>>>>>>> 3.0.4 release
	**/
	function cleanup($max) {
		Cache::instance()->reset('.@',$max);
		return TRUE;
	}

	/**
<<<<<<< HEAD
	*	Return anti-CSRF token
	*	@return string|FALSE
	**/
	function csrf() {
		return Cache::instance()->
			exists(($this->sid?:session_id()).'.@',$data)?
				$data['csrf']:FALSE;
	}

	/**
	*	Return IP address
	*	@return string|FALSE
	**/
	function ip() {
		return Cache::instance()->
			exists(($this->sid?:session_id()).'.@',$data)?
				$data['ip']:FALSE;
	}

	/**
	*	Return Unix timestamp
	*	@return string|FALSE
	**/
	function stamp() {
		return Cache::instance()->
			exists(($this->sid?:session_id()).'.@',$data)?
				$data['stamp']:FALSE;
	}

	/**
	*	Return HTTP user agent
	*	@return string|FALSE
	**/
	function agent() {
		return Cache::instance()->
			exists(($this->sid?:session_id()).'.@',$data)?
				$data['agent']:FALSE;
	}

	/**
	*	Instantiate class
	*	@return object
=======
		Return IP address associated with specified session ID
		@return string|FALSE
		@param $id string
	**/
	function ip($id=NULL) {
		return Cache::instance()->exists(($id?:session_id()).'.@',$data)?
			$data['ip']:FALSE;
	}

	/**
		Return Unix timestamp associated with specified session ID
		@return string|FALSE
		@param $id string
	**/
	function stamp($id=NULL) {
		return Cache::instance()->exists(($id?:session_id()).'.@',$data)?
			$data['stamp']:FALSE;
	}

	/**
		Return HTTP user agent associated with specified session ID
		@return string|FALSE
		@param $id string
	**/
	function agent($id=NULL) {
		return Cache::instance()->exists(($id?:session_id()).'.@',$data)?
			$data['agent']:FALSE;
	}

	/**
		Instantiate class
		@return object
>>>>>>> 3.0.4 release
	**/
	function __construct() {
		session_set_save_handler(
			array($this,'open'),
			array($this,'close'),
			array($this,'read'),
			array($this,'write'),
			array($this,'destroy'),
			array($this,'cleanup')
		);
		register_shutdown_function('session_commit');
<<<<<<< HEAD
		@session_start();
		$fw=\Base::instance();
		$headers=$fw->get('HEADERS');
		if (($ip=$this->ip()) && $ip!=$fw->get('IP') ||
			($agent=$this->agent()) &&
			(!isset($headers['User-Agent']) ||
				$agent!=$headers['User-Agent'])) {
			session_destroy();
			\Base::instance()->error(403);
		}
		$csrf=$fw->hash($fw->get('ROOT').$fw->get('BASE')).'.'.
			$fw->hash(mt_rand());
		$jar=$fw->get('JAR');
		if (Cache::instance()->exists(($this->sid=session_id()).'.@',$data)) {
			$data['csrf']=$csrf;
			Cache::instance()->set($this->sid.'.@',
				$data,
				$jar['expire']?($jar['expire']-time()):0
			);
		}
=======
>>>>>>> 3.0.4 release
	}

}
