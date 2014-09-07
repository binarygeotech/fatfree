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

//! SMTP plug-in
class SMTP extends Magic {

	//@{ Locale-specific error/exception messages
	const
		E_Header='%s: header is required',
		E_Blank='Message must not be blank',
		E_Attach='Attachment %s not found';
	//@}

<<<<<<< HEAD
	protected
=======
	private
>>>>>>> 3.0.4 release
		//! Message properties
		$headers,
		//! E-mail attachments
		$attachments,
		//! SMTP host
		$host,
		//! SMTP port
		$port,
		//! TLS/SSL
		$scheme,
		//! User ID
		$user,
		//! Password
		$pw,
		//! TCP/IP socket
		$socket,
		//! Server-client conversation
		$log;

	/**
<<<<<<< HEAD
	*	Fix header
	*	@return string
	*	@param $key string
	**/
	protected function fixheader($key) {
		return str_replace(' ','-',
			ucwords(preg_replace('/[_-]/',' ',strtolower($key))));
	}

	/**
	*	Return TRUE if header exists
	*	@return bool
	*	@param $key
=======
		Fix header
		@return string
		@param $key string
	**/
	protected function fixheader($key) {
		return str_replace(' ','-',
			ucwords(preg_replace('/_-/',' ',strtolower($key))));
	}

	/**
		Return TRUE if header exists
		@return bool
		@param $key
>>>>>>> 3.0.4 release
	**/
	function exists($key) {
		$key=$this->fixheader($key);
		return isset($this->headers[$key]);
	}

	/**
<<<<<<< HEAD
	*	Bind value to e-mail header
	*	@return string
	*	@param $key string
	*	@param $val string
=======
		Bind value to e-mail header
		@return string
		@param $key string
		@param $val string
>>>>>>> 3.0.4 release
	**/
	function set($key,$val) {
		$key=$this->fixheader($key);
		return $this->headers[$key]=$val;
	}

	/**
<<<<<<< HEAD
	*	Return value of e-mail header
	*	@return string|NULL
	*	@param $key string
	**/
	function &get($key) {
		$key=$this->fixheader($key);
		if (isset($this->headers[$key]))
			$val=&$this->headers[$key];
		else
			$val=NULL;
		return $val;
	}

	/**
	*	Remove header
	*	@return NULL
	*	@param $key string
=======
		Return value of e-mail header
		@return string|NULL
		@param $key string
	**/
	function get($key) {
		$key=$this->fixheader($key);
		return isset($this->headers[$key])?$this->headers[$key]:NULL;
	}

	/**
		Remove header
		@return NULL
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function clear($key) {
		$key=$this->fixheader($key);
		unset($this->headers[$key]);
	}

	/**
<<<<<<< HEAD
	*	Return client-server conversation history
	*	@return string
=======
		Return client-server conversation history
		@return string
>>>>>>> 3.0.4 release
	**/
	function log() {
		return str_replace("\n",PHP_EOL,$this->log);
	}

	/**
<<<<<<< HEAD
	*	Send SMTP command and record server response
	*	@return string
	*	@param $cmd string
	*	@param $log bool
	**/
	protected function dialog($cmd=NULL,$log=TRUE) {
=======
		Send SMTP command and record server response
		@return NULL
		@param $cmd string
		@param $log bool
	**/
	protected function dialog($cmd=NULL,$log=FALSE) {
>>>>>>> 3.0.4 release
		$socket=&$this->socket;
		if (!is_null($cmd))
			fputs($socket,$cmd."\r\n");
		$reply='';
		while (!feof($socket) && ($info=stream_get_meta_data($socket)) &&
			!$info['timed_out'] && $str=fgets($socket,4096)) {
			$reply.=$str;
			if (preg_match('/(?:^|\n)\d{3} .+?\r\n/s',$reply))
				break;
		}
		if ($log) {
			$this->log.=$cmd."\n";
			$this->log.=str_replace("\r",'',$reply);
		}
<<<<<<< HEAD
		return $reply;
	}

	/**
	*	Add e-mail attachment
	*	@return NULL
	*	@param $file
	*	@param $alias
	**/
	function attach($file,$alias=NULL) {
		if (!is_file($file))
			user_error(sprintf(self::E_Attach,$file));
		if (is_string($alias))
			$file=array($alias=>$file);
=======
	}

	/**
		Add e-mail attachment
		@return NULL
		@param $file
	**/
	function attach($file) {
		if (!is_file($file))
			user_error(sprintf(self::E_Attach,$file));
>>>>>>> 3.0.4 release
		$this->attachments[]=$file;
	}

	/**
<<<<<<< HEAD
	*	Transmit message
	*	@return bool
	*	@param $message string
	*	@param $log bool
	**/
	function send($message,$log=TRUE) {
		if ($this->scheme=='ssl' && !extension_loaded('openssl'))
			return FALSE;
		// Message should not be blank
		if (!$message)
			user_error(self::E_Blank);
		$fw=Base::instance();
		// Retrieve headers
		$headers=$this->headers;
=======
		Transmit message
		@return bool
		@param $message string
	**/
	function send($message) {
		if ($this->scheme=='ssl' && !extension_loaded('openssl'))
			return FALSE;
		$fw=Base::instance();
>>>>>>> 3.0.4 release
		// Connect to the server
		$socket=&$this->socket;
		$socket=@fsockopen($this->host,$this->port);
		if (!$socket)
			return FALSE;
		stream_set_blocking($socket,TRUE);
		// Get server's initial response
<<<<<<< HEAD
		$this->dialog(NULL,FALSE);
		// Announce presence
		$reply=$this->dialog('EHLO '.$fw->get('HOST'),$log);
		if (strtolower($this->scheme)=='tls') {
			$this->dialog('STARTTLS',$log);
			stream_socket_enable_crypto(
				$socket,TRUE,STREAM_CRYPTO_METHOD_TLS_CLIENT);
			$reply=$this->dialog('EHLO '.$fw->get('HOST'),$log);
			if (preg_match('/8BITMIME/',$reply))
				$headers['Content-Transfer-Encoding']='8bit';
			else {
				$headers['Content-Transfer-Encoding']='quoted-printable';
				$message=quoted_printable_encode($message);
			}
		}
		if ($this->user && $this->pw && preg_match('/AUTH/',$reply)) {
			// Authenticate
			$this->dialog('AUTH LOGIN',$log);
			$this->dialog(base64_encode($this->user),$log);
			$this->dialog(base64_encode($this->pw),$log);
		}
		// Required headers
		$reqd=array('From','To','Subject');
		foreach ($reqd as $id)
			if (empty($headers[$id]))
				user_error(sprintf(self::E_Header,$id));
=======
		$this->dialog();
		// Announce presence
		$this->dialog('EHLO '.$fw->get('HOST'),TRUE);
		if (strtolower($this->scheme)=='tls') {
			$this->dialog('STARTTLS',TRUE);
			stream_socket_enable_crypto(
				$socket,TRUE,STREAM_CRYPTO_METHOD_TLS_CLIENT);
			$this->dialog('EHLO '.$fw->get('HOST'),TRUE);
		}
		if ($this->user && $this->pw) {
			// Authenticate
			$this->dialog('AUTH LOGIN',TRUE);
			$this->dialog(base64_encode($this->user),TRUE);
			$this->dialog(base64_encode($this->pw),TRUE);
		}
		// Required headers
		$reqd=array('From','To','Subject');
		// Retrieve headers
		$headers=$this->headers;
		foreach ($reqd as $id)
			if (empty($headers[$id]))
				user_error(sprintf(self::E_Header,$id));
		// Message should not be blank
		if (!$message)
			user_error(self::E_Blank);
>>>>>>> 3.0.4 release
		$eol="\r\n";
		$str='';
		// Stringify headers
		foreach ($headers as $key=>$val)
			if (!in_array($key,$reqd))
				$str.=$key.': '.$val.$eol;
		// Start message dialog
<<<<<<< HEAD
		$this->dialog('MAIL FROM: '.strstr($headers['From'],'<'),$log);
		foreach ($fw->split($headers['To'].
			(isset($headers['Cc'])?(';'.$headers['Cc']):'').
			(isset($headers['Bcc'])?(';'.$headers['Bcc']):'')) as $dst)
			$this->dialog('RCPT TO: '.strstr($dst,'<'),$log);
		$this->dialog('DATA',$log);
		if ($this->attachments) {
			// Replace Content-Type
			$hash=uniqid(NULL,TRUE);
=======
		$this->dialog('MAIL FROM: '.strstr($headers['From'],'<'),TRUE);
		foreach ($fw->split($headers['To'].
			(isset($headers['Cc'])?(';'.$headers['Cc']):'').
			(isset($headers['Bcc'])?(';'.$headers['Bcc']):'')) as $dst)
			$this->dialog('RCPT TO: '.strstr($dst,'<'),TRUE);
		$this->dialog('DATA',TRUE);
		if ($this->attachments) {
			// Replace Content-Type
			$hash=uniqid();
>>>>>>> 3.0.4 release
			$type=$headers['Content-Type'];
			$headers['Content-Type']='multipart/mixed; '.
				'boundary="'.$hash.'"';
			// Send mail headers
			$out='';
			foreach ($headers as $key=>$val)
				if ($key!='Bcc')
					$out.=$key.': '.$val.$eol;
			$out.=$eol;
			$out.='This is a multi-part message in MIME format'.$eol;
			$out.=$eol;
			$out.='--'.$hash.$eol;
			$out.='Content-Type: '.$type.$eol;
			$out.=$eol;
			$out.=$message.$eol;
			foreach ($this->attachments as $attachment) {
<<<<<<< HEAD
				if (is_array($attachment)) {
					list($alias, $file) = each($attachment);
					$filename = $alias;
					$attachment = $file;
				}
				else {
					$filename = basename($attachment);
				}
=======
>>>>>>> 3.0.4 release
				$out.='--'.$hash.$eol;
				$out.='Content-Type: application/octet-stream'.$eol;
				$out.='Content-Transfer-Encoding: base64'.$eol;
				$out.='Content-Disposition: attachment; '.
<<<<<<< HEAD
					'filename="'.$filename.'"'.$eol;
=======
					'filename="'.basename($attachment).'"'.$eol;
>>>>>>> 3.0.4 release
				$out.=$eol;
				$out.=chunk_split(
					base64_encode(file_get_contents($attachment))).$eol;
			}
			$out.=$eol;
			$out.='--'.$hash.'--'.$eol;
			$out.='.';
<<<<<<< HEAD
			$this->dialog($out,FALSE);
=======
			$this->dialog($out,TRUE);
>>>>>>> 3.0.4 release
		}
		else {
			// Send mail headers
			$out='';
			foreach ($headers as $key=>$val)
				if ($key!='Bcc')
					$out.=$key.': '.$val.$eol;
			$out.=$eol;
			$out.=$message.$eol;
			$out.='.';
			// Send message
<<<<<<< HEAD
			$this->dialog($out);
		}
		$this->dialog('QUIT',$log);
=======
			$this->dialog($out,TRUE);
		}
		$this->dialog('QUIT',TRUE);
>>>>>>> 3.0.4 release
		if ($socket)
			fclose($socket);
		return TRUE;
	}

	/**
<<<<<<< HEAD
	*	Instantiate class
	*	@param $host string
	*	@param $port int
	*	@param $scheme string
	*	@param $user string
	*	@param $pw string
=======
		Instantiate class
		@param $host string
		@param $port int
		@param $scheme string
		@param $user string
		@param $pw string
>>>>>>> 3.0.4 release
	**/
	function __construct($host,$port,$scheme,$user,$pw) {
		$this->headers=array(
			'MIME-Version'=>'1.0',
			'Content-Type'=>'text/plain; '.
<<<<<<< HEAD
				'charset='.Base::instance()->get('ENCODING')
=======
				'charset='.Base::instance()->get('ENCODING'),
			'Content-Transfer-Encoding'=>'8bit'
>>>>>>> 3.0.4 release
		);
		$this->host=$host;
		if (strtolower($this->scheme=strtolower($scheme))=='ssl')
			$this->host='ssl://'.$host;
		$this->port=$port;
		$this->user=$user;
		$this->pw=$pw;
	}

}
