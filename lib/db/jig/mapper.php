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

namespace DB\Jig;

//! Flat-file DB mapper
class Mapper extends \DB\Cursor {

	protected
		//! Flat-file DB wrapper
		$db,
		//! Data file
		$file,
		//! Document identifier
		$id,
		//! Document contents
		$document=array();

	/**
<<<<<<< HEAD
	*	Return database type
	*	@return string
	**/
	function dbtype() {
		return 'Jig';
	}

	/**
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
		return array_key_exists($key,$this->document);
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
		return ($key=='_id')?FALSE:($this->document[$key]=$val);
	}

	/**
<<<<<<< HEAD
	*	Retrieve value of field
	*	@return scalar|FALSE
	*	@param $key string
	**/
	function &get($key) {
=======
		Retrieve value of field
		@return scalar|FALSE
		@param $key string
	**/
	function get($key) {
>>>>>>> 3.0.4 release
		if ($key=='_id')
			return $this->id;
		if (array_key_exists($key,$this->document))
			return $this->document[$key];
		user_error(sprintf(self::E_Field,$key));
<<<<<<< HEAD
	}

	/**
	*	Delete field
	*	@return NULL
	*	@param $key string
	**/
	function clear($key) {
		if ($key!='_id')
			unset($this->document[$key]);
	}

	/**
	*	Convert array to mapper object
	*	@return object
	*	@param $id string
	*	@param $row array
=======
		return FALSE;
	}

	/**
		Delete field
		@return NULL
		@param $key string
	**/
	function clear($key) {
		unset($this->document[$key]);
	}

	/**
		Convert array to mapper object
		@return object
		@param $id string
		@param $row array
>>>>>>> 3.0.4 release
	**/
	protected function factory($id,$row) {
		$mapper=clone($this);
		$mapper->reset();
<<<<<<< HEAD
		$mapper->id=$id;
		foreach ($row as $field=>$val)
			$mapper->document[$field]=$val;
		$mapper->query=array(clone($mapper));
		if (isset($mapper->trigger['load']))
			\Base::instance()->call($mapper->trigger['load'],$mapper);
=======
		foreach ($row as $field=>$val) {
			$mapper->id=$id;
			$mapper->document[$field]=$val;
		}
>>>>>>> 3.0.4 release
		return $mapper;
	}

	/**
<<<<<<< HEAD
	*	Return fields of mapper object as an associative array
	*	@return array
	*	@param $obj object
=======
		Return fields of mapper object as an associative array
		@return array
		@param $obj object
>>>>>>> 3.0.4 release
	**/
	function cast($obj=NULL) {
		if (!$obj)
			$obj=$this;
<<<<<<< HEAD
		return $obj->document+array('_id'=>$this->id);
	}

	/**
	*	Convert tokens in string expression to variable names
	*	@return string
	*	@param $str string
=======
		return $obj->document;
	}

	/**
		Convert tokens in string expression to variable names
		@return string
		@param $str string
>>>>>>> 3.0.4 release
	**/
	function token($str) {
		$self=$this;
		$str=preg_replace_callback(
			'/(?<!\w)@(\w(?:[\w\.\[\]])*)/',
<<<<<<< HEAD
			function($token) use($self) {
=======
			function($var) use($self) {
>>>>>>> 3.0.4 release
				// Convert from JS dot notation to PHP array notation
				return '$'.preg_replace_callback(
					'/(\.\w+)|\[((?:[^\[\]]*|(?R))*)\]/',
					function($expr) use($self) {
<<<<<<< HEAD
						$fw=\Base::instance();
						return
=======
						$fw=Base::instance();
						return 
>>>>>>> 3.0.4 release
							'['.
							($expr[1]?
								$fw->stringify(substr($expr[1],1)):
								(preg_match('/^\w+/',
									$mix=$self->token($expr[2]))?
									$fw->stringify($mix):
									$mix)).
							']';
					},
<<<<<<< HEAD
					$token[1]
=======
					$var[1]
>>>>>>> 3.0.4 release
				);
			},
			$str
		);
		return trim($str);
	}

	/**
<<<<<<< HEAD
	*	Return records that match criteria
	*	@return array|FALSE
	*	@param $filter array
	*	@param $options array
	*	@param $ttl int
	*	@param $log bool
	**/
	function find($filter=NULL,array $options=NULL,$ttl=0,$log=TRUE) {
=======
		Return records that match criteria
		@return array|FALSE
		@param $filter array
		@param $options array
		@param $log bool
	**/
	function find($filter=NULL,array $options=NULL,$log=TRUE) {
>>>>>>> 3.0.4 release
		if (!$options)
			$options=array();
		$options+=array(
			'order'=>NULL,
			'limit'=>0,
			'offset'=>0
		);
		$fw=\Base::instance();
<<<<<<< HEAD
		$cache=\Cache::instance();
		$db=$this->db;
		$now=microtime(TRUE);
		$data=array();
		if (!$fw->get('CACHE') || !$ttl || !($cached=$cache->exists(
			$hash=$fw->hash($this->db->dir().
				$fw->stringify(array($filter,$options))).'.jig',$data)) ||
			$cached[0]+$ttl<microtime(TRUE)) {
			$data=$db->read($this->file);
			if (is_null($data))
				return FALSE;
			foreach ($data as $id=>&$doc) {
				$doc['_id']=$id;
				unset($doc);
			}
			if ($filter) {
				if (!is_array($filter))
					return FALSE;
				// Normalize equality operator
				$expr=preg_replace('/(?<=[^<>!=])=(?!=)/','==',$filter[0]);
				// Prepare query arguments
				$args=isset($filter[1]) && is_array($filter[1])?
					$filter[1]:
					array_slice($filter,1,NULL,TRUE);
				$args=is_array($args)?$args:array(1=>$args);
				$keys=$vals=array();
				$tokens=array_slice(
					token_get_all('<?php '.$this->token($expr)),1);
				$data=array_filter($data,
					function($_row) use($fw,$args,$tokens) {
						$_expr='';
						$ctr=0;
						$named=FALSE;
						foreach ($tokens as $token) {
							if (is_string($token))
								if ($token=='?') {
									// Positional
									$ctr++;
									$key=$ctr;
								}
								else {
									if ($token==':')
										$named=TRUE;
									else
										$_expr.=$token;
									continue;
								}
							elseif ($named &&
								token_name($token[0])=='T_STRING') {
								$key=':'.$token[1];
								$named=FALSE;
							}
							else {
								$_expr.=$token[1];
								continue;
							}
							$_expr.=$fw->stringify(
								is_string($args[$key])?
									addcslashes($args[$key],'\''):
									$args[$key]);
						}
						// Avoid conflict with user code
						unset($fw,$tokens,$args,$ctr,$token,$key,$named);
						extract($_row);
						// Evaluate pseudo-SQL expression
						return eval('return '.$_expr.';');
					}
				);
			}
			if (isset($options['order'])) {
				$cols=$fw->split($options['order']);
				uasort(
					$data,
					function($val1,$val2) use($cols) {
						foreach ($cols as $col) {
							$parts=explode(' ',$col,2);
							$order=empty($parts[1])?
								SORT_ASC:
								constant($parts[1]);
							$col=$parts[0];
							if (!array_key_exists($col,$val1))
								$val1[$col]=NULL;
							if (!array_key_exists($col,$val2))
								$val2[$col]=NULL;
							list($v1,$v2)=array($val1[$col],$val2[$col]);
							if ($out=strnatcmp($v1,$v2)*
								(($order==SORT_ASC)*2-1))
								return $out;
						}
						return 0;
					}
				);
			}
			$data=array_slice($data,
				$options['offset'],$options['limit']?:NULL,TRUE);
			if ($fw->get('CACHE') && $ttl)
				// Save to cache backend
				$cache->set($hash,$data,$ttl);
		}
		$out=array();
		foreach ($data as $id=>&$doc) {
			unset($doc['_id']);
			$out[]=$this->factory($id,$doc);
			unset($doc);
		}
		if ($log && isset($args)) {
			if ($filter)
				foreach ($args as $key=>$val) {
=======
		$db=$this->db;
		$now=microtime(TRUE);
		$data=$db->read($this->file);
		if ($filter) {
			if (!is_array($filter))
				return FALSE;
			// Prefix local variables to avoid conflict with user code
			$_self=$this;
			$_args=isset($filter[1]) && is_array($filter[1])?
				$filter[1]:
				array_slice($filter,1,NULL,TRUE);
			$_args=is_array($_args)?$_args:array(1=>$_args);
			$keys=$vals=array();
			list($_expr)=$filter;
			$data=array_filter($data,
				function($_row) use($_expr,$_args,$_self) {
					extract($_row);
					$_ctr=0;
					// Evaluate pseudo-SQL expression
					return eval('return '.
						preg_replace_callback(
							'/(\:\w+)|(\?)/',
							function($token) use($_args,&$_ctr) {
								// Parameterized query
								if ($token[1])
									// Named
									$key=$token[1];
								else {
									// Positional
									$_ctr++;
									$key=$_ctr;
								}
								// Add slashes to prevent code injection
								return \Base::instance()->stringify(
									is_string($_args[$key])?
										addcslashes($_args[$key],'\''):
										$_args[$key]);
							},
							$_self->token($_expr)
						).';'
					);
				}
			);
		}
		if (isset($options['order']))
			foreach (array_reverse($fw->split($options['order'])) as $col) {
				$parts=explode(' ',$col,2);
				$order=empty($parts[1])?SORT_ASC:constant($parts[1]);
				uasort(
					$data,
					function($val1,$val2) use($col,$order) {
						list($v1,$v2)=array($val1[$col],$val2[$col]);
						$out=is_numeric($v1) && is_numeric($v2)?
							Base::instance()->sign($v1-$v2):strcmp($v1,$v2);
						if ($order==SORT_DESC)
							$out=-$out;
						return $out;
					}
				);
			}
		$out=array();
		foreach (array_slice($data,
			$options['offset'],$options['limit']?:NULL,TRUE) as $id=>$doc)
			$out[]=$this->factory($id,$doc);
		if ($log) {
			if ($filter)
				foreach ($_args as $key=>$val) {
>>>>>>> 3.0.4 release
					$vals[]=$fw->stringify(is_array($val)?$val[0]:$val);
					$keys[]='/'.(is_numeric($key)?'\?':preg_quote($key)).'/';
				}
			$db->jot('('.sprintf('%.1f',1e3*(microtime(TRUE)-$now)).'ms) '.
				$this->file.' [find] '.
				($filter?preg_replace($keys,$vals,$filter[0],1):''));
		}
		return $out;
	}

	/**
<<<<<<< HEAD
	*	Count records that match criteria
	*	@return int
	*	@param $filter array
	*	@param $ttl int
	**/
	function count($filter=NULL,$ttl=0) {
		$now=microtime(TRUE);
		$out=count($this->find($filter,NULL,$ttl,FALSE));
=======
		Count records that match criteria
		@return int
		@param $filter array
	**/
	function count($filter=NULL) {
		$now=microtime(TRUE);
		$out=count($this->find($filter,NULL,FALSE));
>>>>>>> 3.0.4 release
		$this->db->jot('('.sprintf('%.1f',1e3*(microtime(TRUE)-$now)).'ms) '.
			$this->file.' [count] '.($filter?json_encode($filter):''));
		return $out;
	}

	/**
<<<<<<< HEAD
	*	Return record at specified offset using criteria of previous
	*	load() call and make it active
	*	@return array
	*	@param $ofs int
=======
		Return record at specified offset using criteria of previous
		load() call and make it active
		@return array
		@param $ofs int
>>>>>>> 3.0.4 release
	**/
	function skip($ofs=1) {
		$this->document=($out=parent::skip($ofs))?$out->document:array();
		$this->id=$out?$out->id:NULL;
<<<<<<< HEAD
		if ($this->document && isset($this->trigger['load']))
			\Base::instance()->call($this->trigger['load'],$this);
=======
>>>>>>> 3.0.4 release
		return $out;
	}

	/**
<<<<<<< HEAD
	*	Insert new record
	*	@return array
	**/
	function insert() {
		if ($this->id)
			return $this->update();
		$db=$this->db;
		$now=microtime(TRUE);
		while (($id=uniqid(NULL,TRUE)) &&
=======
		Insert new record
		@return array
	**/
	function insert() {
		$db=$this->db;
		$now=microtime(TRUE);
		while (($id=uniqid()) &&
>>>>>>> 3.0.4 release
			($data=$db->read($this->file)) && isset($data[$id]) &&
			!connection_aborted())
			usleep(mt_rand(0,100));
		$this->id=$id;
		$data[$id]=$this->document;
<<<<<<< HEAD
		$pkey=array('_id'=>$this->id);
		if (isset($this->trigger['beforeinsert']))
			\Base::instance()->call($this->trigger['beforeinsert'],
				array($this,$pkey));
		$db->write($this->file,$data);
		$db->jot('('.sprintf('%.1f',1e3*(microtime(TRUE)-$now)).'ms) '.
			$this->file.' [insert] '.json_encode($this->document));
		if (isset($this->trigger['afterinsert']))
			\Base::instance()->call($this->trigger['afterinsert'],
				array($this,$pkey));
		$this->load(array('@_id=?',$this->id));
=======
		$db->write($this->file,$data);
		parent::reset();
		$db->jot('('.sprintf('%.1f',1e3*(microtime(TRUE)-$now)).'ms) '.
			$this->file.' [insert] '.
			json_encode(array('_id'=>$this->id)+$this->document));
>>>>>>> 3.0.4 release
		return $this->document;
	}

	/**
<<<<<<< HEAD
	*	Update current record
	*	@return array
=======
		Update current record
		@return array
>>>>>>> 3.0.4 release
	**/
	function update() {
		$db=$this->db;
		$now=microtime(TRUE);
		$data=$db->read($this->file);
		$data[$this->id]=$this->document;
<<<<<<< HEAD
		if (isset($this->trigger['beforeupdate']))
			\Base::instance()->call($this->trigger['beforeupdate'],
				array($this,array('_id'=>$this->id)));
		$db->write($this->file,$data);
		$db->jot('('.sprintf('%.1f',1e3*(microtime(TRUE)-$now)).'ms) '.
			$this->file.' [update] '.json_encode($this->document));
		if (isset($this->trigger['afterupdate']))
			\Base::instance()->call($this->trigger['afterupdate'],
				array($this,array('_id'=>$this->id)));
=======
		$db->write($this->file,$data);
		$db->jot('('.sprintf('%.1f',1e3*(microtime(TRUE)-$now)).'ms) '.
			$this->file.' [update] '.
			json_encode(array('_id'=>$this->id)+$this->document));
>>>>>>> 3.0.4 release
		return $this->document;
	}

	/**
<<<<<<< HEAD
	*	Delete current record
	*	@return bool
	*	@param $filter array
=======
		Delete current record
		@return bool
		@param $filter array
>>>>>>> 3.0.4 release
	**/
	function erase($filter=NULL) {
		$db=$this->db;
		$now=microtime(TRUE);
		$data=$db->read($this->file);
<<<<<<< HEAD
		$pkey=array('_id'=>$this->id);
		if ($filter) {
			foreach ($this->find($filter,NULL,FALSE) as $mapper)
				if (!$mapper->erase())
					return FALSE;
			return TRUE;
=======
		if ($filter) {
			$data=$this->find($filter,NULL,FALSE);
			foreach (array_keys(array_reverse($data)) as $id)
				unset($data[$id]);
>>>>>>> 3.0.4 release
		}
		elseif (isset($this->id)) {
			unset($data[$this->id]);
			parent::erase();
			$this->skip(0);
		}
		else
			return FALSE;
<<<<<<< HEAD
		if (isset($this->trigger['beforeerase']))
			\Base::instance()->call($this->trigger['beforeerase'],
				array($this,$pkey));
		$db->write($this->file,$data);
		if ($filter) {
			$args=isset($filter[1]) && is_array($filter[1])?
				$filter[1]:
				array_slice($filter,1,NULL,TRUE);
			$args=is_array($args)?$args:array(1=>$args);
			foreach ($args as $key=>$val) {
=======
		$db->write($this->file,$data);
		if ($filter) {
			$_args=isset($filter[1]) && is_array($filter[1])?
				$filter[1]:
				array_slice($filter,1,NULL,TRUE);
			$_args=is_array($_args)?$_args:array(1=>$_args);
			foreach ($_args as $key=>$val) {
>>>>>>> 3.0.4 release
				$vals[]=\Base::instance()->
					stringify(is_array($val)?$val[0]:$val);
				$keys[]='/'.(is_numeric($key)?'\?':preg_quote($key)).'/';
			}
		}
		$db->jot('('.sprintf('%.1f',1e3*(microtime(TRUE)-$now)).'ms) '.
			$this->file.' [erase] '.
			($filter?preg_replace($keys,$vals,$filter[0],1):''));
<<<<<<< HEAD
		if (isset($this->trigger['aftererase']))
			\Base::instance()->call($this->trigger['aftererase'],
				array($this,$pkey));
=======
>>>>>>> 3.0.4 release
		return TRUE;
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
		$this->document=array();
		parent::reset();
	}

	/**
<<<<<<< HEAD
	*	Hydrate mapper object using hive array variable
	*	@return NULL
	*	@param $key string
	*	@param $func callback
	**/
	function copyfrom($key,$func=NULL) {
		$var=\Base::instance()->get($key);
		if ($func)
			$var=call_user_func($func,$var);
		foreach ($var as $key=>$val)
=======
		Hydrate mapper object using hive array variable
		@return NULL
		@param $key string
	**/
	function copyfrom($key) {
		foreach (\Base::instance()->get($key) as $key=>$val)
>>>>>>> 3.0.4 release
			$this->document[$key]=$val;
	}

	/**
<<<<<<< HEAD
	*	Populate hive array variable with mapper fields
	*	@return NULL
	*	@param $key string
=======
		Populate hive array variable with mapper fields
		@return NULL
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function copyto($key) {
		$var=&\Base::instance()->ref($key);
		foreach ($this->document as $key=>$field)
			$var[$key]=$field;
	}

	/**
<<<<<<< HEAD
	*	Return field names
	*	@return array
	**/
	function fields() {
		return array_keys($this->document);
	}

	/**
	*	Instantiate class
	*	@return void
	*	@param $db object
	*	@param $file string
=======
		Instantiate class
		@return void
		@param $db object
		@param $file string
>>>>>>> 3.0.4 release
	**/
	function __construct(\DB\Jig $db,$file) {
		$this->db=$db;
		$this->file=$file;
		$this->reset();
	}

}
