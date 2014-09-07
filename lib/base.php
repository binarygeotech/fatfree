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

<<<<<<< HEAD
//! Factory class for single-instance objects
abstract class Prefab {

	/**
	*	Return class instance
	*	@return static
	**/
	static function instance() {
		if (!Registry::exists($class=get_called_class())) {
			$ref=new Reflectionclass($class);
			$args=func_get_args();
			Registry::set($class,
				$args?$ref->newinstanceargs($args):new $class);
		}
		return Registry::get($class);
	}

}

//! Base structure
class Base extends Prefab implements ArrayAccess {
=======
//! Base structure
final class Base {
>>>>>>> 3.0.4 release

	//@{ Framework details
	const
		PACKAGE='Fat-Free Framework',
<<<<<<< HEAD
		VERSION='3.3.1-Dev';
=======
		VERSION='3.0.5-Dev';
>>>>>>> 3.0.4 release
	//@}

	//@{ HTTP status codes (RFC 2616)
	const
		HTTP_100='Continue',
		HTTP_101='Switching Protocols',
		HTTP_200='OK',
		HTTP_201='Created',
		HTTP_202='Accepted',
		HTTP_203='Non-Authorative Information',
		HTTP_204='No Content',
		HTTP_205='Reset Content',
		HTTP_206='Partial Content',
		HTTP_300='Multiple Choices',
		HTTP_301='Moved Permanently',
		HTTP_302='Found',
		HTTP_303='See Other',
		HTTP_304='Not Modified',
		HTTP_305='Use Proxy',
		HTTP_307='Temporary Redirect',
		HTTP_400='Bad Request',
		HTTP_401='Unauthorized',
		HTTP_402='Payment Required',
		HTTP_403='Forbidden',
		HTTP_404='Not Found',
		HTTP_405='Method Not Allowed',
		HTTP_406='Not Acceptable',
		HTTP_407='Proxy Authentication Required',
		HTTP_408='Request Timeout',
		HTTP_409='Conflict',
		HTTP_410='Gone',
		HTTP_411='Length Required',
		HTTP_412='Precondition Failed',
		HTTP_413='Request Entity Too Large',
		HTTP_414='Request-URI Too Long',
		HTTP_415='Unsupported Media Type',
		HTTP_416='Requested Range Not Satisfiable',
		HTTP_417='Expectation Failed',
		HTTP_500='Internal Server Error',
		HTTP_501='Not Implemented',
		HTTP_502='Bad Gateway',
		HTTP_503='Service Unavailable',
		HTTP_504='Gateway Timeout',
		HTTP_505='HTTP Version Not Supported';
	//@}

	const
		//! Mapped PHP globals
		GLOBALS='GET|POST|COOKIE|REQUEST|SESSION|FILES|SERVER|ENV',
		//! HTTP verbs
		VERBS='GET|HEAD|POST|PUT|PATCH|DELETE|CONNECT',
		//! Default directory permissions
		MODE=0755,
		//! Syntax highlighting stylesheet
		CSS='code.css';

	//@{ HTTP request types
	const
		REQ_SYNC=1,
		REQ_AJAX=2;
	//@}

	//@{ Error messages
	const
		E_Pattern='Invalid routing pattern: %s',
<<<<<<< HEAD
		E_Named='Named route does not exist: %s',
		E_Fatal='Fatal error: %s',
		E_Open='Unable to open %s',
		E_Routes='No routes specified',
		E_Class='Invalid class %s',
		E_Method='Invalid method %s',
		E_Hive='Invalid hive key %s';
=======
		E_Fatal='Fatal error: %s',
		E_Open='Unable to open %s',
		E_Routes='No routes specified',
		E_Method='Invalid method %s';
>>>>>>> 3.0.4 release
	//@}

	private
		//! Globals
		$hive,
		//! Initial settings
		$init,
		//! Language lookup sequence
		$languages,
<<<<<<< HEAD
		//! Default fallback language
		$fallback='en';

	/**
	*	Sync PHP global with corresponding hive key
	*	@return array
	*	@param $key string
=======
		//! Equivalent Locales
		$locales,
		//! Default fallback language
		$fallback='en',
		//! NULL reference
		$null=NULL;

	/**
		Sync PHP global with corresponding hive key
		@return array
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function sync($key) {
		return $this->hive[$key]=&$GLOBALS['_'.$key];
	}

	/**
<<<<<<< HEAD
	*	Return the parts of specified hive key
	*	@return array
	*	@param $key string
=======
		Return the parts of specified hive key
		@return array
		@param $key string
>>>>>>> 3.0.4 release
	**/
	private function cut($key) {
		return preg_split('/\[\h*[\'"]?(.+?)[\'"]?\h*\]|(->)|\./',
			$key,NULL,PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
	}

	/**
<<<<<<< HEAD
	*	Replace tokenized URL with current route's token values
	*	@return string
	*	@param $url array|string
	**/
	function build($url) {
		if (is_array($url))
			foreach ($url as &$var) {
				$var=$this->build($var);
				unset($var);
			}
		elseif (preg_match_all('/@(\w+)/',$url,$matches,PREG_SET_ORDER))
			foreach ($matches as $match)
				if (array_key_exists($match[1],$this->hive['PARAMS']))
					$url=str_replace($match[0],
						$this->hive['PARAMS'][$match[1]],$url);
		return $url;
	}

	/**
	*	Parse string containing key-value pairs and use as routing tokens
	*	@return NULL
	*	@param $str string
	**/
	function parse($str) {
		preg_match_all('/(\w+)\h*=\h*(.+?)(?=,|$)/',
			$str,$pairs,PREG_SET_ORDER);
		foreach ($pairs as $pair)
			$this->hive['PARAMS'][$pair[1]]=trim($pair[2]);
	}

	/**
	*	Convert JS-style token to PHP expression
	*	@return string
	*	@param $str string
	**/
	function compile($str) {
		$fw=$this;
		return preg_replace_callback(
			'/(?<!\w)@(\w(?:[\w\.\[\]]|\->|::)*)/',
			function($var) use($fw) {
				return '$'.preg_replace_callback(
					'/\.(\w+)|\[((?:[^\[\]]*|(?R))*)\]/',
					function($expr) use($fw) {
						return '['.var_export(
							isset($expr[2])?
								$fw->compile($expr[2]):
								(ctype_digit($expr[1])?
									(int)$expr[1]:
									$expr[1]),TRUE).']';
					},
					$var[1]
				);
			},
			$str
		);
	}

	/**
	*	Get hive key reference/contents; Add non-existent hive keys,
	*	array elements, and object properties by default
	*	@return mixed
	*	@param $key string
	*	@param $add bool
=======
		Get hive key reference/contents; Add non-existent hive keys,
		array elements, and object properties by default
		@return mixed
		@param $key string
		@param $add bool
>>>>>>> 3.0.4 release
	**/
	function &ref($key,$add=TRUE) {
		$parts=$this->cut($key);
		if ($parts[0]=='SESSION') {
			@session_start();
			$this->sync('SESSION');
		}
<<<<<<< HEAD
		elseif (!preg_match('/^\w+$/',$parts[0]))
			user_error(sprintf(self::E_Hive,$this->stringify($key)));
=======
>>>>>>> 3.0.4 release
		if ($add)
			$var=&$this->hive;
		else
			$var=$this->hive;
		$obj=FALSE;
		foreach ($parts as $part)
			if ($part=='->')
				$obj=TRUE;
			elseif ($obj) {
				$obj=FALSE;
<<<<<<< HEAD
				if (!is_object($var))
					$var=new stdclass;
				if ($add || property_exists($var,$part))
					$var=&$var->$part;
				else {
					$var=&$this->null;
					break;
				}
			}
			else {
				if (!is_array($var))
					$var=array();
				if ($add || array_key_exists($part,$var))
					$var=&$var[$part];
				else {
					$var=&$this->null;
					break;
				}
			}
		if ($parts[0]=='ALIASES')
			$var=$this->build($var);
=======
				if ($add) {
					if (!is_object($var))
						$var=new stdclass;
					$var=&$var->$part;
				}
				elseif (isset($var->$part))
					$var=$var->$part;
				else
					return $this->null;
			}
			elseif ($add) {
				if (!is_array($var))
					$var=array();
				$var=&$var[$part];
			}
			elseif (isset($var[$part]))
				$var=$var[$part];
			else
				return $this->null;
>>>>>>> 3.0.4 release
		return $var;
	}

	/**
<<<<<<< HEAD
	*	Return TRUE if hive key is set
	*	(or return timestamp and TTL if cached)
	*	@return bool
	*	@param $key string
	*	@param $val mixed
	**/
	function exists($key,&$val=NULL) {
		$val=$this->ref($key,FALSE);
		return isset($val)?
			TRUE:
			(Cache::instance()->exists($this->hash($key).'.var',$val)?:FALSE);
	}

	/**
	*	Return TRUE if hive key is empty and not cached
	*	@return bool
	*	@param $key string
	**/
	function devoid($key) {
		$val=$this->ref($key,FALSE);
		return empty($val) &&
			(!Cache::instance()->exists($this->hash($key).'.var',$val) ||
				!$val);
	}

	/**
	*	Bind value to hive key
	*	@return mixed
	*	@param $key string
	*	@param $val mixed
	*	@param $ttl int
	**/
	function set($key,$val,$ttl=0) {
		$time=time();
=======
		Return TRUE if hive key is not empty
		@return bool
		@param $key string
	**/
	function exists($key) {
		$ref=&$this->ref($key,FALSE);
		return isset($ref)?
			TRUE:
			Cache::instance()->exists($this->hash($key).'.var');
	}

	/**
		Bind value to hive key
		@return mixed
		@param $key string
		@param $val mixed
		@param $ttl int
	**/
	function set($key,$val,$ttl=0) {
>>>>>>> 3.0.4 release
		if (preg_match('/^(GET|POST|COOKIE)\b(.+)/',$key,$expr)) {
			$this->set('REQUEST'.$expr[2],$val);
			if ($expr[1]=='COOKIE') {
				$parts=$this->cut($key);
<<<<<<< HEAD
				$jar=$this->unserialize($this->serialize($this->hive['JAR']));
				if ($ttl)
					$jar['expire']=$time+$ttl;
				call_user_func_array('setcookie',array($parts[1],$val)+$jar);
				return $val;
=======
				call_user_func_array('setcookie',
					array_merge(array($parts[1],$val),$this->hive['JAR']));
>>>>>>> 3.0.4 release
			}
		}
		else switch ($key) {
			case 'CACHE':
<<<<<<< HEAD
				$val=Cache::instance()->load($val,TRUE);
				break;
			case 'ENCODING':
				ini_set('default_charset',$val);
				if (extension_loaded('mbstring'))
					mb_internal_encoding($val);
=======
				$val=Cache::instance()->load($val);
				break;
			case 'ENCODING':
				$val=ini_set('default_charset',$val);
				break;
			case 'JAR':
				call_user_func_array('session_set_cookie_params',$val);
>>>>>>> 3.0.4 release
				break;
			case 'FALLBACK':
				$this->fallback=$val;
				$lang=$this->language($this->hive['LANGUAGE']);
			case 'LANGUAGE':
				if (isset($lang) || $lang=$this->language($val))
					$val=$this->language($val);
				$lex=$this->lexicon($this->hive['LOCALES']);
			case 'LOCALES':
				if (isset($lex) || $lex=$this->lexicon($val))
<<<<<<< HEAD
					$this->mset($lex,$this->hive['PREFIX'],$ttl);
=======
					$this->mset($lex,NULL,$ttl);
>>>>>>> 3.0.4 release
				break;
			case 'TZ':
				date_default_timezone_set($val);
				break;
		}
		$ref=&$this->ref($key);
		$ref=$val;
<<<<<<< HEAD
		if (preg_match('/^JAR\b/',$key)) {
			$jar=$this->unserialize($this->serialize($this->hive['JAR']));
			$jar['expire']-=$time;
			call_user_func_array('session_set_cookie_params',$jar);
		}
		$cache=Cache::instance();
		if ($cache->exists($hash=$this->hash($key).'.var') || $ttl)
			// Persist the key-value pair
			$cache->set($hash,$val,$ttl);
=======
		if ($ttl)
			// Persist the key-value pair
			Cache::instance()->set($this->hash($key).'.var',$val);
>>>>>>> 3.0.4 release
		return $ref;
	}

	/**
<<<<<<< HEAD
	*	Retrieve contents of hive key
	*	@return mixed
	*	@param $key string
	*	@param $args string|array
=======
		Retrieve contents of hive key
		@return mixed
		@param $key string
		@param $args string|array
>>>>>>> 3.0.4 release
	**/
	function get($key,$args=NULL) {
		if (is_string($val=$this->ref($key,FALSE)) && !is_null($args))
			return call_user_func_array(
				array($this,'format'),
				array_merge(array($val),is_array($args)?$args:array($args))
			);
		if (is_null($val)) {
			// Attempt to retrieve from cache
			if (Cache::instance()->exists($this->hash($key).'.var',$data))
				return $data;
		}
		return $val;
	}

	/**
<<<<<<< HEAD
	*	Unset hive key
	*	@return NULL
	*	@param $key string
=======
		Unset hive key
		@return NULL
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function clear($key) {
		// Normalize array literal
		$cache=Cache::instance();
		$parts=$this->cut($key);
		if ($key=='CACHE')
			// Clear cache contents
			$cache->reset();
		elseif (preg_match('/^(GET|POST|COOKIE)\b(.+)/',$key,$expr)) {
			$this->clear('REQUEST'.$expr[2]);
			if ($expr[1]=='COOKIE') {
				$parts=$this->cut($key);
				$jar=$this->hive['JAR'];
				$jar['expire']=strtotime('-1 year');
				call_user_func_array('setcookie',
					array_merge(array($parts[1],''),$jar));
<<<<<<< HEAD
				unset($_COOKIE[$parts[1]]);
=======
>>>>>>> 3.0.4 release
			}
		}
		elseif ($parts[0]=='SESSION') {
			@session_start();
			if (empty($parts[1])) {
				// End session
				session_unset();
				session_destroy();
				unset($_COOKIE[session_name()]);
				header_remove('Set-Cookie');
			}
			$this->sync('SESSION');
		}
		if (!isset($parts[1]) && array_key_exists($parts[0],$this->init))
			// Reset global to default value
			$this->hive[$parts[0]]=$this->init[$parts[0]];
		else {
<<<<<<< HEAD
			eval('unset('.$this->compile('@this->hive.'.$key).');');
			if ($parts[0]=='SESSION') {
				session_commit();
				session_start();
			}
=======
			$out='';
			$obj=FALSE;
			foreach ($parts as $part)
				if ($part=='->')
					$obj=TRUE;
				elseif ($obj) {
					$obj=FALSE;
					$out.='->'.$out;
				}
				else
					$out.='['.$this->stringify($part).']';
			// PHP can't unset a referenced variable
			eval('unset($this->hive'.$out.');');
>>>>>>> 3.0.4 release
			if ($cache->exists($hash=$this->hash($key).'.var'))
				// Remove from cache
				$cache->clear($hash);
		}
	}

	/**
<<<<<<< HEAD
	*	Return TRUE if property has public/protected visibility
	*	@return bool
	*	@param $obj object
	*	@param $key string
	**/
	function visible($obj,$key) {
		if (property_exists($obj,$key)) {
			$ref=new ReflectionProperty(get_class($obj),$key);
			$out=!$ref->isprivate();
			unset($ref);
			return $out;
		}
		return FALSE;
	}

	/**
	*	Multi-variable assignment using associative array
	*	@return NULL
	*	@param $vars array
	*	@param $prefix string
	*	@param $ttl int
=======
		Multi-variable assignment using associative array
		@return NULL
		@param $vars array
		@param $prefix string
		@param $ttl int
>>>>>>> 3.0.4 release
	**/
	function mset(array $vars,$prefix='',$ttl=0) {
		foreach ($vars as $key=>$val)
			$this->set($prefix.$key,$val,$ttl);
	}

	/**
<<<<<<< HEAD
	*	Publish hive contents
	*	@return array
=======
		Publish hive contents
		@return array
>>>>>>> 3.0.4 release
	**/
	function hive() {
		return $this->hive;
	}

	/**
<<<<<<< HEAD
	*	Copy contents of hive variable to another
	*	@return mixed
	*	@param $src string
	*	@param $dst string
	**/
	function copy($src,$dst) {
		$ref=&$this->ref($dst);
		return $ref=$this->ref($src,FALSE);
	}

	/**
	*	Concatenate string to hive string variable
	*	@return string
	*	@param $key string
	*	@param $val string
=======
		Copy contents of hive variable to another
		@return mixed
		@param $src string
		@param $dst string
	**/
	function copy($src,$dst) {
		$ref=&$this->ref($dst);
		return $ref=$this->ref($src);
	}

	/**
		Concatenate string to hive string variable
		@return string
		@param $key string
		@param $val string
>>>>>>> 3.0.4 release
	**/
	function concat($key,$val) {
		$ref=&$this->ref($key);
		$ref.=$val;
		return $ref;
	}

	/**
<<<<<<< HEAD
	*	Swap keys and values of hive array variable
	*	@return array
	*	@param $key string
	*	@public
=======
		Swap keys and values of hive array variable
		@return array
		@param $key string
		@public
>>>>>>> 3.0.4 release
	**/
	function flip($key) {
		$ref=&$this->ref($key);
		return $ref=array_combine(array_values($ref),array_keys($ref));
	}

	/**
<<<<<<< HEAD
	*	Add element to the end of hive array variable
	*	@return mixed
	*	@param $key string
	*	@param $val mixed
=======
		Add element to the end of hive array variable
		@return mixed
		@param $key string
		@param $val mixed
>>>>>>> 3.0.4 release
	**/
	function push($key,$val) {
		$ref=&$this->ref($key);
		array_push($ref,$val);
		return $val;
	}

	/**
<<<<<<< HEAD
	*	Remove last element of hive array variable
	*	@return mixed
	*	@param $key string
=======
		Remove last element of hive array variable
		@return mixed
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function pop($key) {
		$ref=&$this->ref($key);
		return array_pop($ref);
	}

	/**
<<<<<<< HEAD
	*	Add element to the beginning of hive array variable
	*	@return mixed
	*	@param $key string
	*	@param $val mixed
=======
		Add element to the beginning of hive array variable
		@return mixed
		@param $key string
		@param $val mixed
>>>>>>> 3.0.4 release
	**/
	function unshift($key,$val) {
		$ref=&$this->ref($key);
		array_unshift($ref,$val);
		return $val;
	}

	/**
<<<<<<< HEAD
	*	Remove first element of hive array variable
	*	@return mixed
	*	@param $key string
=======
		Remove first element of hive array variable
		@return mixed
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function shift($key) {
		$ref=&$this->ref($key);
		return array_shift($ref);
	}

	/**
<<<<<<< HEAD
	*	Merge array with hive array variable
	*	@return array
	*	@param $key string
	*	@param $src string|array
	**/
	function merge($key,$src) {
		$ref=&$this->ref($key);
		return array_merge($ref,is_string($src)?$this->hive[$src]:$src);
	}

	/**
	*	Convert backslashes to slashes
	*	@return string
	*	@param $str string
=======
		Convert backslashes to slashes
		@return string
		@param $str string
>>>>>>> 3.0.4 release
	**/
	function fixslashes($str) {
		return $str?strtr($str,'\\','/'):$str;
	}

	/**
<<<<<<< HEAD
	*	Split comma-, semi-colon, or pipe-separated string
	*	@return array
	*	@param $str string
=======
		Split comma-, semi-colon, or pipe-separated string
		@return array
		@param $str string
>>>>>>> 3.0.4 release
	**/
	function split($str) {
		return array_map('trim',
			preg_split('/[,;|]/',$str,0,PREG_SPLIT_NO_EMPTY));
	}

	/**
<<<<<<< HEAD
	*	Convert PHP expression/value to compressed exportable string
	*	@return string
	*	@param $arg mixed
	*	@param $stack array
	**/
	function stringify($arg,array $stack=NULL) {
		if ($stack) {
			foreach ($stack as $node)
				if ($arg===$node)
					return '*RECURSION*';
		}
		else
			$stack=array();
		switch (gettype($arg)) {
			case 'object':
				$str='';
				foreach (get_object_vars($arg) as $key=>$val)
					$str.=($str?',':'').
						var_export($key,TRUE).'=>'.
						$this->stringify($val,
							array_merge($stack,array($arg)));
				return get_class($arg).'::__set_state(array('.$str.'))';
=======
		Convert PHP expression/value to compressed exportable string
		@return string
		@param $arg mixed
	**/
	function stringify($arg) {
		switch (gettype($arg)) {
			case 'object':
				$str='';
				if ($this->hive['DEBUG']>2)
					foreach ((array)$arg as $key=>$val)
						$str.=($str?',':'').$this->stringify(
							preg_replace('/[\x00].+?[\x00]/','',$key)).'=>'.
							$this->stringify($val);
				return addslashes(get_class($arg)).'::__set_state('.$str.')';
>>>>>>> 3.0.4 release
			case 'array':
				$str='';
				$num=isset($arg[0]) &&
					ctype_digit(implode('',array_keys($arg)));
<<<<<<< HEAD
				foreach ($arg as $key=>$val)
					$str.=($str?',':'').
						($num?'':(var_export($key,TRUE).'=>')).
						$this->stringify($val,
							array_merge($stack,array($arg)));
				return 'array('.$str.')';
			default:
				return var_export($arg,TRUE);
=======
				foreach ($arg as $key=>$val) {
					$str.=($str?',':'').
						($num?'':($this->stringify($key).'=>')).
						($arg==$val?'*RECURSION*':$this->stringify($val));
				}
				return 'array('.$str.')';
			default:
				return var_export(
					is_string($arg)?addcslashes($arg,'\''):$arg,TRUE);
>>>>>>> 3.0.4 release
		}
	}

	/**
<<<<<<< HEAD
	*	Flatten array values and return as CSV string
	*	@return string
	*	@param $args array
=======
		Flatten array values and return as CSV string
		@return string
		@param $args array
>>>>>>> 3.0.4 release
	**/
	function csv(array $args) {
		return implode(',',array_map('stripcslashes',
			array_map(array($this,'stringify'),$args)));
	}

	/**
<<<<<<< HEAD
	*	Convert snakecase string to camelcase
	*	@return string
	*	@param $str string
=======
		Convert snakecase string to camelcase
		@return string
		@param $str string
>>>>>>> 3.0.4 release
	**/
	function camelcase($str) {
		return preg_replace_callback(
			'/_(\w)/',
			function($match) {
				return strtoupper($match[1]);
			},
			$str
		);
	}

	/**
<<<<<<< HEAD
	*	Convert camelcase string to snakecase
	*	@return string
	*	@param $str string
=======
		Convert camelcase string to snakecase
		@return string
		@param $str string
>>>>>>> 3.0.4 release
	**/
	function snakecase($str) {
		return strtolower(preg_replace('/[[:upper:]]/','_\0',$str));
	}

	/**
<<<<<<< HEAD
	*	Return -1 if specified number is negative, 0 if zero,
	*	or 1 if the number is positive
	*	@return int
	*	@param $num mixed
=======
		Return -1 if specified number is negative, 0 if zero,
		or 1 if the number is positive
		@return int
		@param $num mixed
>>>>>>> 3.0.4 release
	**/
	function sign($num) {
		return $num?($num/abs($num)):0;
	}

	/**
<<<<<<< HEAD
	*	Generate 64bit/base36 hash
	*	@return string
	*	@param $str
=======
		Generate 64bit/base36 hash
		@return string
		@param $str
>>>>>>> 3.0.4 release
	**/
	function hash($str) {
		return str_pad(base_convert(
			hexdec(substr(sha1($str),-16)),10,36),11,'0',STR_PAD_LEFT);
	}

	/**
<<<<<<< HEAD
	*	Return Base64-encoded equivalent
	*	@return string
	*	@param $data string
	*	@param $mime string
=======
		Return Base64-encoded equivalent
		@return string
		@param $data string
		@param $mime string
>>>>>>> 3.0.4 release
	**/
	function base64($data,$mime) {
		return 'data:'.$mime.';base64,'.base64_encode($data);
	}

	/**
<<<<<<< HEAD
	*	Convert special characters to HTML entities
	*	@return string
	*	@param $str string
	**/
	function encode($str) {
		return @htmlentities($str,$this->hive['BITMASK'],
			$this->hive['ENCODING'])?:$this->scrub($str);
	}

	/**
	*	Convert HTML entities back to characters
	*	@return string
	*	@param $str string
	**/
	function decode($str) {
		return html_entity_decode($str,$this->hive['BITMASK'],
			$this->hive['ENCODING']);
	}

	/**
	*	Invoke callback recursively for all data types
	*	@return mixed
	*	@param $arg mixed
	*	@param $func callback
	*	@param $stack array
	**/
	function recursive($arg,$func,$stack=NULL) {
		if ($stack) {
			foreach ($stack as $node)
				if ($arg===$node)
					return $arg;
		}
		else
			$stack=array();
		switch (gettype($arg)) {
			case 'object':
				if (method_exists('ReflectionClass','iscloneable')) {
					$ref=new ReflectionClass($arg);
					if ($ref->iscloneable()) {
						$arg=clone($arg);
						foreach (get_object_vars($arg) as $key=>$val)
							$arg->$key=$this->recursive($val,$func,
								array_merge($stack,array($arg)));
					}
				}
				return $arg;
			case 'array':
				$tmp=array();
				foreach ($arg as $key=>$val)
					$tmp[$key]=$this->recursive($val,$func,
						array_merge($stack,array($arg)));
				return $tmp;
		}
		return $func($arg);
	}

	/**
	*	Remove HTML tags (except those enumerated) and non-printable
	*	characters to mitigate XSS/code injection attacks
	*	@return mixed
	*	@param $arg mixed
	*	@param $tags string
	**/
	function clean($arg,$tags=NULL) {
		$fw=$this;
		return $this->recursive($arg,
			function($val) use($fw,$tags) {
				if ($tags!='*')
					$val=trim(strip_tags($val,
						'<'.implode('><',$fw->split($tags)).'>'));
				return trim(preg_replace(
					'/[\x00-\x08\x0B\x0C\x0E-\x1F]/','',$val));
			}
		);
	}

	/**
	*	Similar to clean(), except that variable is passed by reference
	*	@return mixed
	*	@param $var mixed
	*	@param $tags string
	**/
	function scrub(&$var,$tags=NULL) {
		return $var=$this->clean($var,$tags);
	}

	/**
	*	Return locale-aware formatted string
	*	@return string
=======
		Convert special characters to HTML entities
		@return string
		@param $str string
	**/
	function encode($str) {
		return @htmlentities($str,ENT_COMPAT,$this->hive['ENCODING'],FALSE)?:
			$this->scrub($str);
	}

	/**
		Convert HTML entities back to characters
		@return string
		@param $str string
	**/
	function decode($str) {
		return html_entity_decode($str,ENT_COMPAT,$this->hive['ENCODING']);
	}

	/**
		Remove HTML tags (except those enumerated) and non-printable
		characters to mitigate XSS/code injection attacks
		@return mixed
		@param $var mixed
		@param $tags string
	**/
	function scrub(&$var,$tags=NULL) {
		if (is_string($var)) {
			if ($tags)
				$tags='<'.implode('><',$this->split($tags)).'>';
			$var=trim(preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/','',
				($tags=='*')?$var:strip_tags($var,$tags)));
		}
		elseif (is_array($var))
			foreach ($var as &$val) {
				$this->scrub($val,$tags);
				unset($val);
			}
		return $var;
	}

	/**
		Encode characters to equivalent HTML entities
		@return string
		@param $arg mixed
	**/
	function esc($arg) {
		if (is_string($arg))
			return $this->encode($arg);
		if (is_array($arg))
			foreach ($arg as &$val) {
				$val=$this->esc($val);
				unset($val);
			}
		return $arg;
	}

	/**
		Decode HTML entities to equivalent characters
		@return string
		@param $arg mixed
	**/
	function raw($arg) {
		if (is_string($arg))
			return $this->decode($arg);
		if (is_array($arg))
			foreach ($arg as &$val) {
				$val=$this->raw($val);
				unset($val);
			}
		return $arg;
	}

	/**
		Return locale-aware formatted string
		@return string
>>>>>>> 3.0.4 release
	**/
	function format() {
		$args=func_get_args();
		$val=array_shift($args);
<<<<<<< HEAD
		// Get formatting rules
		$conv=localeconv();
		return preg_replace_callback(
			'/\{(?P<pos>\d+)\s*(?:,\s*(?P<type>\w+)\s*'.
			'(?:,\s*(?P<mod>(?:\w+(?:\s*\{.+?\}\s*,?)?)*)'.
			'(?:,\s*(?P<prop>.+?))?)?)?\}/',
			function($expr) use($args,$conv) {
				extract($expr);
				extract($conv);
=======
		setlocale(LC_ALL,$this->locales);
		// Get formatting rules
		$conv=localeconv();
		$out=preg_replace_callback(
			'/\{(?P<pos>\d+)\s*(?:,\s*(?P<type>\w+)\s*'.
			'(?:,(?P<mod>(?:\s*\w+(?:\s+\{.+?\}\s*,?)?)*))?)?\}/',
			function($expr) use($args,$conv) {
				extract($expr);
>>>>>>> 3.0.4 release
				if (!array_key_exists($pos,$args))
					return $expr[0];
				if (isset($type))
					switch ($type) {
						case 'plural':
							preg_match_all('/(?<tag>\w+)'.
<<<<<<< HEAD
								'(?:\s+\{\s*(?<data>.+?)\s*\})/',
=======
								'(?:\s+\{(?<data>.+?)\})/',
>>>>>>> 3.0.4 release
								$mod,$matches,PREG_SET_ORDER);
							$ord=array('zero','one','two');
							foreach ($matches as $match) {
								extract($match);
								if (isset($ord[$args[$pos]]) &&
									$tag==$ord[$args[$pos]] || $tag=='other')
									return str_replace('#',$args[$pos],$data);
							}
						case 'number':
							if (isset($mod))
								switch ($mod) {
									case 'integer':
<<<<<<< HEAD
										return number_format(
											$args[$pos],0,'',$thousands_sep);
									case 'currency':
										if (function_exists('money_format'))
											return money_format(
												'%n',$args[$pos]);
										$fmt=array(
											0=>'(nc)',1=>'(n c)',
											2=>'(nc)',10=>'+nc',
											11=>'+n c',12=>'+ nc',
											20=>'nc+',21=>'n c+',
											22=>'nc +',30=>'n+c',
											31=>'n +c',32=>'n+ c',
											40=>'nc+',41=>'n c+',
											42=>'nc +',100=>'(cn)',
											101=>'(c n)',102=>'(cn)',
											110=>'+cn',111=>'+c n',
											112=>'+ cn',120=>'cn+',
											121=>'c n+',122=>'cn +',
											130=>'+cn',131=>'+c n',
											132=>'+ cn',140=>'c+n',
											141=>'c+ n',142=>'c +n'
										);
										if ($args[$pos]<0) {
											$sgn=$negative_sign;
											$pre='n';
										}
										else {
											$sgn=$positive_sign;
											$pre='p';
										}
										return str_replace(
											array('+','n','c'),
											array($sgn,number_format(
												abs($args[$pos]),
												$frac_digits,
												$decimal_point,
												$thousands_sep),
												$currency_symbol),
											$fmt[(int)(
												(${$pre.'_cs_precedes'}%2).
												(${$pre.'_sign_posn'}%5).
												(${$pre.'_sep_by_space'}%3)
											)]
										);
									case 'percent':
										return number_format(
											$args[$pos]*100,0,$decimal_point,
											$thousands_sep).'%';
									case 'decimal':
										return number_format(
											$args[$pos],$prop,$decimal_point,
												$thousands_sep);
								}
							break;
						case 'date':
							if (empty($mod) || $mod=='short')
								$prop='%x';
							elseif ($mod=='long')
								$prop='%A, %d %B %Y';
							return strftime($prop,$args[$pos]);
						case 'time':
							if (empty($mod) || $mod=='short')
								$prop='%X';
							return strftime($prop,$args[$pos]);
=======
										return
											number_format(
												$args[$pos],0,'',
												$conv['thousands_sep']);
									case 'currency':
										return
											$conv['currency_symbol'].
											number_format(
												$args[$pos],
												$conv['frac_digits'],
												$conv['decimal_point'],
												$conv['thousands_sep']);
									case 'percent':
										return
											number_format(
												$args[$pos]*100,0,
												$conv['decimal_point'],
												$conv['thousands_sep']).'%';
								}
							break;
						case 'date':
							return strftime(empty($mod) ||
								$mod=='short'?'%x':'%A, %d %B %Y',
								$args[$pos]);
						case 'time':
							return strftime('%X',$args[$pos]);
>>>>>>> 3.0.4 release
						default:
							return $expr[0];
					}
				return $args[$pos];
			},
			$val
		);
<<<<<<< HEAD
	}

	/**
	*	Assign/auto-detect language
	*	@return string
	*	@param $code string
	**/
	function language($code) {
		$code=preg_replace('/;q=.+?(?=,|$)/','',$code);
		$code.=($code?',':'').$this->fallback;
		$this->languages=array();
		foreach (array_reverse(explode(',',$code)) as $lang) {
			if (preg_match('/^(\w{2})(?:-(\w{2}))?\b/i',$lang,$parts)) {
=======
		return preg_match('/^win/i',PHP_OS)?
			iconv('Windows-1252',$this->hive['ENCODING'],$out):$out;
	}

	/**
		Assign/auto-detect language
		@return string
		@param $code string
	**/
	function language($code=NULL) {
		if (!$code) {
			$headers=$this->hive['HEADERS'];
			if (isset($headers['Accept-Language']))
				$code=$headers['Accept-Language'];
		}
		$code=str_replace('-','_',preg_replace('/;q=.+?(?=,|$)/','',$code));
		$code.=($code?',':'').$this->fallback;
		$this->languages=array();
		foreach (array_reverse(explode(',',$code)) as $lang) {
			if (preg_match('/^(\w{2})(?:_(\w{2}))?\b/i',$lang,$parts)) {
>>>>>>> 3.0.4 release
				// Generic language
				array_unshift($this->languages,$parts[1]);
				if (isset($parts[2])) {
					// Specific language
<<<<<<< HEAD
					$parts[0]=$parts[1].'-'.($parts[2]=strtoupper($parts[2]));
=======
					$parts[0]=$parts[1].'_'.($parts[2]=strtoupper($parts[2]));
>>>>>>> 3.0.4 release
					array_unshift($this->languages,$parts[0]);
				}
			}
		}
		$this->languages=array_unique($this->languages);
<<<<<<< HEAD
		$locales=array();
		$windows=preg_match('/^win/i',PHP_OS);
		foreach ($this->languages as $locale) {
			if ($windows) {
				$parts=explode('-',$locale);
				$locale=@constant('ISO::LC_'.$parts[0]);
				if (isset($parts[1]) &&
					$country=@constant('ISO::CC_'.strtolower($parts[1])))
					$locale.='-'.$country;
			}
			$locales[]=$locale;
			$locales[]=$locale.'.'.ini_get('default_charset');
		}
		setlocale(LC_ALL,str_replace('-','_',$locales));
=======
		$this->locales=array();
		$windows=preg_match('/^win/i',PHP_OS);
		foreach ($this->languages as $locale) {
			if ($windows) {
				$parts=explode('_',$locale);
				$locale=@constant('ISO::LC_'.$parts[0]);
				if (isset($parts[1]) &&
					$country=@constant('ISO::CC_'.$parts[1]))
					$locale.='_'.$country;
			}
			$this->locales[]=$locale;
			$this->locales[]=$locale.'.'.$this->hive['ENCODING'];
		}
>>>>>>> 3.0.4 release
		return implode(',',$this->languages);
	}

	/**
<<<<<<< HEAD
	*	Return lexicon entries
	*	@return array
	*	@param $path string
	**/
	function lexicon($path) {
		$lex=array();
		foreach ($this->languages?:array($this->fallback) as $lang) {
=======
		Transfer lexicon entries to hive
		@return NULL
		@param $path string
	**/
	function lexicon($path) {
		$lex=array();
		foreach ($this->languages as $lang) {
>>>>>>> 3.0.4 release
			if ((is_file($file=($base=$path.$lang).'.php') ||
				is_file($file=$base.'.php')) &&
				is_array($dict=require($file)))
				$lex+=$dict;
			elseif (is_file($file=$base.'.ini')) {
				preg_match_all(
					'/(?<=^|\n)(?:'.
<<<<<<< HEAD
					'(.+?)\h*=\h*'.
					'((?:\\\\\h*\r?\n|.+?)*)'.
					')(?=\r?\n|$)/',
					$this->read($file),$matches,PREG_SET_ORDER);
=======
					'(?:;[^\n]*)|(?:<\?php.+?\?>?)|'.
					'(.+?)\h*=\h*'.
					'((?:\\\\\h*\r?\n|.+?)*)'.
					')(?=\r?\n|$)/',
					file_get_contents($file),$matches,PREG_SET_ORDER);
>>>>>>> 3.0.4 release
				if ($matches)
					foreach ($matches as $match)
						if (isset($match[1]) &&
							!array_key_exists($match[1],$lex))
<<<<<<< HEAD
							$lex[$match[1]]=trim(preg_replace(
								'/(?<!\\\\)"|\\\\\h*\r?\n/','',$match[2]));
=======
							$lex[$match[1]]=preg_replace(
								'/\\\\\h*\r?\n/','',$match[2]);
>>>>>>> 3.0.4 release
			}
		}
		return $lex;
	}

	/**
<<<<<<< HEAD
	*	Return string representation of PHP value
	*	@return string
	*	@param $arg mixed
=======
		Return string representation of PHP value
		@return string
		@param $arg mixed
>>>>>>> 3.0.4 release
	**/
	function serialize($arg) {
		switch (strtolower($this->hive['SERIALIZER'])) {
			case 'igbinary':
				return igbinary_serialize($arg);
<<<<<<< HEAD
=======
			case 'json':
				return json_encode($arg);
>>>>>>> 3.0.4 release
			default:
				return serialize($arg);
		}
	}

	/**
<<<<<<< HEAD
	*	Return PHP value derived from string
	*	@return string
	*	@param $arg mixed
=======
		Return PHP value derived from string
		@return string
		@param $arg mixed
>>>>>>> 3.0.4 release
	**/
	function unserialize($arg) {
		switch (strtolower($this->hive['SERIALIZER'])) {
			case 'igbinary':
				return igbinary_unserialize($arg);
<<<<<<< HEAD
=======
			case 'json':
				return json_decode($arg);
>>>>>>> 3.0.4 release
			default:
				return unserialize($arg);
		}
	}

	/**
<<<<<<< HEAD
	*	Send HTTP/1.1 status header; Return text equivalent of status code
	*	@return string
	*	@param $code int
	**/
	function status($code) {
		$reason=@constant('self::HTTP_'.$code);
		if (PHP_SAPI!='cli')
			header('HTTP/1.1 '.$code.' '.$reason);
		return $reason;
	}

	/**
	*	Send cache metadata to HTTP client
	*	@return NULL
	*	@param $secs int
	**/
	function expire($secs=0) {
		if (PHP_SAPI!='cli') {
			header('X-Content-Type-Options: nosniff');
			header('X-Frame-Options: '.$this->hive['XFRAME']);
			header('X-Powered-By: '.$this->hive['PACKAGE']);
			header('X-XSS-Protection: 1; mode=block');
=======
		Send HTTP/1.1 status header; Return text equivalent of status code
		@return string
		@param $code int
	**/
	function status($code) {
		if (PHP_SAPI!='cli')
			header('HTTP/1.1 '.$code);
		return @constant('self::HTTP_'.$code);
	}

	/**
		Send cache metadata to HTTP client
		@return NULL
		@param $secs int
	**/
	function expire($secs=0) {
		if (PHP_SAPI!='cli') {
			header('X-Powered-By: '.$this->hive['PACKAGE']);
>>>>>>> 3.0.4 release
			if ($secs) {
				$time=microtime(TRUE);
				header_remove('Pragma');
				header('Expires: '.gmdate('r',$time+$secs));
				header('Cache-Control: max-age='.$secs);
				header('Last-Modified: '.gmdate('r'));
				$headers=$this->hive['HEADERS'];
				if (isset($headers['If-Modified-Since']) &&
					strtotime($headers['If-Modified-Since'])+$secs>$time) {
					$this->status(304);
					die;
				}
			}
			else
				header('Cache-Control: no-cache, no-store, must-revalidate');
		}
	}

	/**
<<<<<<< HEAD
	*	Log error; Execute ONERROR handler if defined, else display
	*	default error page (HTML for synchronous requests, JSON string
	*	for AJAX requests)
	*	@return NULL
	*	@param $code int
	*	@param $text string
	*	@param $trace array
=======
		Log error; Execute ONERROR handler if defined, else display
		default error page (HTML for synchronous requests, JSON string
		for AJAX requests)
		@return NULL
		@param $code int
		@param $text string
		@param $trace array
>>>>>>> 3.0.4 release
	**/
	function error($code,$text='',array $trace=NULL) {
		$prior=$this->hive['ERROR'];
		$header=$this->status($code);
<<<<<<< HEAD
		$req=$this->hive['VERB'].' '.$this->hive['PATH'];
		if (!$text)
			$text='HTTP '.$code.' ('.$req.')';
		error_log($text);
		if (!$trace) {
			$trace=debug_backtrace(FALSE);
			$frame=$trace[0];
			if (isset($frame['file']) && $frame['file']==__FILE__)
				array_shift($trace);
		}
=======
		$req=$this->hive['VERB'].' '.$this->hive['URI'];
		if (!$text)
			$text='HTTP '.$code.' ('.$req.')';
		error_log($text);
		if (!$trace)
			$trace=array_slice(debug_backtrace(0),1);
>>>>>>> 3.0.4 release
		$debug=$this->hive['DEBUG'];
		$trace=array_filter(
			$trace,
			function($frame) use($debug) {
<<<<<<< HEAD
				return $debug && isset($frame['file']) &&
=======
				return isset($frame['file']) &&
>>>>>>> 3.0.4 release
					($frame['file']!=__FILE__ || $debug>1) &&
					(empty($frame['function']) ||
					!preg_match('/^(?:(?:trigger|user)_error|'.
						'__call|call_user_func)/',$frame['function']));
			}
		);
<<<<<<< HEAD
		$highlight=PHP_SAPI!='cli' &&
			$this->hive['HIGHLIGHT'] && is_file($css=__DIR__.'/'.self::CSS);
=======
		$highlight=$this->hive['HIGHLIGHT'] &&
			is_file($css=__DIR__.'/'.self::CSS);
>>>>>>> 3.0.4 release
		$out='';
		$eol="\n";
		// Analyze stack trace
		foreach ($trace as $frame) {
			$line='';
			if (isset($frame['class']))
				$line.=$frame['class'].$frame['type'];
			if (isset($frame['function']))
<<<<<<< HEAD
				$line.=$frame['function'].'('.
					($debug>2 && isset($frame['args'])?
						$this->csv($frame['args']):'').')';
			$src=$this->fixslashes(str_replace($_SERVER['DOCUMENT_ROOT'].
				'/','',$frame['file'])).':'.$frame['line'].' ';
=======
				$line.=$frame['function'].'('.(isset($frame['args'])?
					$this->csv($frame['args']):'').')';
			$src=$this->fixslashes($frame['file']).':'.$frame['line'].' ';
>>>>>>> 3.0.4 release
			error_log('- '.$src.$line);
			$out.='• '.($highlight?
				($this->highlight($src).' '.$this->highlight($line)):
				($src.$line)).$eol;
		}
		$this->hive['ERROR']=array(
<<<<<<< HEAD
			'status'=>$header,
=======
>>>>>>> 3.0.4 release
			'code'=>$code,
			'text'=>$text,
			'trace'=>$trace
		);
<<<<<<< HEAD
		$handler=$this->hive['ONERROR'];
		$this->hive['ONERROR']=NULL;
		if ((!$handler ||
			$this->call($handler,$this,'beforeroute,afterroute')===FALSE) &&
			!$prior && PHP_SAPI!='cli' && !$this->hive['QUIET'])
			echo $this->hive['AJAX']?
				json_encode($this->hive['ERROR']):
				('<!DOCTYPE html>'.$eol.
=======
		ob_clean();
		if ($this->hive['ONERROR'])
			// Execute custom error handler
			$this->call($this->hive['ONERROR'],$this);
		elseif (!$prior && PHP_SAPI!='cli' && !$this->hive['QUIET'])
			echo $this->hive['AJAX']?
				json_encode($this->hive['ERROR']):
				('<!DOCTYPE html>'.
>>>>>>> 3.0.4 release
				'<html>'.$eol.
				'<head>'.
					'<title>'.$code.' '.$header.'</title>'.
					($highlight?
<<<<<<< HEAD
						('<style>'.$this->read($css).'</style>'):'').
=======
						('<style>'.file_get_contents($css).'</style>'):'').
>>>>>>> 3.0.4 release
				'</head>'.$eol.
				'<body>'.$eol.
					'<h1>'.$header.'</h1>'.$eol.
					'<p>'.$this->encode($text?:$req).'</p>'.$eol.
					($debug?('<pre>'.$out.'</pre>'.$eol):'').
				'</body>'.$eol.
				'</html>');
<<<<<<< HEAD
		if ($this->hive['HALT'])
			die;
	}

	/**
	*	Mock HTTP request
	*	@return NULL
	*	@param $pattern string
	*	@param $args array
	*	@param $headers array
	*	@param $body string
	**/
	function mock($pattern,
		array $args=NULL,array $headers=NULL,$body=NULL) {
		if (!$args)
			$args=array();
		$types=array('sync','ajax');
		preg_match('/([\|\w]+)\h+(?:@(\w+)(?:(\(.+?)\))*|([^\h]+))'.
			'(?:\h+\[('.implode('|',$types).')\])?/',$pattern,$parts);
		$verb=strtoupper($parts[1]);
		if ($parts[2]) {
			if (empty($this->hive['ALIASES'][$parts[2]]))
				user_error(sprintf(self::E_Named,$parts[2]));
			$parts[4]=$this->hive['ALIASES'][$parts[2]];
			if (isset($parts[3]))
				$this->parse($parts[3]);
			$parts[4]=$this->build($parts[4]);
		}
		if (empty($parts[4]))
			user_error(sprintf(self::E_Pattern,$pattern));
		$url=parse_url($parts[4]);
		parse_str(@$url['query'],$GLOBALS['_GET']);
		if (preg_match('/GET|HEAD/',$verb))
			$GLOBALS['_GET']=array_merge($GLOBALS['_GET'],$args);
		$GLOBALS['_POST']=$verb=='POST'?$args:array();
		$GLOBALS['_REQUEST']=array_merge($GLOBALS['_GET'],$GLOBALS['_POST']);
		foreach ($headers?:array() as $key=>$val)
			$_SERVER['HTTP_'.strtr(strtoupper($key),'-','_')]=$val;
		$this->hive['VERB']=$verb;
		$this->hive['URI']=$this->hive['BASE'].$url['path'];
		if ($GLOBALS['_GET'])
			$this->hive['URI'].='?'.http_build_query($GLOBALS['_GET']);
		$this->hive['BODY']='';
		if (!preg_match('/GET|HEAD/',$verb))
			$this->hive['BODY']=$body?:http_build_query($args);
		$this->hive['AJAX']=isset($parts[5]) &&
			preg_match('/ajax/i',$parts[5]);
=======
		die;
	}

	/**
		Mock HTTP request
		@return NULL
		@param $pattern string
		@param $args array
		@param $headers array
		@param $body string
	**/
	function mock($pattern,array $args=NULL,array $headers=NULL,$body=NULL) {
		$types=array('sync','ajax');
		preg_match('/([\|\w]+)\h+([^\h]+)'.
			'(?:\h+\[('.implode('|',$types).')\])?/',$pattern,$parts);
		if (empty($parts[2]))
			user_error(sprintf(self::E_Pattern,$pattern));
		$verb=strtoupper($parts[1]);
		$url=parse_url($parts[2]);
		$query='';
		if ($args)
			$query.=http_build_query($args);
		$query.=isset($url['query'])?(($query?'&':'').$url['query']):'';
		if ($query && preg_match('/GET|POST/',$verb)) {
			parse_str($query,$GLOBALS['_'.$verb]);
			parse_str($query,$GLOBALS['_REQUEST']);
		}
		foreach ($headers?:array() as $key=>$val)
			$_SERVER['HTTP_'.str_replace('-','_',strtoupper($key))]=$val;
		$this->hive['VERB']=$verb;
		$this->hive['URI']=$this->hive['BASE'].$url['path'];
		$this->hive['AJAX']=isset($parts[3]) &&
			preg_match('/ajax/i',$parts[3]);
		if (preg_match('/GET|HEAD/',$verb) && $query)
			$this->hive['URI'].='?'.$query;
		else
			$this->hive['BODY']=$body?:$query;
>>>>>>> 3.0.4 release
		$this->run();
	}

	/**
<<<<<<< HEAD
	*	Bind handler to route pattern
	*	@return NULL
	*	@param $pattern string|array
	*	@param $handler callback
	*	@param $ttl int
	*	@param $kbps int
	**/
	function route($pattern,$handler,$ttl=0,$kbps=0) {
		$types=array('sync','ajax');
		if (is_array($pattern)) {
			foreach ($pattern as $item)
				$this->route($item,$handler,$ttl,$kbps);
			return;
		}
		preg_match('/([\|\w]+)\h+(?:(?:@(\w+)\h*:\h*)?([^\h]+)|@(\w+))'.
			'(?:\h+\[('.implode('|',$types).')\])?/',$pattern,$parts);
		if (isset($parts[2]) && $parts[2])
			$this->hive['ALIASES'][$parts[2]]=$parts[3];
		elseif (!empty($parts[4])) {
			if (empty($this->hive['ALIASES'][$parts[4]]))
				user_error(sprintf(self::E_Named,$parts[4]));
			$parts[3]=$this->hive['ALIASES'][$parts[4]];
		}
		if (empty($parts[3]))
			user_error(sprintf(self::E_Pattern,$pattern));
		$type=empty($parts[5])?
			self::REQ_SYNC|self::REQ_AJAX:
			constant('self::REQ_'.strtoupper($parts[5]));
		foreach ($this->split($parts[1]) as $verb) {
			if (!preg_match('/'.self::VERBS.'/',$verb))
				$this->error(501,$verb.' '.$this->hive['URI']);
			$this->hive['ROUTES'][str_replace('@',"\x00".'@',$parts[3])]
				[$type][strtoupper($verb)]=array($handler,$ttl,$kbps);
=======
		Bind handler to route pattern
		@return NULL
		@param $pattern string
		@param $handler callback
		@param $ttl int
		@param $kbps int
	**/
	function route($pattern,$handler,$ttl=0,$kbps=0) {
		$types=array('sync','ajax');
		preg_match('/([\|\w]+)\h+([^\h]+)'.
			'(?:\h+\[('.implode('|',$types).')\])?/',$pattern,$parts);
		if (empty($parts[2]))
			user_error(sprintf(self::E_Pattern,$pattern));
		$type=empty($parts[3])?
			self::REQ_SYNC|self::REQ_AJAX:
			constant('self::REQ_'.strtoupper($parts[3]));
		foreach ($this->split($parts[1]) as $verb) {
			if (!preg_match('/'.self::VERBS.'/',$verb))
				$this->error(501,$verb.' '.$this->hive['URI']);
			$this->hive['ROUTES'][$parts[2]][$type]
				[strtoupper($verb)]=array($handler,$ttl,$kbps);
>>>>>>> 3.0.4 release
		}
	}

	/**
<<<<<<< HEAD
	*	Reroute to specified URI
	*	@return NULL
	*	@param $url string
	*	@param $permanent bool
	**/
	function reroute($url,$permanent=FALSE) {
		if (($handler=$this->hive['ONREROUTE']) && $this->call($handler,array($url,$permanent))!==FALSE)
			return;
		if (PHP_SAPI!='cli') {
			if (preg_match('/^(?:@(\w+)(?:(\(.+?)\))*|https?:\/\/)/',
				$url,$parts)) {
				if (isset($parts[1])) {
					if (empty($this->hive['ALIASES'][$parts[1]]))
						user_error(sprintf(self::E_Named,$parts[1]));
					$url=$this->hive['BASE'].
						$this->hive['ALIASES'][$parts[1]];
					if (isset($parts[2]))
						$this->parse($parts[2]);
					$url=$this->build($url);
				}
			}
			else
				$url=$this->hive['BASE'].$url;
			header('Location: '.$url);
			$this->status($permanent?301:302);
			die;
		}
		$this->mock('GET '.$url);
	}

	/**
	*	Provide ReST interface by mapping HTTP verb to class method
	*	@return NULL
	*	@param $url string
	*	@param $class string
	*	@param $ttl int
	*	@param $kbps int
	**/
	function map($url,$class,$ttl=0,$kbps=0) {
		if (is_array($url)) {
			foreach ($url as $item)
				$this->map($item,$class,$ttl,$kbps);
			return;
		}
		foreach (explode('|',self::VERBS) as $method)
			$this->route($method.' '.$url,
				$class.'->'.strtolower($method),$ttl,$kbps);
	}

	/**
	*	Redirect a route to another URL
	*	@return NULL
	*	@param $pattern string|array
	*	@param $url string
	*/
	function redirect($pattern,$url) {
		if (is_array($pattern)) {
			foreach ($pattern as $item)
				$this->redirect($item,$url);
			return;
		}
		$this->route($pattern,function($this) use($url) {
			$this->reroute($url);
		});
	}

	/**
	*	Return TRUE if IPv4 address exists in DNSBL
	*	@return bool
	*	@param $ip string
=======
		Reroute to specified URI
		@return NULL
		@param $uri string
	**/
	function reroute($uri) {
		if (PHP_SAPI!='cli') {
			@session_commit();
			header('Location: '.(preg_match('/^https?:\/\//',$uri)?
				$uri:($this->hive['BASE'].$uri)));
			$this->status($this->hive['VERB']=='GET'?301:303);
			die;
		}
		$this->mock('GET '.$uri);
	}

	/**
		Provide ReST interface by mapping HTTP verb to class method
		@param $url string
		@param $class string
		@param $ttl int
		@param $kbps int
	**/
	function map($url,$class,$ttl=0,$kbps=0) {
		foreach (explode('|',self::VERBS) as $method)
			$this->route($method.' '.
				$url,$class.'->'.strtolower($method),$ttl,$kbps);
	}

	/**
		Return TRUE if IPv4 address exists in DNSBL
		@return bool
		@param $ip string
>>>>>>> 3.0.4 release
	**/
	function blacklisted($ip) {
		if ($this->hive['DNSBL'] &&
			!in_array($ip,
				is_array($this->hive['EXEMPT'])?
					$this->hive['EXEMPT']:
					$this->split($this->hive['EXEMPT']))) {
			// Reverse IPv4 dotted quad
			$rev=implode('.',array_reverse(explode('.',$ip)));
			foreach (is_array($this->hive['DNSBL'])?
				$this->hive['DNSBL']:
				$this->split($this->hive['DNSBL']) as $server)
				// DNSBL lookup
				if (checkdnsrr($rev.'.'.$server,'A'))
					return TRUE;
		}
		return FALSE;
	}

	/**
<<<<<<< HEAD
	*	Match routes against incoming URI
	*	@return NULL
=======
		Match routes against incoming URI
		@return NULL
>>>>>>> 3.0.4 release
	**/
	function run() {
		if ($this->blacklisted($this->hive['IP']))
			// Spammer detected
			$this->error(403);
		if (!$this->hive['ROUTES'])
			// No routes defined
			user_error(self::E_Routes);
		// Match specific routes first
		krsort($this->hive['ROUTES']);
		// Convert to BASE-relative URL
		$req=preg_replace(
<<<<<<< HEAD
			'/^'.preg_quote($this->hive['BASE'],'/').'(\/.*|$)/','\1',
=======
			'/^'.preg_quote($this->hive['BASE'],'/').'\b(.*)/','\1',
>>>>>>> 3.0.4 release
			$this->hive['URI']
		);
		$allowed=array();
		$case=$this->hive['CASELESS']?'i':'';
<<<<<<< HEAD
		foreach ($this->hive['ROUTES'] as $url=>$routes) {
			$url=str_replace("\x00".'@','@',$url);
			if (!preg_match('/^'.
				preg_replace('/@(\w+\b)/','(?P<\1>[^\/\?]+)',
				str_replace('\*','([^\?]*)',preg_quote($url,'/'))).
				'\/?(?:\?.*)?$/'.$case.'um',$req,$args))
				continue;
			ksort($args);
			$route=NULL;
			if (isset($routes[$this->hive['AJAX']+1]))
				$route=$routes[$this->hive['AJAX']+1];
			elseif (isset($routes[self::REQ_SYNC|self::REQ_AJAX]))
				$route=$routes[self::REQ_SYNC|self::REQ_AJAX];
			if (!$route)
				continue;
			if ($this->hive['VERB']!='OPTIONS' &&
				isset($route[$this->hive['VERB']])) {
=======
		foreach ($this->hive['ROUTES'] as $url=>$types) {
			if (!preg_match('/^'.
				preg_replace('/@(\w+\b)/','(?P<\1>[^\/\?]+)',
				str_replace('\*','(.*)',preg_quote($url,'/'))).
				'\/?(?:\?.*)?$/'.$case.'um',$req,$args))
				continue;
			$route=NULL;
			if (isset($types[$this->hive['AJAX']+1]))
				$route=$types[$this->hive['AJAX']+1];
			elseif (isset($types[self::REQ_SYNC|self::REQ_AJAX]))
				$route=$types[self::REQ_SYNC|self::REQ_AJAX];
			if (!$route)
				continue;
			if (isset($route[$this->hive['VERB']])) {
>>>>>>> 3.0.4 release
				$parts=parse_url($req);
				if ($this->hive['VERB']=='GET' &&
					preg_match('/.+\/$/',$parts['path']))
					$this->reroute(substr($parts['path'],0,-1).
						(isset($parts['query'])?('?'.$parts['query']):''));
				list($handler,$ttl,$kbps)=$route[$this->hive['VERB']];
				if (is_bool(strpos($url,'/*')))
					foreach (array_keys($args) as $key)
						if (is_numeric($key) && $key)
							unset($args[$key]);
<<<<<<< HEAD
				if (is_string($handler)) {
=======
				if (is_string($handler))
>>>>>>> 3.0.4 release
					// Replace route pattern tokens in handler if any
					$handler=preg_replace_callback('/@(\w+\b)/',
						function($id) use($args) {
							return isset($args[$id[1]])?$args[$id[1]]:$id[0];
						},
						$handler
					);
<<<<<<< HEAD
					if (preg_match('/(.+)\h*(?:->|::)/',$handler,$match) &&
						!class_exists($match[1]))
						$this->error(404);
				}
=======
>>>>>>> 3.0.4 release
				// Capture values of route pattern tokens
				$this->hive['PARAMS']=$args=array_map('urldecode',$args);
				// Save matching route
				$this->hive['PATTERN']=$url;
				// Process request
<<<<<<< HEAD
				$body='';
=======
>>>>>>> 3.0.4 release
				$now=microtime(TRUE);
				if (preg_match('/GET|HEAD/',$this->hive['VERB']) &&
					isset($ttl)) {
					// Only GET and HEAD requests are cacheable
					$headers=$this->hive['HEADERS'];
					$cache=Cache::instance();
					$cached=$cache->exists(
						$hash=$this->hash($this->hive['VERB'].' '.
							$this->hive['URI']).'.url',$data);
<<<<<<< HEAD
					if ($cached && $cached[0]+$ttl>$now) {
=======
					if ($cached && $cached+$ttl>$now) {
						if (isset($headers['If-Modified-Since']) &&
							strtotime($headers['If-Modified-Since'])>
							floor($cached)) {
							// HTTP client-cached page is fresh
							$this->status(304);
							die;
						}
>>>>>>> 3.0.4 release
						// Retrieve from cache backend
						list($headers,$body)=$data;
						if (PHP_SAPI!='cli')
							array_walk($headers,'header');
<<<<<<< HEAD
						$this->expire($cached[0]+$ttl-$now);
=======
						$this->expire($cached+$ttl-$now);
>>>>>>> 3.0.4 release
					}
					else
						// Expire HTTP client-cached page
						$this->expire($ttl);
				}
				else
					$this->expire(0);
<<<<<<< HEAD
				if (!strlen($body)) {
					if (!$this->hive['RAW'] && !$this->hive['BODY'])
						$this->hive['BODY']=file_get_contents('php://input');
					ob_start();
					// Call route handler
					$this->call($handler,array($this,$args),
						'beforeroute,afterroute');
					$body=ob_get_clean();
					if ($ttl && !error_get_last())
						// Save to cache backend
						$cache->set($hash,array(headers_list(),$body),$ttl);
				}
=======
				ob_start();
				// Call route handler
				$this->call($handler,array($this,$args),
					'beforeroute,afterroute');
				$body=ob_get_clean();
				if ($ttl && !error_get_last())
					// Save to cache backend
					$cache->set($hash,array(headers_list(),$body),$ttl);
>>>>>>> 3.0.4 release
				$this->hive['RESPONSE']=$body;
				if (!$this->hive['QUIET']) {
					if ($kbps) {
						$ctr=0;
						foreach (str_split($body,1024) as $part) {
							// Throttle output
							$ctr++;
<<<<<<< HEAD
							if ($ctr/$kbps>($elapsed=microtime(TRUE)-$now) &&
=======
							if ($ctr/$kbps>$elapsed=microtime(TRUE)-$now &&
>>>>>>> 3.0.4 release
								!connection_aborted())
								usleep(1e6*($ctr/$kbps-$elapsed));
							echo $part;
						}
					}
					else
						echo $body;
				}
				return;
			}
			$allowed=array_keys($route);
			break;
		}
		if (!$allowed)
			// URL doesn't match any route
			$this->error(404);
		elseif (PHP_SAPI!='cli') {
			// Unhandled HTTP method
			header('Allow: '.implode(',',$allowed));
			if ($this->hive['VERB']!='OPTIONS')
				$this->error(405);
		}
	}

	/**
<<<<<<< HEAD
	*	Execute callback/hooks (supports 'class->method' format)
	*	@return mixed|FALSE
	*	@param $func callback
	*	@param $args mixed
	*	@param $hooks string
=======
		Execute callback/hooks (supports 'class->method' format)
		@return mixed|FALSE
		@param $func callback
		@param $args mixed
		@param $hooks string
>>>>>>> 3.0.4 release
	**/
	function call($func,$args=NULL,$hooks='') {
		if (!is_array($args))
			$args=array($args);
		// Execute function; abort if callback/hook returns FALSE
		if (is_string($func) &&
			preg_match('/(.+)\h*(->|::)\h*(.+)/s',$func,$parts)) {
			// Convert string to executable PHP callback
			if (!class_exists($parts[1]))
<<<<<<< HEAD
				user_error(sprintf(self::E_Class,
					is_string($func)?$parts[1]:$this->stringify()));
			if ($parts[2]=='->')
				$parts[1]=is_subclass_of($parts[1],'Prefab')?
					call_user_func($parts[1].'::instance'):
					new $parts[1]($this);
			$func=array($parts[1],$parts[3]);
		}
		if (!is_callable($func))
			// No route handler
			if ($hooks=='beforeroute,afterroute') {
				$allowed='';
				if (isset($parts[1]))
					$allowed=array_intersect(
						array_map('strtoupper',get_class_methods($parts[1])),
						explode('|',self::VERBS)
					);
				header('Allow: '.implode(',',$allowed));
				$this->error(405);
			}
			else
				user_error(sprintf(self::E_Method,
					is_string($func)?$func:$this->stringify($func)));
=======
				$this->error(404);
			if ($parts[2]=='->')
				$parts[1]=is_subclass_of($parts[1],'Prefab')?
					call_user_func($parts[1].'::instance'):
					new $parts[1];
			$func=array($parts[1],$parts[3]);
		}
		if (!is_callable($func) && $hooks=='beforeroute,afterroute')
			// No route handler
			$this->error(404);
>>>>>>> 3.0.4 release
		$obj=FALSE;
		if (is_array($func)) {
			$hooks=$this->split($hooks);
			$obj=TRUE;
		}
		// Execute pre-route hook if any
		if ($obj && $hooks && in_array($hook='beforeroute',$hooks) &&
			method_exists($func[0],$hook) &&
			call_user_func_array(array($func[0],$hook),$args)===FALSE)
			return FALSE;
		// Execute callback
		$out=call_user_func_array($func,$args?:array());
		if ($out===FALSE)
			return FALSE;
		// Execute post-route hook if any
		if ($obj && $hooks && in_array($hook='afterroute',$hooks) &&
			method_exists($func[0],$hook) &&
			call_user_func_array(array($func[0],$hook),$args)===FALSE)
			return FALSE;
		return $out;
	}

	/**
<<<<<<< HEAD
	*	Execute specified callbacks in succession; Apply same arguments
	*	to all callbacks
	*	@return array
	*	@param $funcs array|string
	*	@param $args mixed
=======
		Execute specified callbacks in succession; Apply same arguments
		to all callbacks
		@return array
		@param $funcs array|string
		@param $args mixed
>>>>>>> 3.0.4 release
	**/
	function chain($funcs,$args=NULL) {
		$out=array();
		foreach (is_array($funcs)?$funcs:$this->split($funcs) as $func)
			$out[]=$this->call($func,$args);
		return $out;
	}

	/**
<<<<<<< HEAD
	*	Execute specified callbacks in succession; Relay result of
	*	previous callback as argument to the next callback
	*	@return array
	*	@param $funcs array|string
	*	@param $args mixed
=======
		Execute specified callbacks in succession; Relay result of
		previous callback as argument to the next callback
		@return array
		@param $funcs array|string
		@param $args mixed
>>>>>>> 3.0.4 release
	**/
	function relay($funcs,$args=NULL) {
		foreach (is_array($funcs)?$funcs:$this->split($funcs) as $func)
			$args=array($this->call($func,$args));
		return array_shift($args);
	}

	/**
<<<<<<< HEAD
	*	Configure framework according to .ini-style file settings
	*	@return NULL
	*	@param $file string
=======
		Configure framework according to .ini-style file settings
		@return NULL
		@param $file string
>>>>>>> 3.0.4 release
	**/
	function config($file) {
		preg_match_all(
			'/(?<=^|\n)(?:'.
<<<<<<< HEAD
				'\[(?<section>.+?)\]|'.
				'(?<lval>[^\h\r\n;].*?)\h*=\h*'.
				'(?<rval>(?:\\\\\h*\r?\n|.+?)*)'.
			')(?=\r?\n|$)/',
			$this->read($file),$matches,PREG_SET_ORDER);
		if ($matches) {
			$sec='globals';
			foreach ($matches as $match) {
				if ($match['section'])
					$sec=$match['section'];
				elseif (in_array($sec,array('routes','maps','redirects'))) {
					call_user_func_array(
						array($this,rtrim($sec,'s')),
						array_merge(array($match['lval']),
							str_getcsv($match['rval'])));
=======
			'(?:;[^\n]*)|(?:<\?php.+?\?>?)|'.
			'(?:\[(.+?)\])|'.
			'(.+?)\h*=\h*'.
			'((?:\\\\\h*\r?\n|.+?)*)'.
			')(?=\r?\n|$)/',
			file_get_contents($file),$matches,PREG_SET_ORDER);
		if ($matches) {
			$sec='globals';
			foreach ($matches as $match) {
				if (count($match)<2)
					continue;
				if ($match[1])
					$sec=$match[1];
				elseif (in_array($sec,array('routes','maps'))) {
					call_user_func_array(
						array($this,rtrim($sec,'s')),
						array_merge(array($match[2]),str_getcsv($match[3])));
>>>>>>> 3.0.4 release
				}
				else {
					$args=array_map(
						function($val) {
<<<<<<< HEAD
							if (is_numeric($val))
								return $val+0;
							$val=ltrim($val);
							if (preg_match('/^\w+$/i',$val) && defined($val))
								return constant($val);
							return preg_replace('/\\\\\h*(\r?\n)/','\1',$val);
						},
						// Mark quoted strings with 0x00 whitespace
						str_getcsv(preg_replace('/(?<!\\\\)(")(.*?)\1/',
							"\\1\x00\\2\\1",$match['rval']))
					);
					call_user_func_array(array($this,'set'),
						array_merge(
							array($match['lval']),
=======
							$quote=(isset($val[0]) && $val[0]=="\x00");
							$val=trim($val);
							if (!$quote && is_numeric($val))
								return $val+0;
							if (preg_match('/^\w+$/i',$val) && defined($val))
								return constant($val);
							return preg_replace(
								'/\\\\\h*\r?\n/','',$val);
						},
						str_getcsv(
							// Mark quoted strings with 0x00 whitespace
							preg_replace('/"(.+?)"/',"\x00\\1",$match[3]))
					);
					call_user_func_array(array($this,'set'),
						array_merge(
							array($match[2]),
>>>>>>> 3.0.4 release
							count($args)>1?array($args):$args));
				}
			}
		}
	}

	/**
<<<<<<< HEAD
	*	Create mutex, invoke callback then drop ownership when done
	*	@return mixed
	*	@param $id string
	*	@param $func callback
	*	@param $args mixed
=======
		Create mutex, invoke callback then drop ownership when done
		@return mixed
		@param $id string
		@param $func callback
		@param $args mixed
>>>>>>> 3.0.4 release
	**/
	function mutex($id,$func,$args=NULL) {
		if (!is_dir($tmp=$this->hive['TEMP']))
			mkdir($tmp,self::MODE,TRUE);
		// Use filesystem lock
		if (is_file($lock=$tmp.
			$this->hash($this->hive['ROOT'].$this->hive['BASE']).'.'.
			$this->hash($id).'.lock') &&
			filemtime($lock)+ini_get('max_execution_time')<microtime(TRUE))
			// Stale lock
			@unlink($lock);
<<<<<<< HEAD
		while (!($handle=@fopen($lock,'x')) && !connection_aborted())
=======
		while (!$handle=@fopen($lock,'x') && !connection_aborted())
>>>>>>> 3.0.4 release
			usleep(mt_rand(0,100));
		$out=$this->call($func,$args);
		fclose($handle);
		@unlink($lock);
		return $out;
	}

	/**
<<<<<<< HEAD
	*	Read file (with option to apply Unix LF as standard line ending)
	*	@return string
	*	@param $file string
	*	@param $lf bool
	**/
	function read($file,$lf=FALSE) {
		$out=@file_get_contents($file);
		return $lf?preg_replace('/\r\n|\r/',"\n",$out):$out;
	}

	/**
	*	Exclusive file write
	*	@return int|FALSE
	*	@param $file string
	*	@param $data mixed
	*	@param $append bool
=======
		Read file
		@return string
		@param $file string
	**/
	function read($file) {
		return file_get_contents($file);
	}

	/**
		Exclusive file write
		@return int|FALSE
		@param $file string
		@param $data mixed
		@param $append bool
>>>>>>> 3.0.4 release
	**/
	function write($file,$data,$append=FALSE) {
		return file_put_contents($file,$data,LOCK_EX|($append?FILE_APPEND:0));
	}

	/**
<<<<<<< HEAD
	*	Apply syntax highlighting
	*	@return string
	*	@param $text string
=======
		Apply syntax highlighting
		@return string
		@param $text string
>>>>>>> 3.0.4 release
	**/
	function highlight($text) {
		$out='';
		$pre=FALSE;
		$text=trim($text);
		if (!preg_match('/^<\?php/',$text)) {
			$text='<?php '.$text;
			$pre=TRUE;
		}
		foreach (token_get_all($text) as $token)
			if ($pre)
				$pre=FALSE;
			else
				$out.='<span'.
					(is_array($token)?
						(' class="'.
							substr(strtolower(token_name($token[0])),2).'">'.
							$this->encode($token[1]).''):
						('>'.$this->encode($token))).
					'</span>';
<<<<<<< HEAD
		return $out?('<code>'.$out.'</code>'):$text;
	}

	/**
	*	Dump expression with syntax highlighting
	*	@return NULL
	*	@param $expr mixed
=======
		return $out?('<code class="php">'.$out.'</code>'):$text;
	}

	/**
		Dump expression with syntax highlighting
		@return NULL
		@param $expr mixed
>>>>>>> 3.0.4 release
	**/
	function dump($expr) {
		echo $this->highlight($this->stringify($expr));
	}

	/**
<<<<<<< HEAD
	*	Return path relative to the base directory
	*	@return string
	*	@param $url string
	**/
	function rel($url) {
		return preg_replace('/(?:https?:\/\/)?'.
			preg_quote($this->hive['BASE'],'/').'/','',rtrim($url,'/'));
	}

	/**
	*	Namespace-aware class autoloader
	*	@return mixed
	*	@param $class string
=======
		Namespace-aware class autoloader
		@return mixed
		@param $class string
>>>>>>> 3.0.4 release
	**/
	protected function autoload($class) {
		$class=$this->fixslashes(ltrim($class,'\\'));
		foreach ($this->split($this->hive['PLUGINS'].';'.
			$this->hive['AUTOLOAD']) as $auto)
			if (is_file($file=$auto.$class.'.php') ||
<<<<<<< HEAD
				is_file($file=$auto.strtolower($class).'.php') ||
				is_file($file=strtolower($auto.$class).'.php'))
=======
				is_file($file=$auto.strtolower($class).'.php'))
>>>>>>> 3.0.4 release
				return require($file);
	}

	/**
<<<<<<< HEAD
	*	Execute framework/application shutdown sequence
	*	@return NULL
	*	@param $cwd string
	**/
	function unload($cwd) {
		chdir($cwd);
		if (!$error=error_get_last())
			@session_commit();
		$handler=$this->hive['UNLOAD'];
		if ((!$handler || $this->call($handler,$this)===FALSE) &&
			$error && in_array($error['type'],
			array(E_ERROR,E_PARSE,E_CORE_ERROR,E_COMPILE_ERROR)))
			// Fatal error detected
			$this->error(500,sprintf(self::E_Fatal,$error['message']));
	}

	/**
	*	Convenience method for checking hive key
	*	@return mixed
	*	@param $key string
	**/
	function offsetexists($key) {
		return $this->exists($key);
	}

	/**
	*	Convenience method for assigning hive value
	*	@return mixed
	*	@param $key string
	*	@param $val scalar
	**/
	function offsetset($key,$val) {
		return $this->set($key,$val);
	}

	/**
	*	Convenience method for retrieving hive value
	*	@return mixed
	*	@param $key string
	**/
	function &offsetget($key) {
		$val=&$this->ref($key);
		return $val;
	}

	/**
	*	Convenience method for removing hive key
	*	@return NULL
	*	@param $key string
	**/
	function offsetunset($key) {
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
	*	@return mixed
	*	@param $key string
	**/
	function __unset($key) {
		$this->offsetunset($key);
	}

	/**
	*	Call function identified by hive key
	*	@return mixed
	*	@param $key string
	**/
	function __call($key,$args) {
		return call_user_func_array($this->get($key),$args);
=======
		Execute framework/application shutdown sequence
		@return NULL
	**/
	function unload() {
		if (($error=error_get_last()) &&
			in_array($error['type'],
				array(E_ERROR,E_PARSE,E_CORE_ERROR,E_COMPILE_ERROR)))
			// Fatal error detected
			$this->error(500,sprintf(self::E_Fatal,$error['message']),
				array($error));
		if (isset($this->hive['UNLOAD']))
			$this->hive['UNLOAD']($this);
	}

	/**
		Return class instance
		@return object
	**/
	static function instance() {
		if (!Registry::exists($class=__CLASS__))
			Registry::set($class,new $class);
		return Registry::get($class);
>>>>>>> 3.0.4 release
	}

	//! Prohibit cloning
	private function __clone() {
	}

	//! Bootstrap
<<<<<<< HEAD
	function __construct() {
		// Managed directives
		ini_set('default_charset',$charset='UTF-8');
		if (extension_loaded('mbstring'))
			mb_internal_encoding($charset);
		ini_set('display_errors',0);
		// Deprecated directives
		@ini_set('magic_quotes_gpc',0);
		@ini_set('register_globals',0);
		// Intercept errors/exceptions; PHP5.3-compatible
		error_reporting((E_ALL|E_STRICT)&~E_NOTICE);
=======
	private function __construct() {
		// Managed directives
		ini_set('default_charset',$charset='UTF-8');
		ini_set('display_errors',0);
		// Deprecated directives
		ini_set('magic_quotes_gpc',0);
		ini_set('register_globals',0);
		// Abort on startup error
		// Intercept errors/exceptions; PHP5.3-compatible
		error_reporting(E_ALL|E_STRICT);
>>>>>>> 3.0.4 release
		$fw=$this;
		set_exception_handler(
			function($obj) use($fw) {
				$fw->error(500,$obj->getmessage(),$obj->gettrace());
			}
		);
		set_error_handler(
			function($code,$text) use($fw) {
				if (error_reporting())
<<<<<<< HEAD
					$fw->error(500,$text);
=======
					throw new ErrorException($text,$code);
>>>>>>> 3.0.4 release
			}
		);
		if (!isset($_SERVER['SERVER_NAME']))
			$_SERVER['SERVER_NAME']=gethostname();
		if (PHP_SAPI=='cli') {
			// Emulate HTTP request
			if (isset($_SERVER['argc']) && $_SERVER['argc']<2) {
				$_SERVER['argc']++;
				$_SERVER['argv'][1]='/';
			}
			$_SERVER['REQUEST_METHOD']='GET';
			$_SERVER['REQUEST_URI']=$_SERVER['argv'][1];
		}
<<<<<<< HEAD
		$headers=array();
		if (PHP_SAPI!='cli')
			foreach (array_keys($_SERVER) as $key)
				if (substr($key,0,5)=='HTTP_')
					$headers[strtr(ucwords(strtolower(strtr(
						substr($key,5),'_',' '))),' ','-')]=&$_SERVER[$key];
		if (isset($headers['X-HTTP-Method-Override']))
			$_SERVER['REQUEST_METHOD']=$headers['X-HTTP-Method-Override'];
		elseif ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['_method']))
			$_SERVER['REQUEST_METHOD']=$_POST['_method'];
		$scheme=isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ||
			isset($headers['X-Forwarded-Proto']) &&
			$headers['X-Forwarded-Proto']=='https'?'https':'http';
		if (function_exists('apache_setenv')) {
			// Work around Apache pre-2.4 VirtualDocumentRoot bug
			$_SERVER['DOCUMENT_ROOT']=str_replace($_SERVER['SCRIPT_NAME'],'',
				$_SERVER['SCRIPT_FILENAME']);
			apache_setenv("DOCUMENT_ROOT",$_SERVER['DOCUMENT_ROOT']);
		}
		$_SERVER['DOCUMENT_ROOT']=realpath($_SERVER['DOCUMENT_ROOT']);
		$base='';
		if (PHP_SAPI!='cli')
			$base=implode('/',array_map('urlencode',
				explode('/',rtrim($this->fixslashes(
					dirname($_SERVER['SCRIPT_NAME'])),'/'))));
		$uri=parse_url($_SERVER['REQUEST_URI']);
		$path=preg_replace('/^'.preg_quote($base,'/').'/','',$uri['path']);
=======
		$headers=getallheaders();
		if (isset($headers['X-HTTP-Method-Override']))
			$_SERVER['REQUEST_METHOD']=$headers['X-HTTP-Method-Override'];
		$scheme=isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ||
			isset($headers['X-Forwarded-Proto']) &&
			$headers['X-Forwarded-Proto']=='https'?'https':'http';
		$base=implode('/',array_map('urlencode',
			explode('/',$this->fixslashes(
			preg_replace('/\/[^\/]+$/','',$_SERVER['SCRIPT_NAME'])))));
>>>>>>> 3.0.4 release
		call_user_func_array('session_set_cookie_params',
			$jar=array(
				'expire'=>0,
				'path'=>$base?:'/',
				'domain'=>is_int(strpos($_SERVER['SERVER_NAME'],'.')) &&
					!filter_var($_SERVER['SERVER_NAME'],FILTER_VALIDATE_IP)?
					$_SERVER['SERVER_NAME']:'',
				'secure'=>($scheme=='https'),
				'httponly'=>TRUE
			)
		);
		// Default configuration
		$this->hive=array(
<<<<<<< HEAD
			'AGENT'=>isset($headers['X-Operamini-Phone-UA'])?
				$headers['X-Operamini-Phone-UA']:
				(isset($headers['X-Skyfire-Phone'])?
					$headers['X-Skyfire-Phone']:
					(isset($headers['User-Agent'])?
						$headers['User-Agent']:'')),
			'AJAX'=>isset($headers['X-Requested-With']) &&
				$headers['X-Requested-With']=='XMLHttpRequest',
			'ALIASES'=>array(),
			'AUTOLOAD'=>'./',
			'BASE'=>$base,
			'BITMASK'=>ENT_COMPAT,
			'BODY'=>NULL,
=======
			'AJAX'=>isset($headers['X-Requested-With']) &&
				$headers['X-Requested-With']=='XMLHttpRequest',
			'AUTOLOAD'=>'./',
			'BASE'=>$base,
			'BODY'=>file_get_contents('php://input'),
>>>>>>> 3.0.4 release
			'CACHE'=>FALSE,
			'CASELESS'=>TRUE,
			'DEBUG'=>0,
			'DIACRITICS'=>array(),
			'DNSBL'=>'',
<<<<<<< HEAD
			'EMOJI'=>array(),
=======
>>>>>>> 3.0.4 release
			'ENCODING'=>$charset,
			'ERROR'=>NULL,
			'ESCAPE'=>TRUE,
			'EXEMPT'=>NULL,
			'FALLBACK'=>$this->fallback,
<<<<<<< HEAD
			'FRAGMENT'=>isset($uri['fragment'])?$uri['fragment']:'',
			'HEADERS'=>$headers,
			'HALT'=>TRUE,
=======
			'HEADERS'=>$headers,
>>>>>>> 3.0.4 release
			'HIGHLIGHT'=>TRUE,
			'HOST'=>$_SERVER['SERVER_NAME'],
			'IP'=>isset($headers['Client-IP'])?
				$headers['Client-IP']:
<<<<<<< HEAD
				(isset($headers['X-Forwarded-For'])?
					$headers['X-Forwarded-For']:
=======
				(isset($headers['X-Forwarded-For']) &&
				($ip=strstr($headers['X-Forwarded-For'],',',TRUE))?
					$ip:
>>>>>>> 3.0.4 release
					(isset($_SERVER['REMOTE_ADDR'])?
						$_SERVER['REMOTE_ADDR']:'')),
			'JAR'=>$jar,
			'LANGUAGE'=>isset($headers['Accept-Language'])?
<<<<<<< HEAD
				$this->language($headers['Accept-Language']):
				$this->fallback,
			'LOCALES'=>'./',
			'LOGS'=>'./',
			'ONERROR'=>NULL,
			'ONREROUTE'=>NULL,
			'PACKAGE'=>self::PACKAGE,
			'PARAMS'=>array(),
			'PATH'=>$path,
=======
				$this->language($headers['Accept-Language']):$this->fallback,
			'LOCALES'=>'./',
			'LOGS'=>'./',
			'ONERROR'=>NULL,
			'PACKAGE'=>self::PACKAGE,
			'PARAMS'=>array(),
>>>>>>> 3.0.4 release
			'PATTERN'=>NULL,
			'PLUGINS'=>$this->fixslashes(__DIR__).'/',
			'PORT'=>isset($_SERVER['SERVER_PORT'])?
				$_SERVER['SERVER_PORT']:NULL,
<<<<<<< HEAD
			'PREFIX'=>NULL,
			'QUERY'=>isset($uri['query'])?$uri['query']:'',
			'QUIET'=>FALSE,
			'RAW'=>FALSE,
=======
			'QUIET'=>FALSE,
>>>>>>> 3.0.4 release
			'REALM'=>$scheme.'://'.
				$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
			'RESPONSE'=>'',
			'ROOT'=>$_SERVER['DOCUMENT_ROOT'],
			'ROUTES'=>array(),
			'SCHEME'=>$scheme,
			'SERIALIZER'=>extension_loaded($ext='igbinary')?$ext:'php',
			'TEMP'=>'tmp/',
			'TIME'=>microtime(TRUE),
<<<<<<< HEAD
			'TZ'=>(@ini_get('date.timezone'))?:'UTC',
=======
			'TZ'=>date_default_timezone_get(),
>>>>>>> 3.0.4 release
			'UI'=>'./',
			'UNLOAD'=>NULL,
			'UPLOADS'=>'./',
			'URI'=>&$_SERVER['REQUEST_URI'],
			'VERB'=>&$_SERVER['REQUEST_METHOD'],
<<<<<<< HEAD
			'VERSION'=>self::VERSION,
			'XFRAME'=>'SAMEORIGIN'
=======
			'VERSION'=>self::VERSION
>>>>>>> 3.0.4 release
		);
		if (PHP_SAPI=='cli-server' &&
			preg_match('/^'.preg_quote($base,'/').'$/',$this->hive['URI']))
			$this->reroute('/');
		if (ini_get('auto_globals_jit'))
			// Override setting
			$GLOBALS+=array('_ENV'=>$_ENV,'_REQUEST'=>$_REQUEST);
		// Sync PHP globals with corresponding hive keys
		$this->init=$this->hive;
		foreach (explode('|',self::GLOBALS) as $global) {
			$sync=$this->sync($global);
			$this->init+=array(
				$global=>preg_match('/SERVER|ENV/',$global)?$sync:array()
			);
		}
		if ($error=error_get_last())
			// Error detected
			$this->error(500,sprintf(self::E_Fatal,$error['message']),
				array($error));
<<<<<<< HEAD
		date_default_timezone_set($this->hive['TZ']);
		// Register framework autoloader
		spl_autoload_register(array($this,'autoload'));
		// Register shutdown handler
		register_shutdown_function(array($this,'unload'),getcwd());
=======
		// Register framework autoloader
		spl_autoload_register(array($this,'autoload'));
		// Register shutdown handler
		register_shutdown_function(array($this,'unload'));
	}

	/**
		Wrap-up
		@return NULL
	**/
	function __destruct() {
		Registry::clear(__CLASS__);
>>>>>>> 3.0.4 release
	}

}

//! Cache engine
<<<<<<< HEAD
class Cache extends Prefab {

	protected
=======
final class Cache {

	private
>>>>>>> 3.0.4 release
		//! Cache DSN
		$dsn,
		//! Prefix for cache entries
		$prefix,
<<<<<<< HEAD
		//! MemCache or Redis object
		$ref;

	/**
	*	Return timestamp and TTL of cache entry or FALSE if not found
	*	@return array|FALSE
	*	@param $key string
	*	@param $val mixed
=======
		//! MemCache object
		$ref;

	/**
		Return timestamp of cache entry or FALSE if not found
		@return float|FALSE
		@param $key string
		@param $val mixed
>>>>>>> 3.0.4 release
	**/
	function exists($key,&$val=NULL) {
		$fw=Base::instance();
		if (!$this->dsn)
			return FALSE;
		$ndx=$this->prefix.'.'.$key;
		$parts=explode('=',$this->dsn,2);
		switch ($parts[0]) {
			case 'apc':
<<<<<<< HEAD
			case 'apcu':
				$raw=apc_fetch($ndx);
				break;
			case 'redis':
				$raw=$this->ref->get($ndx);
				break;
=======
				$raw=apc_fetch($ndx);
				break;
>>>>>>> 3.0.4 release
			case 'memcache':
				$raw=memcache_get($this->ref,$ndx);
				break;
			case 'wincache':
				$raw=wincache_ucache_get($ndx);
				break;
			case 'xcache':
				$raw=xcache_get($ndx);
				break;
			case 'folder':
<<<<<<< HEAD
				$raw=$fw->read($parts[1].$ndx);
				break;
		}
		if (!empty($raw)) {
			list($val,$time,$ttl)=(array)$fw->unserialize($raw);
			if ($ttl===0 || $time+$ttl>microtime(TRUE))
				return array($time,$ttl);
			$val=null;
=======
				if (is_file($file=$parts[1].$ndx))
					$raw=$fw->read($file);
				break;
		}
		if (isset($raw)) {
			list($val,$time,$ttl)=$fw->unserialize($raw);
			if (!$ttl || $time+$ttl>microtime(TRUE))
				return $time;
>>>>>>> 3.0.4 release
			$this->clear($key);
		}
		return FALSE;
	}

	/**
<<<<<<< HEAD
	*	Store value in cache
	*	@return mixed|FALSE
	*	@param $key string
	*	@param $val mixed
	*	@param $ttl int
=======
		Store value in cache
		@return mixed|FALSE
		@param $key string
		@param $val mixed
		@param $ttl int
>>>>>>> 3.0.4 release
	**/
	function set($key,$val,$ttl=0) {
		$fw=Base::instance();
		if (!$this->dsn)
			return TRUE;
		$ndx=$this->prefix.'.'.$key;
<<<<<<< HEAD
		$time=microtime(TRUE);
		if ($cached=$this->exists($key))
			list($time,$ttl)=$cached;
		$data=$fw->serialize(array($val,$time,$ttl));
		$parts=explode('=',$this->dsn,2);
		switch ($parts[0]) {
			case 'apc':
			case 'apcu':
				return apc_store($ndx,$data,$ttl);
			case 'redis':
				return $this->ref->set($ndx,$data,array('ex'=>$ttl));
=======
		$data=$fw->serialize(array($val,microtime(TRUE),$ttl));
		$parts=explode('=',$this->dsn,2);
		switch ($parts[0]) {
			case 'apc':
				return apc_store($ndx,$data,$ttl);
>>>>>>> 3.0.4 release
			case 'memcache':
				return memcache_set($this->ref,$ndx,$data,0,$ttl);
			case 'wincache':
				return wincache_ucache_set($ndx,$data,$ttl);
			case 'xcache':
				return xcache_set($ndx,$data,$ttl);
			case 'folder':
				return $fw->write($parts[1].$ndx,$data);
		}
		return FALSE;
	}

	/**
<<<<<<< HEAD
	*	Retrieve value of cache entry
	*	@return mixed|FALSE
	*	@param $key string
=======
		Retrieve value of cache entry
		@return mixed|FALSE
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function get($key) {
		return $this->dsn && $this->exists($key,$data)?$data:FALSE;
	}

	/**
<<<<<<< HEAD
	*	Delete cache entry
	*	@return bool
	*	@param $key string
=======
		Delete cache entry
		@return bool
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function clear($key) {
		if (!$this->dsn)
			return;
		$ndx=$this->prefix.'.'.$key;
		$parts=explode('=',$this->dsn,2);
		switch ($parts[0]) {
			case 'apc':
<<<<<<< HEAD
			case 'apcu':
				return apc_delete($ndx);
			case 'redis':
				return $this->ref->del($ndx);
=======
				return apc_delete($ndx);
>>>>>>> 3.0.4 release
			case 'memcache':
				return memcache_delete($this->ref,$ndx);
			case 'wincache':
				return wincache_ucache_delete($ndx);
			case 'xcache':
				return xcache_unset($ndx);
			case 'folder':
<<<<<<< HEAD
				return @unlink($parts[1].$ndx);
=======
				return is_file($file=$parts[1].$ndx) && @unlink($file);
>>>>>>> 3.0.4 release
		}
		return FALSE;
	}

	/**
<<<<<<< HEAD
	*	Clear contents of cache backend
	*	@return bool
	*	@param $suffix string
	*	@param $lifetime int
=======
		Clear contents of cache backend
		@return bool
		@param $suffix string
		@param $lifetime int
>>>>>>> 3.0.4 release
	**/
	function reset($suffix=NULL,$lifetime=0) {
		if (!$this->dsn)
			return TRUE;
		$regex='/'.preg_quote($this->prefix.'.','/').'.+?'.
			preg_quote($suffix,'/').'/';
		$parts=explode('=',$this->dsn,2);
		switch ($parts[0]) {
			case 'apc':
<<<<<<< HEAD
				$key='info';
			case 'apcu':
				if (empty($key))
					$key='key';
				$info=apc_cache_info('user');
				foreach ($info['cache_list'] as $item)
					if (preg_match($regex,$item[$key]) &&
						$item['mtime']+$lifetime<time())
						apc_delete($item[$key]);
				return TRUE;
			case 'redis':
				$fw=Base::instance();
				$keys=$this->ref->keys($this->prefix.'.*'.$suffix);
				foreach($keys as $key) {
					$val=$fw->unserialize($this->ref->get($key));
					if ($val[1]+$lifetime<time())
						$this->ref->del($key);
				}
=======
				$info=apc_cache_info('user');
				foreach ($info['cache_list'] as $item)
					if (preg_match($regex,$item['info']) &&
						$item['mtime']+$lifetime<time())
						apc_delete($item['info']);
>>>>>>> 3.0.4 release
				return TRUE;
			case 'memcache':
				foreach (memcache_get_extended_stats(
					$this->ref,'slabs') as $slabs)
<<<<<<< HEAD
					foreach (array_filter(array_keys($slabs),'is_numeric')
						as $id)
						foreach (memcache_get_extended_stats(
							$this->ref,'cachedump',$id) as $data)
=======
					foreach (array_keys($slabs) as $id)
						foreach (memcache_get_extended_stats(
							$this->ref,'cachedump',floor($id)) as $data)
>>>>>>> 3.0.4 release
							if (is_array($data))
								foreach ($data as $key=>$val)
									if (preg_match($regex,$key) &&
										$val[1]+$lifetime<time())
										memcache_delete($this->ref,$key);
				return TRUE;
			case 'wincache':
				$info=wincache_ucache_info();
				foreach ($info['ucache_entries'] as $item)
					if (preg_match($regex,$item['key_name']) &&
						$item['use_time']+$lifetime<time())
<<<<<<< HEAD
					wincache_ucache_delete($item['key_name']);
=======
					apc_delete($item['key_name']);
>>>>>>> 3.0.4 release
				return TRUE;
			case 'xcache':
				return TRUE; /* Not supported */
			case 'folder':
<<<<<<< HEAD
				if ($glob=@glob($parts[1].'*'))
					foreach ($glob as $file)
						if (preg_match($regex,basename($file)) &&
							filemtime($file)+$lifetime<time())
							@unlink($file);
=======
				foreach (glob($parts[1].'*') as $file)
					if (preg_match($regex,basename($file)) &&
						filemtime($file)+$lifetime<time())
						@unlink($file);
>>>>>>> 3.0.4 release
				return TRUE;
		}
		return FALSE;
	}

	/**
<<<<<<< HEAD
	*	Load/auto-detect cache backend
	*	@return string
	*	@param $dsn bool|string
	**/
	function load($dsn) {
		$fw=Base::instance();
		if ($dsn=trim($dsn)) {
			if (preg_match('/^redis=(.+)/',$dsn,$parts) &&
				extension_loaded('redis')) {
				$port=6379;
				$parts=explode(':',$parts[1],2);
				if (count($parts)>1)
					list($host,$port)=$parts;
				else
					$host=$parts[0];
				$this->ref=new Redis;
				if(!$this->ref->connect($host,$port,2))
					$this->ref=NULL;
			}
			elseif (preg_match('/^memcache=(.+)/',$dsn,$parts) &&
=======
		Load/auto-detect cache backend
		@return string
		@param $dsn bool|string
	**/
	function load($dsn) {
		if ($dsn=trim($dsn)) {
			$fw=Base::instance();
			if (preg_match('/^memcache=(.+)/',$dsn,$parts) &&
>>>>>>> 3.0.4 release
				extension_loaded('memcache'))
				foreach ($fw->split($parts[1]) as $server) {
					$port=11211;
					$parts=explode(':',$server,2);
					if (count($parts)>1)
						list($host,$port)=$parts;
					else
						$host=$parts[0];
					if (empty($this->ref))
						$this->ref=@memcache_connect($host,$port)?:NULL;
					else
						memcache_add_server($this->ref,$host,$port);
				}
			if (empty($this->ref) && !preg_match('/^folder\h*=/',$dsn))
				$dsn=($grep=preg_grep('/^(apc|wincache|xcache)/',
					array_map('strtolower',get_loaded_extensions())))?
						// Auto-detect
						current($grep):
						// Use filesystem as fallback
						('folder='.$fw->get('TEMP').'cache/');
			if (preg_match('/^folder\h*=\h*(.+)/',$dsn,$parts) &&
				!is_dir($parts[1]))
				mkdir($parts[1],Base::MODE,TRUE);
		}
<<<<<<< HEAD
		$this->prefix=$fw->hash($_SERVER['SERVER_NAME'].$fw->get('BASE'));
=======
>>>>>>> 3.0.4 release
		return $this->dsn=$dsn;
	}

	/**
<<<<<<< HEAD
	*	Class constructor
	*	@return object
	*	@param $dsn bool|string
	**/
	function __construct($dsn=FALSE) {
		if ($dsn)
			$this->load($dsn);
	}

}

//! View handler
class View extends Prefab {

	protected
		//! Template file
		$view,
		//! post-rendering handler
		$trigger,
		//! Nesting level
		$level=0;

	/**
	*	Encode characters to equivalent HTML entities
	*	@return string
	*	@param $arg mixed
	**/
	function esc($arg) {
		$fw=Base::instance();
		return $fw->recursive($arg,
			function($val) use($fw) {
				return is_string($val)?$fw->encode($val):$val;
			}
		);
	}

	/**
	*	Decode HTML entities to equivalent characters
	*	@return string
	*	@param $arg mixed
	**/
	function raw($arg) {
		$fw=Base::instance();
		return $fw->recursive($arg,
			function($val) use($fw) {
				return is_string($val)?$fw->decode($val):$val;
			}
		);
	}

	/**
	*	Create sandbox for template execution
	*	@return string
	*	@param $hive array
	**/
	protected function sandbox(array $hive=NULL) {
		$this->level++;
		$fw=Base::instance();
		if (!$hive)
			$hive=$fw->hive();
		if ($this->level<2) {
			if ($fw->get('ESCAPE'))
				$hive=$this->esc($hive);
			if (isset($hive['ALIASES']))
				$hive['ALIASES']=$fw->build($hive['ALIASES']);
		}
		extract($hive);
		unset($fw);
		unset($hive);
		ob_start();
		require($this->view);
		$this->level--;
		return ob_get_clean();
	}

	/**
	*	Render template
	*	@return string
	*	@param $file string
	*	@param $mime string
	*	@param $hive array
	*	@param $ttl int
	**/
	function render($file,$mime='text/html',array $hive=NULL,$ttl=0) {
		$fw=Base::instance();
		$cache=Cache::instance();
		$cached=$cache->exists($hash=$fw->hash($file),$data);
		if ($cached && $cached[0]+$ttl>microtime(TRUE))
			return $data;
		foreach ($fw->split($fw->get('UI').';./') as $dir)
			if (is_file($this->view=$fw->fixslashes($dir.$file))) {
				if (isset($_COOKIE[session_name()]))
					@session_start();
				$fw->sync('SESSION');
				if ($mime && PHP_SAPI!='cli')
					header('Content-Type: '.$mime.'; '.
						'charset='.$fw->get('ENCODING'));
				$data=$this->sandbox($hive);
				if(isset($this->trigger['afterrender']))
					foreach($this->trigger['afterrender'] as $func)
						$data=$fw->call($func,$data);
				if ($ttl)
					$cache->set($hash,$data);
				return $data;
			}
		user_error(sprintf(Base::E_Open,$file));
	}

	/**
	*	post rendering handler
	*	@param $func callback
	*/
	function afterrender($func) {
		$this->trigger['afterrender'][]=$func;
=======
		Return class instance
		@return object
	**/
	static function instance() {
		if (!Registry::exists($class=__CLASS__))
			Registry::set($class,new $class);
		return Registry::get($class);
	}

	//! Prohibit cloning
	private function __clone() {
	}

	//! Prohibit instantiation
	private function __construct() {
		$fw=Base::instance();
		$this->prefix=$fw->hash($fw->get('ROOT').$fw->get('BASE'));
	}

	/**
		Wrap-up
		@return NULL
	**/
	function __destruct() {
		Registry::clear(__CLASS__);
	}

}

//! Prefab for classes with constructors and static factory methods
abstract class Prefab {

	/**
		Return class instance
		@return object
	**/
	static function instance() {
		if (!Registry::exists($class=get_called_class()))
			Registry::set($class,new $class);
		return Registry::get($class);
	}

	/**
		Wrap-up
		@return NULL
	**/
	function __destruct() {
		Registry::clear(get_called_class());
>>>>>>> 3.0.4 release
	}

}

<<<<<<< HEAD
//! Lightweight template engine
class Preview extends View {

	protected
		//! MIME type
		$mime;

	/**
	*	Convert token to variable
	*	@return string
	*	@param $str string
	**/
	function token($str) {
		return trim(preg_replace('/\{\{(.+?)\}\}/s',trim('\1'),
			Base::instance()->compile($str)));
	}

	/**
	*	Assemble markup
	*	@return string
	*	@param $node string
	**/
	protected function build($node) {
		$self=$this;
		return preg_replace_callback(
			'/\{\{(.+?)\}\}(\n+)?/s',
			function($expr) use($self) {
				$str=trim($self->token($expr[1]));
				if (preg_match('/^([^|]+?)\h*\|(\h*\w+(?:\h*[,;]\h*\w+)*)/',
					$str,$parts)) {
					$str=$parts[1];
					foreach (Base::instance()->split($parts[2]) as $func)
						$str=(($func=='format')?'\Base::instance()':'$this').
							'->'.$func.'('.$str.')';
				}
				return '<?php echo '.$str.'; ?>'.
					(isset($expr[2])?$expr[2]:'');
			},
			preg_replace_callback(
				'/\{~(.+?)~\}/s',
				function($expr) use($self) {
					return '<?php '.$self->token($expr[1]).' ?>';
				},
				$node
			)
		);
	}

	/**
	*	Render template string
	*	@return string
	*	@param $str string
	*	@param $hive array
	**/
	function resolve($str,array $hive=NULL) {
		if (!$hive)
			$hive=\Base::instance()->hive();
		extract($hive);
		ob_start();
		eval(' ?>'.$this->build($str).'<?php ');
=======
//! View handler
class View extends Prefab {

	protected
		//! Template file
		$view,
		//! Local hive
		$hive;

	/**
		Create sandbox for template execution
		@return string
	**/
	protected function sandbox() {
		extract($this->hive);
		ob_start();
		require($this->view);
>>>>>>> 3.0.4 release
		return ob_get_clean();
	}

	/**
<<<<<<< HEAD
	*	Render template
	*	@return string
	*	@param $file string
	*	@param $mime string
	*	@param $hive array
	*	@param $ttl int
	**/
	function render($file,$mime='text/html',array $hive=NULL,$ttl=0) {
		$fw=Base::instance();
		$cache=Cache::instance();
		$cached=$cache->exists($hash=$fw->hash($file),$data);
		if ($cached && $cached[0]+$ttl>microtime(TRUE))
			return $data;
		if (!is_dir($tmp=$fw->get('TEMP')))
			mkdir($tmp,Base::MODE,TRUE);
		foreach ($fw->split($fw->get('UI')) as $dir)
			if (is_file($view=$fw->fixslashes($dir.$file))) {
				if (!is_file($this->view=($tmp.
					$fw->hash($fw->get('ROOT').$fw->get('BASE')).'.'.
					$fw->hash($view).'.php')) ||
					filemtime($this->view)<filemtime($view)) {
					// Remove PHP code and comments
					$text=preg_replace(
						'/(?<!["\'])\h*<\?(?:php|\s*=).+?\?>\h*(?!["\'])|'.
						'\{\*.+?\*\}/is','',
						$fw->read($view));
					if (method_exists($this,'parse'))
						$text=$this->parse($text);
					$fw->write($this->view,$this->build($text));
				}
				if (isset($_COOKIE[session_name()]))
					@session_start();
				$fw->sync('SESSION');
				if ($mime && PHP_SAPI!='cli')
					header('Content-Type: '.($this->mime=$mime).'; '.
						'charset='.$fw->get('ENCODING'));
				$data=$this->sandbox($hive);
				if(isset($this->trigger['afterrender']))
					foreach ($this->trigger['afterrender'] as $func)
						$data = $fw->call($func, $data);
				if ($ttl)
					$cache->set($hash,$data);
				return $data;
=======
		Render template
		@return string
		@param $file string
		@param $mime string
		@param $hive array
	**/
	function render($file,$mime='text/html',array $hive=NULL) {
		$fw=Base::instance();
		foreach ($fw->split($fw->get('UI')) as $dir)
			if (is_file($this->view=$fw->fixslashes($dir.$file))) {
				if (isset($_COOKIE[session_name()]))
					@session_start();
				$fw->sync('SESSION');
				if (!$hive)
					$hive=$fw->hive();
				$this->hive=$fw->get('ESCAPE')?$hive=$fw->esc($hive):$hive;
				if (PHP_SAPI!='cli')
					header('Content-Type: '.$mime.'; '.
						'charset='.$fw->get('ENCODING'));
				return $this->sandbox();
>>>>>>> 3.0.4 release
			}
		user_error(sprintf(Base::E_Open,$file));
	}

}

//! ISO language/country codes
class ISO extends Prefab {

	//@{ ISO 3166-1 country codes
	const
		CC_af='Afghanistan',
		CC_ax='Åland Islands',
		CC_al='Albania',
		CC_dz='Algeria',
		CC_as='American Samoa',
		CC_ad='Andorra',
		CC_ao='Angola',
		CC_ai='Anguilla',
		CC_aq='Antarctica',
		CC_ag='Antigua and Barbuda',
		CC_ar='Argentina',
		CC_am='Armenia',
		CC_aw='Aruba',
		CC_au='Australia',
		CC_at='Austria',
		CC_az='Azerbaijan',
		CC_bs='Bahamas',
		CC_bh='Bahrain',
		CC_bd='Bangladesh',
		CC_bb='Barbados',
		CC_by='Belarus',
		CC_be='Belgium',
		CC_bz='Belize',
		CC_bj='Benin',
		CC_bm='Bermuda',
		CC_bt='Bhutan',
		CC_bo='Bolivia',
		CC_bq='Bonaire, Sint Eustatius and Saba',
		CC_ba='Bosnia and Herzegovina',
		CC_bw='Botswana',
		CC_bv='Bouvet Island',
		CC_br='Brazil',
		CC_io='British Indian Ocean Territory',
		CC_bn='Brunei Darussalam',
		CC_bg='Bulgaria',
		CC_bf='Burkina Faso',
		CC_bi='Burundi',
		CC_kh='Cambodia',
		CC_cm='Cameroon',
		CC_ca='Canada',
		CC_cv='Cape Verde',
		CC_ky='Cayman Islands',
		CC_cf='Central African Republic',
		CC_td='Chad',
		CC_cl='Chile',
		CC_cn='China',
		CC_cx='Christmas Island',
		CC_cc='Cocos (Keeling) Islands',
		CC_co='Colombia',
		CC_km='Comoros',
		CC_cg='Congo',
		CC_cd='Congo, The Democratic Republic of',
		CC_ck='Cook Islands',
		CC_cr='Costa Rica',
		CC_ci='Côte d\'ivoire',
		CC_hr='Croatia',
		CC_cu='Cuba',
		CC_cw='Curaçao',
		CC_cy='Cyprus',
		CC_cz='Czech Republic',
		CC_dk='Denmark',
		CC_dj='Djibouti',
		CC_dm='Dominica',
		CC_do='Dominican Republic',
		CC_ec='Ecuador',
		CC_eg='Egypt',
		CC_sv='El Salvador',
		CC_gq='Equatorial Guinea',
		CC_er='Eritrea',
		CC_ee='Estonia',
		CC_et='Ethiopia',
		CC_fk='Falkland Islands (Malvinas)',
		CC_fo='Faroe Islands',
		CC_fj='Fiji',
		CC_fi='Finland',
		CC_fr='France',
		CC_gf='French Guiana',
		CC_pf='French Polynesia',
		CC_tf='French Southern Territories',
		CC_ga='Gabon',
		CC_gm='Gambia',
		CC_ge='Georgia',
		CC_de='Germany',
		CC_gh='Ghana',
		CC_gi='Gibraltar',
		CC_gr='Greece',
		CC_gl='Greenland',
		CC_gd='Grenada',
		CC_gp='Guadeloupe',
		CC_gu='Guam',
		CC_gt='Guatemala',
		CC_gg='Guernsey',
		CC_gn='Guinea',
		CC_gw='Guinea-Bissau',
		CC_gy='Guyana',
		CC_ht='Haiti',
		CC_hm='Heard Island and McDonald Islands',
		CC_va='Holy See (Vatican City State)',
		CC_hn='Honduras',
		CC_hk='Hong Kong',
		CC_hu='Hungary',
		CC_is='Iceland',
		CC_in='India',
		CC_id='Indonesia',
		CC_ir='Iran, Islamic Republic of',
		CC_iq='Iraq',
		CC_ie='Ireland',
		CC_im='Isle of Man',
		CC_il='Israel',
		CC_it='Italy',
		CC_jm='Jamaica',
		CC_jp='Japan',
		CC_je='Jersey',
		CC_jo='Jordan',
		CC_kz='Kazakhstan',
		CC_ke='Kenya',
		CC_ki='Kiribati',
		CC_kp='Korea, Democratic People\'s Republic of',
		CC_kr='Korea, Republic of',
		CC_kw='Kuwait',
		CC_kg='Kyrgyzstan',
		CC_la='Lao People\'s Democratic Republic',
		CC_lv='Latvia',
		CC_lb='Lebanon',
		CC_ls='Lesotho',
		CC_lr='Liberia',
		CC_ly='Libya',
		CC_li='Liechtenstein',
		CC_lt='Lithuania',
		CC_lu='Luxembourg',
		CC_mo='Macao',
		CC_mk='Macedonia, The Former Yugoslav Republic of',
		CC_mg='Madagascar',
		CC_mw='Malawi',
		CC_my='Malaysia',
		CC_mv='Maldives',
		CC_ml='Mali',
		CC_mt='Malta',
		CC_mh='Marshall Islands',
		CC_mq='Martinique',
		CC_mr='Mauritania',
		CC_mu='Mauritius',
		CC_yt='Mayotte',
		CC_mx='Mexico',
		CC_fm='Micronesia, Federated States of',
		CC_md='Moldova, Republic of',
		CC_mc='Monaco',
		CC_mn='Mongolia',
		CC_me='Montenegro',
		CC_ms='Montserrat',
		CC_ma='Morocco',
		CC_mz='Mozambique',
		CC_mm='Myanmar',
		CC_na='Namibia',
		CC_nr='Nauru',
		CC_np='Nepal',
		CC_nl='Netherlands',
		CC_nc='New Caledonia',
		CC_nz='New Zealand',
		CC_ni='Nicaragua',
		CC_ne='Niger',
		CC_ng='Nigeria',
		CC_nu='Niue',
		CC_nf='Norfolk Island',
		CC_mp='Northern Mariana Islands',
		CC_no='Norway',
		CC_om='Oman',
		CC_pk='Pakistan',
		CC_pw='Palau',
		CC_ps='Palestinian Territory, Occupied',
		CC_pa='Panama',
		CC_pg='Papua New Guinea',
		CC_py='Paraguay',
		CC_pe='Peru',
		CC_ph='Philippines',
		CC_pn='Pitcairn',
		CC_pl='Poland',
		CC_pt='Portugal',
		CC_pr='Puerto Rico',
		CC_qa='Qatar',
		CC_re='Réunion',
		CC_ro='Romania',
		CC_ru='Russian Federation',
		CC_rw='Rwanda',
		CC_bl='Saint Barthélemy',
		CC_sh='Saint Helena, Ascension and Tristan da Cunha',
		CC_kn='Saint Kitts and Nevis',
		CC_lc='Saint Lucia',
		CC_mf='Saint Martin (French Part)',
		CC_pm='Saint Pierre and Miquelon',
		CC_vc='Saint Vincent and The Grenadines',
		CC_ws='Samoa',
		CC_sm='San Marino',
		CC_st='Sao Tome and Principe',
		CC_sa='Saudi Arabia',
		CC_sn='Senegal',
		CC_rs='Serbia',
		CC_sc='Seychelles',
		CC_sl='Sierra Leone',
		CC_sg='Singapore',
		CC_sk='Slovakia',
		CC_sx='Sint Maarten (Dutch Part)',
		CC_si='Slovenia',
		CC_sb='Solomon Islands',
		CC_so='Somalia',
		CC_za='South Africa',
		CC_gs='South Georgia and The South Sandwich Islands',
		CC_ss='South Sudan',
		CC_es='Spain',
		CC_lk='Sri Lanka',
		CC_sd='Sudan',
		CC_sr='Suriname',
		CC_sj='Svalbard and Jan Mayen',
		CC_sz='Swaziland',
		CC_se='Sweden',
		CC_ch='Switzerland',
		CC_sy='Syrian Arab Republic',
		CC_tw='Taiwan, Province of China',
		CC_tj='Tajikistan',
		CC_tz='Tanzania, United Republic of',
		CC_th='Thailand',
		CC_tl='Timor-Leste',
		CC_tg='Togo',
		CC_tk='Tokelau',
		CC_to='Tonga',
		CC_tt='Trinidad and Tobago',
		CC_tn='Tunisia',
		CC_tr='Turkey',
		CC_tm='Turkmenistan',
		CC_tc='Turks and Caicos Islands',
		CC_tv='Tuvalu',
		CC_ug='Uganda',
		CC_ua='Ukraine',
		CC_ae='United Arab Emirates',
		CC_gb='United Kingdom',
		CC_us='United States',
		CC_um='United States Minor Outlying Islands',
		CC_uy='Uruguay',
		CC_uz='Uzbekistan',
		CC_vu='Vanuatu',
		CC_ve='Venezuela',
		CC_vn='Viet Nam',
		CC_vg='Virgin Islands, British',
		CC_vi='Virgin Islands, U.S.',
		CC_wf='Wallis and Futuna',
		CC_eh='Western Sahara',
		CC_ye='Yemen',
		CC_zm='Zambia',
		CC_zw='Zimbabwe';
	//@}

	//@{ ISO 639-1 language codes (Windows-compatibility subset)
	const
		LC_af='Afrikaans',
		LC_am='Amharic',
		LC_ar='Arabic',
		LC_as='Assamese',
		LC_ba='Bashkir',
		LC_be='Belarusian',
		LC_bg='Bulgarian',
		LC_bn='Bengali',
		LC_bo='Tibetan',
		LC_br='Breton',
		LC_ca='Catalan',
		LC_co='Corsican',
		LC_cs='Czech',
		LC_cy='Welsh',
		LC_da='Danish',
		LC_de='German',
		LC_dv='Divehi',
		LC_el='Greek',
		LC_en='English',
		LC_es='Spanish',
		LC_et='Estonian',
		LC_eu='Basque',
		LC_fa='Persian',
		LC_fi='Finnish',
		LC_fo='Faroese',
		LC_fr='French',
		LC_gd='Scottish Gaelic',
		LC_gl='Galician',
		LC_gu='Gujarati',
		LC_he='Hebrew',
		LC_hi='Hindi',
		LC_hr='Croatian',
		LC_hu='Hungarian',
		LC_hy='Armenian',
		LC_id='Indonesian',
		LC_ig='Igbo',
		LC_is='Icelandic',
		LC_it='Italian',
		LC_ja='Japanese',
		LC_ka='Georgian',
		LC_kk='Kazakh',
		LC_km='Khmer',
		LC_kn='Kannada',
		LC_ko='Korean',
		LC_lb='Luxembourgish',
		LC_lo='Lao',
		LC_lt='Lithuanian',
		LC_lv='Latvian',
		LC_mi='Maori',
		LC_ml='Malayalam',
		LC_mr='Marathi',
		LC_ms='Malay',
		LC_mt='Maltese',
		LC_ne='Nepali',
		LC_nl='Dutch',
		LC_no='Norwegian',
		LC_oc='Occitan',
		LC_or='Oriya',
		LC_pl='Polish',
		LC_ps='Pashto',
		LC_pt='Portuguese',
		LC_qu='Quechua',
		LC_ro='Romanian',
		LC_ru='Russian',
		LC_rw='Kinyarwanda',
		LC_sa='Sanskrit',
		LC_si='Sinhala',
		LC_sk='Slovak',
		LC_sl='Slovenian',
		LC_sq='Albanian',
		LC_sv='Swedish',
		LC_ta='Tamil',
		LC_te='Telugu',
		LC_th='Thai',
		LC_tk='Turkmen',
		LC_tr='Turkish',
		LC_tt='Tatar',
		LC_uk='Ukrainian',
		LC_ur='Urdu',
		LC_vi='Vietnamese',
		LC_wo='Wolof',
		LC_yo='Yoruba',
		LC_zh='Chinese';
	//@}

	/**
<<<<<<< HEAD
	*	Convert class constants to array
	*	@return array
	*	@param $prefix string
=======
		Convert class constants to array
		@return array
		@param $prefix string
>>>>>>> 3.0.4 release
	**/
	protected function constants($prefix) {
		$ref=new ReflectionClass($this);
		$out=array();
		foreach (preg_grep('/^'.$prefix.'/',array_keys($ref->getconstants()))
			as $val) {
			$out[$key=substr($val,strlen($prefix))]=
				constant('self::'.$prefix.$key);
		}
		unset($ref);
		return $out;
	}

	/**
<<<<<<< HEAD
	*	Return list of languages indexed by ISO 639-1 language code
	*	@return array
=======
		Return list of languages indexed by ISO 639-1 language code
		@return array
>>>>>>> 3.0.4 release
	**/
	function languages() {
		return $this->constants('LC_');
	}

	/**
<<<<<<< HEAD
	*	Return list of countries indexed by ISO 3166-1 country code
	*	@return array
=======
		Return list of countries indexed by ISO 3166-1 country code
		@return array
>>>>>>> 3.0.4 release
	**/
	function countries() {
		return $this->constants('CC_');
	}

}

//! Container for singular object instances
final class Registry {

	private static
		//! Object catalog
		$table;

	/**
<<<<<<< HEAD
	*	Return TRUE if object exists in catalog
	*	@return bool
	*	@param $key string
=======
		Return TRUE if object exists in catalog
		@return bool
		@param $key string
>>>>>>> 3.0.4 release
	**/
	static function exists($key) {
		return isset(self::$table[$key]);
	}

	/**
<<<<<<< HEAD
	*	Add object to catalog
	*	@return object
	*	@param $key string
	*	@param $obj object
=======
		Add object to catalog
		@return object
		@param $key string
		@param $obj object
>>>>>>> 3.0.4 release
	**/
	static function set($key,$obj) {
		return self::$table[$key]=$obj;
	}

	/**
<<<<<<< HEAD
	*	Retrieve object from catalog
	*	@return object
	*	@param $key string
=======
		Retrieve object from catalog
		@return object
		@param $key string
>>>>>>> 3.0.4 release
	**/
	static function get($key) {
		return self::$table[$key];
	}

	/**
<<<<<<< HEAD
	*	Delete object from catalog
	*	@return NULL
	*	@param $key string
	**/
	static function clear($key) {
		self::$table[$key]=NULL;
=======
		Remove object from catalog
		@return NULL
		@param $key string
	**/
	static function clear($key) {
>>>>>>> 3.0.4 release
		unset(self::$table[$key]);
	}

	//! Prohibit cloning
	private function __clone() {
	}

	//! Prohibit instantiation
	private function __construct() {
	}

}

<<<<<<< HEAD
=======
if (!function_exists('getallheaders')) {

	/**
		Fetch HTTP request headers
		@return array
	**/
	function getallheaders() {
		if (PHP_SAPI=='cli')
			return FALSE;
		$headers=array();
		foreach ($_SERVER as $key=>$val)
			if (substr($key,0,5)=='HTTP_')
				$headers[strtr(ucwords(strtolower(
					strtr(substr($key,5),'_',' '))),' ','-')]=$val;
		return $headers;
	}

}

>>>>>>> 3.0.4 release
return Base::instance();
