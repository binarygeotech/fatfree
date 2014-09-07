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

namespace DB\SQL;

//! SQL-managed session handler
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
			$this->load(array('session_id=?',$this->sid=$id));
=======
		Return session data in serialized format
		@return string|FALSE
		@param $id string
	**/
	function read($id) {
		$this->load(array('session_id=?',$id));
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
			$this->load(array('session_id=?',$this->sid=$id));
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
		$this->load(array('session_id=?',$id));
		$this->set('session_id',$id);
		$this->set('data',$data);
>>>>>>> 3.0.4 release
		$this->set('ip',$fw->get('IP'));
		$this->set('agent',
			isset($headers['User-Agent'])?$headers['User-Agent']:'');
		$this->set('stamp',time());
		$this->save();
		return TRUE;
	}

	/**
<<<<<<< HEAD
	*	Destroy session
	*	@return TRUE
	*	@param $id string
	**/
	function destroy($id) {
		$this->erase(array('session_id=?',$id));
		setcookie(session_name(),'',strtotime('-1 year'));
		unset($_COOKIE[session_name()]);
		header_remove('Set-Cookie');
=======
		Destroy session
		@return TRUE
		@param $id string
	**/
	function destroy($id) {
		$this->erase(array('session_id=?',$id));
>>>>>>> 3.0.4 release
		return TRUE;
	}

	/**
<<<<<<< HEAD
	*	Garbage collector
	*	@return TRUE
	*	@param $max int
	**/
	function cleanup($max) {
		$this->erase(array('stamp+?<?',$max,time()));
=======
		Garbage collector
		@return TRUE
		@param $max int
	**/
	function cleanup($max) {
		$this->erase('stamp+'.$max.'<'.time());
>>>>>>> 3.0.4 release
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
		$this->load(array('session_id=?',$id?:session_id()));
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
		$this->load(array('session_id=?',$id?:session_id()));
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
		$this->load(array('session_id=?',$id?:session_id()));
>>>>>>> 3.0.4 release
		return $this->dry()?FALSE:$this->get('agent');
	}

	/**
<<<<<<< HEAD
	*	Instantiate class
	*	@param $db object
	*	@param $table string
	*	@param $force bool
	**/
	function __construct(\DB\SQL $db,$table='sessions',$force=TRUE) {
		if ($force) {
			$eol="\n";
			$tab="\t";
			$db->exec(
				(preg_match('/mssql|sqlsrv|sybase/',$db->driver())?
					('IF NOT EXISTS (SELECT * FROM sysobjects WHERE '.
						'name='.$db->quote($table).' AND xtype=\'U\') '.
						'CREATE TABLE dbo.'):
					('CREATE TABLE IF NOT EXISTS '.
						((($name=$db->name())&&$db->driver()!='pgsql')?
							($name.'.'):''))).
				$table.' ('.$eol.
					$tab.$db->quotekey('session_id').' VARCHAR(40),'.$eol.
					$tab.$db->quotekey('data').' TEXT,'.$eol.
					$tab.$db->quotekey('csrf').' TEXT,'.$eol.
					$tab.$db->quotekey('ip').' VARCHAR(40),'.$eol.
					$tab.$db->quotekey('agent').' VARCHAR(255),'.$eol.
					$tab.$db->quotekey('stamp').' INTEGER,'.$eol.
					$tab.'PRIMARY KEY ('.$db->quotekey('session_id').')'.$eol.
				');'
			);
		}
=======
		Instantiate class
		@param $db object
		@param $table string
	**/
	function __construct(\DB\SQL $db,$table='sessions') {
		$db->exec(
			'CREATE TABLE IF NOT EXISTS '.
				(($name=$db->name())?($name.'.'):'').$table.' ('.
				'session_id VARCHAR(40),'.
				'data TEXT,'.
				'ip VARCHAR(40),'.
				'agent VARCHAR(255),'.
				'stamp INTEGER,'.
				'PRIMARY KEY(session_id)'.
			');'
		);
>>>>>>> 3.0.4 release
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
		if ($this->load(array('session_id=?',$this->sid=session_id()))) {
			$this->set('csrf',$csrf);
			$this->save();
		}
=======
>>>>>>> 3.0.4 release
	}

}
