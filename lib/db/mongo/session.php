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

namespace DB\Mongo;

//! MongoDB-managed session handler
class Session extends Mapper {

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
			$this->load(array('session_id'=>$this->sid=$id));
=======
		Return session data in serialized format
		@return string|FALSE
		@param $id string
	**/
	function read($id) {
		$this->load(array('session_id'=>$id));
>>>>>>> 3.0.4 release
		return $this->dry()?FALSE:$this->get('data');
	}

	/**
<<<<<<< HEAD
	*	Write session data
	*	@return TRUE
	*	@param $id string
	*	@param $data string
	**/
	function write($id,$data) {
		$fw=\Base::instance();
		$sent=headers_sent();
		$headers=$fw->get('HEADERS');
		if ($id!=$this->sid)
			$this->load(array('session_id'=>$this->sid=$id));
		$csrf=$fw->hash($fw->get('ROOT').$fw->get('BASE')).'.'.
			$fw->hash(mt_rand());
		$this->set('session_id',$id);
		$this->set('data',$data);
		$this->set('csrf',$sent?$this->csrf():$csrf);
=======
		Write session data
		@return TRUE
		@param $id string
		@param $data string
	**/
	function write($id,$data) {
		$fw=\Base::instance();
		$headers=$fw->get('HEADERS');
		$this->load(array('session_id'=>$id));
		$this->set('session_id',$id);
		$this->set('data',$data);
>>>>>>> 3.0.4 release
		$this->set('ip',$fw->get('IP'));
		$this->set('agent',
			isset($headers['User-Agent'])?$headers['User-Agent']:'');
		$this->set('stamp',time());
		$this->save();
<<<<<<< HEAD
		if (!$sent) {
			if (isset($_COOKIE['_']))
				setcookie('_','',strtotime('-1 year'));
			call_user_func_array('setcookie',
				array('_',$csrf)+$fw->get('JAR'));
		}
=======
>>>>>>> 3.0.4 release
		return TRUE;
	}

	/**
<<<<<<< HEAD
	*	Destroy session
	*	@return TRUE
	*	@param $id string
	**/
	function destroy($id) {
		$this->erase(array('session_id'=>$id));
		setcookie(session_name(),'',strtotime('-1 year'));
		unset($_COOKIE[session_name()]);
		header_remove('Set-Cookie');
=======
		Destroy session
		@return TRUE
		@param $id string
	**/
	function destroy($id) {
		$this->erase(array('session_id'=>$id));
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
		$this->erase(array('$where'=>'this.stamp+'.$max.'<'.time()));
		return TRUE;
	}

	/**
<<<<<<< HEAD
	*	Return anti-CSRF token
	*	@return string|FALSE
	**/
	function csrf() {
		return $this->dry()?FALSE:$this->get('csrf');
	}

	/**
	*	Return IP address
	*	@return string|FALSE
	**/
	function ip() {
=======
		Return IP address associated with specified session ID
		@return string|FALSE
		@param $id string
	**/
	function ip($id=NULL) {
		$this->load(array('session_id'=>$id?:session_id()));
>>>>>>> 3.0.4 release
		return $this->dry()?FALSE:$this->get('ip');
	}

	/**
<<<<<<< HEAD
	*	Return Unix timestamp
	*	@return string|FALSE
	**/
	function stamp() {
=======
		Return Unix timestamp associated with specified session ID
		@return string|FALSE
		@param $id string
	**/
	function stamp($id=NULL) {
		$this->load(array('session_id'=>$id?:session_id()));
>>>>>>> 3.0.4 release
		return $this->dry()?FALSE:$this->get('stamp');
	}

	/**
<<<<<<< HEAD
	*	Return HTTP user agent
	*	@return string|FALSE
	**/
	function agent() {
=======
		Return HTTP user agent associated with specified session ID
		@return string|FALSE
		@param $id string
	**/
	function agent($id=NULL) {
		$this->load(array('session_id'=>$id?:session_id()));
>>>>>>> 3.0.4 release
		return $this->dry()?FALSE:$this->get('agent');
	}

	/**
<<<<<<< HEAD
	*	Instantiate class
	*	@param $db object
	*	@param $table string
=======
		Instantiate class
		@param $db object
		@param $table string
>>>>>>> 3.0.4 release
	**/
	function __construct(\DB\Mongo $db,$table='sessions') {
		parent::__construct($db,$table);
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
			$fw->error(403);
		}
		$csrf=$fw->hash($fw->get('ROOT').$fw->get('BASE')).'.'.
			$fw->hash(mt_rand());
		if ($this->load(array('session_id'=>$this->sid=session_id()))) {
			$this->set('csrf',$csrf);
			$this->save();
		}
=======
>>>>>>> 3.0.4 release
	}

}
