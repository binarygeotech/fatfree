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

//! SQL data mapper
class Mapper extends \DB\Cursor {

	//@{ Error messages
	const
		E_Adhoc='Unable to process ad hoc field %s';
	//@}

	protected
		//! PDO wrapper
		$db,
		//! Database engine
		$engine,
		//! SQL table
<<<<<<< HEAD
		$source,
		//! SQL table (quoted)
=======
>>>>>>> 3.0.4 release
		$table,
		//! Last insert ID
		$_id,
		//! Defined fields
		$fields,
		//! Adhoc fields
		$adhoc=array();

	/**
<<<<<<< HEAD
	*	Return database type
	*	@return string
	**/
	function dbtype() {
		return 'SQL';
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
		return array_key_exists($key,$this->fields+$this->adhoc);
	}

	/**
<<<<<<< HEAD
	*	Assign value to field
	*	@return scalar
	*	@param $key string
	*	@param $val scalar
	**/
	function set($key,$val) {
		if (array_key_exists($key,$this->fields)) {
			$val=is_null($val) && $this->fields[$key]['nullable']?
				NULL:$this->db->value($this->fields[$key]['pdo_type'],$val);
			if ($this->fields[$key]['value']!==$val ||
				$this->fields[$key]['default']!==$val && is_null($val))
=======
		Assign value to field
		@return scalar
		@param $key string
		@param $val scalar
	**/
	function set($key,$val) {
		if (array_key_exists($key,$this->fields)) {
			if (!is_null($val) || !$this->fields[$key]['nullable'])
				$val=$this->value($this->fields[$key]['pdo_type'],$val);
			if ($this->fields[$key]['value']!==$val ||
				$this->fields[$key]['default']!==$val)
>>>>>>> 3.0.4 release
				$this->fields[$key]['changed']=TRUE;
			return $this->fields[$key]['value']=$val;
		}
		// Parenthesize expression in case it's a subquery
		$this->adhoc[$key]=array('expr'=>'('.$val.')','value'=>NULL);
		return $val;
	}

	/**
<<<<<<< HEAD
	*	Retrieve value of field
	*	@return scalar
	*	@param $key string
	**/
	function &get($key) {
=======
		Retrieve value of field
		@return scalar
		@param $key string
	**/
	function get($key) {
>>>>>>> 3.0.4 release
		if ($key=='_id')
			return $this->_id;
		elseif (array_key_exists($key,$this->fields))
			return $this->fields[$key]['value'];
		elseif (array_key_exists($key,$this->adhoc))
			return $this->adhoc[$key]['value'];
		user_error(sprintf(self::E_Field,$key));
	}

	/**
<<<<<<< HEAD
	*	Clear value of field
	*	@return NULL
	*	@param $key string
=======
		Clear value of field
		@return NULL
		@param $key string
>>>>>>> 3.0.4 release
	**/
	function clear($key) {
		if (array_key_exists($key,$this->adhoc))
			unset($this->adhoc[$key]);
	}

	/**
<<<<<<< HEAD
	*	Get PHP type equivalent of PDO constant
	*	@return string
	*	@param $pdo string
=======
		Get PHP type equivalent of PDO constant
		@return string
		@param $pdo string
>>>>>>> 3.0.4 release
	**/
	function type($pdo) {
		switch ($pdo) {
			case \PDO::PARAM_NULL:
				return 'unset';
			case \PDO::PARAM_INT:
				return 'int';
			case \PDO::PARAM_BOOL:
				return 'bool';
			case \PDO::PARAM_STR:
				return 'string';
		}
	}

	/**
<<<<<<< HEAD
	*	Convert array to mapper object
	*	@return object
	*	@param $row array
=======
		Cast value to PHP type
		@return scalar
		@param $type string
		@param $val scalar
	**/
	function value($type,$val) {
		switch ($type) {
			case \PDO::PARAM_NULL:
				return (unset)$val;
			case \PDO::PARAM_INT:
				return (int)$val;
			case \PDO::PARAM_BOOL:
				return (bool)$val;
			case \PDO::PARAM_STR:
				return (string)$val;
		}
	}

	/**
		Convert array to mapper object
		@return object
		@param $row array
>>>>>>> 3.0.4 release
	**/
	protected function factory($row) {
		$mapper=clone($this);
		$mapper->reset();
<<<<<<< HEAD
		foreach ($row as $key=>$val) {
			if (array_key_exists($key,$this->fields))
				$var='fields';
			elseif (array_key_exists($key,$this->adhoc))
				$var='adhoc';
			else
				continue;
			$mapper->{$var}[$key]['value']=$val;
			if ($var=='fields' && $mapper->{$var}[$key]['pkey'])
				$mapper->{$var}[$key]['previous']=$val;
		}
		$mapper->query=array(clone($mapper));
		if (isset($mapper->trigger['load']))
			\Base::instance()->call($mapper->trigger['load'],$mapper);
=======
		foreach ($row as $key=>$val)
			$mapper->{array_key_exists($key,$this->fields)?'fields':'adhoc'}
				[$key]['value']=$val;
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
		return array_map(
			function($row) {
<<<<<<< HEAD
				return $row['value'];
=======
				return $row['value' ];
>>>>>>> 3.0.4 release
			},
			$obj->fields+$obj->adhoc
		);
	}

	/**
<<<<<<< HEAD
	*	Build query string and execute
	*	@return array
	*	@param $fields string
	*	@param $filter string|array
	*	@param $options array
	*	@param $ttl int
	**/
	function select($fields,$filter=NULL,array $options=NULL,$ttl=0) {
=======
		Build query string and execute
		@return array
		@param $fields string
		@param $filter string|array
		@param $options array
	**/
	function select($fields,$filter=NULL,array $options=NULL) {
>>>>>>> 3.0.4 release
		if (!$options)
			$options=array();
		$options+=array(
			'group'=>NULL,
			'order'=>NULL,
			'limit'=>0,
			'offset'=>0
		);
		$sql='SELECT '.$fields.' FROM '.$this->table;
		$args=array();
		if ($filter) {
			if (is_array($filter)) {
				$args=isset($filter[1]) && is_array($filter[1])?
					$filter[1]:
					array_slice($filter,1,NULL,TRUE);
				$args=is_array($args)?$args:array(1=>$args);
				list($filter)=$filter;
			}
			$sql.=' WHERE '.$filter;
		}
<<<<<<< HEAD
		$db=$this->db;
		if ($options['group'])
			$sql.=' GROUP BY '.implode(',',array_map(
				function($str) use($db) {
					return preg_match('/^(\w+)(?:\h+HAVING|\h*(?:,|$))/i',
						$str,$parts)?
						($db->quotekey($parts[1]).
						(isset($parts[2])?(' '.$parts[2]):'')):$str;
				},
				explode(',',$options['group'])));
		if ($options['order']) {
			$sql.=' ORDER BY '.implode(',',array_map(
				function($str) use($db) {
					return preg_match('/^(\w+)(?:\h+(ASC|DESC))?\h*(?:,|$)/i',
						$str,$parts)?
						($db->quotekey($parts[1]).
						(isset($parts[2])?(' '.$parts[2]):'')):$str;
				},
				explode(',',$options['order'])));
		}
		if (preg_match('/mssql|sqlsrv|odbc/', $this->engine) &&
			($options['limit'] || $options['offset'])) {
			$pkeys = array();
			foreach ($this->fields as $key => $field)
				if ($field['pkey'])
					$pkeys[] = $key;
			$ofs=$options['offset']?(int)$options['offset']:0;
			$lmt=$options['limit']?(int)$options['limit']:0;
			if (strncmp($db->version(),'11',2)>=0) {
				// SQL Server 2012
				if (!$options['order'])
					$sql.=' ORDER BY '.$db->quotekey($pkeys[0]);
				$sql.=' OFFSET '.$ofs.' ROWS';
				if ($lmt)
					$sql.=' FETCH NEXT '.$lmt.' ROWS ONLY';
			} else {
				// SQL Server 2008
				$sql=str_replace('SELECT',
					'SELECT '.
					($lmt>0?'TOP '.($ofs+$lmt):'').' ROW_NUMBER() '.
					'OVER (ORDER BY '.
						$db->quotekey($pkeys[0]).') AS rnum,',$sql);
				$sql='SELECT * FROM ('.$sql.') x WHERE rnum > '.($ofs);
			}
		} else {
			if ($options['limit'])
				$sql.=' LIMIT '.(int)$options['limit'];
			if ($options['offset'])
				$sql.=' OFFSET '.(int)$options['offset'];
		}
		$result=$this->db->exec($sql,$args,$ttl);
=======
		if ($options['group'])
			$sql.=' GROUP BY '.$options['group'];
		if ($options['order'])
			$sql.=' ORDER BY '.$options['order'];
		if ($options['limit'])
			$sql.=' LIMIT '.$options['limit'];
		if ($options['offset'])
			$sql.=' OFFSET '.$options['offset'];
		$result=$this->db->exec($sql.';',$args);
>>>>>>> 3.0.4 release
		$out=array();
		foreach ($result as &$row) {
			foreach ($row as $field=>&$val) {
				if (array_key_exists($field,$this->fields)) {
					if (!is_null($val) || !$this->fields[$field]['nullable'])
<<<<<<< HEAD
						$val=$this->db->value(
=======
						$val=$this->value(
>>>>>>> 3.0.4 release
							$this->fields[$field]['pdo_type'],$val);
				}
				elseif (array_key_exists($field,$this->adhoc))
					$this->adhoc[$field]['value']=$val;
				unset($val);
			}
			$out[]=$this->factory($row);
			unset($row);
		}
		return $out;
	}

	/**
<<<<<<< HEAD
	*	Return records that match criteria
	*	@return array
	*	@param $filter string|array
	*	@param $options array
	*	@param $ttl int
	**/
	function find($filter=NULL,array $options=NULL,$ttl=0) {
=======
		Return records that match criteria
		@return array
		@param $filter string|array
		@param $options array
	**/
	function find($filter=NULL,array $options=NULL) {
>>>>>>> 3.0.4 release
		if (!$options)
			$options=array();
		$options+=array(
			'group'=>NULL,
			'order'=>NULL,
			'limit'=>0,
			'offset'=>0
		);
		$adhoc='';
		foreach ($this->adhoc as $key=>$field)
<<<<<<< HEAD
			$adhoc.=','.$field['expr'].' AS '.$this->db->quotekey($key);
		return $this->select(($options['group']?:implode(',',
			array_map(array($this->db,'quotekey'),array_keys($this->fields)))).
			$adhoc,$filter,$options,$ttl);
	}

	/**
	*	Count records that match criteria
	*	@return int
	*	@param $filter string|array
	*	@param $ttl int
	**/
	function count($filter=NULL,$ttl=0) {
		$sql='SELECT COUNT(*) AS '.
			$this->db->quotekey('rows').' FROM '.$this->table;
		$args=array();
		if ($filter) {
			if (is_array($filter)) {
				$args=isset($filter[1]) && is_array($filter[1])?
					$filter[1]:
					array_slice($filter,1,NULL,TRUE);
				$args=is_array($args)?$args:array(1=>$args);
				list($filter)=$filter;
			}
			$sql.=' WHERE '.$filter;
		}
		$result=$this->db->exec($sql,$args,$ttl);
		return $result[0]['rows'];
	}

	/**
	*	Return record at specified offset using same criteria as
	*	previous load() call and make it active
	*	@return array
	*	@param $ofs int
	**/
	function skip($ofs=1) {
		$out=parent::skip($ofs);
		$dry=$this->dry();
		foreach ($this->fields as $key=>&$field) {
			$field['value']=$dry?NULL:$out->fields[$key]['value'];
			$field['changed']=FALSE;
			if ($field['pkey'])
				$field['previous']=$dry?NULL:$out->fields[$key]['value'];
			unset($field);
		}
		foreach ($this->adhoc as $key=>&$field) {
			$field['value']=$dry?NULL:$out->adhoc[$key]['value'];
			unset($field);
		}
		if (isset($this->trigger['load']))
			\Base::instance()->call($this->trigger['load'],$this);
=======
			$adhoc.=','.$field['expr'].' AS '.$key;
		return $this->select('*'.$adhoc,$filter,$options);
	}

	/**
		Count records that match criteria
		@return int
		@param $filter string|array
	**/
	function count($filter=NULL) {
		list($result)=$this->select('COUNT(*) AS rows',$filter);
		$out=$result->adhoc['rows']['value'];
		unset($this->adhoc['rows']);
		return $out;
	}

	/**
		Return record at specified offset using same criteria as
		previous load() call and make it active
		@return array
		@param $ofs int
	**/
	function skip($ofs=1) {
		if ($out=parent::skip($ofs)) {
			foreach ($this->fields as $key=>&$field) {
				$field['value']=$out->fields[$key]['value'];
				$field['changed']=FALSE;
				if ($field['pkey'])
					$field['previous']=$out->fields[$key]['value'];
				unset($field);
			}
			foreach ($this->adhoc as $key=>&$field) {
				$field['value']=$out->adhoc[$key]['value'];
				unset($field);
			}
		}
>>>>>>> 3.0.4 release
		return $out;
	}

	/**
<<<<<<< HEAD
	*	Insert new record
	*	@return object
=======
		Insert new record
		@return array
>>>>>>> 3.0.4 release
	**/
	function insert() {
		$args=array();
		$ctr=0;
		$fields='';
		$values='';
<<<<<<< HEAD
		$filter='';
		$pkeys=array();
		$nkeys=array();
		$ckeys=array();
		$inc=NULL;
		foreach ($this->fields as $key=>$field)
			if ($field['pkey'])
				$pkeys[$key]=$field['previous'];
		if (isset($this->trigger['beforeinsert']))
			\Base::instance()->call($this->trigger['beforeinsert'],
				array($this,$pkeys));
		foreach ($this->fields as $key=>&$field) {
			if ($field['pkey']) {
				$field['previous']=$field['value'];
				if (!$inc && $field['pdo_type']==\PDO::PARAM_INT &&
					empty($field['value']) && !$field['nullable'])
					$inc=$key;
				$filter.=($filter?' AND ':'').$this->db->quotekey($key).'=?';
				$nkeys[$ctr+1]=array($field['value'],$field['pdo_type']);
			}
			if ($field['changed'] && $key!=$inc) {
				$fields.=($ctr?',':'').$this->db->quotekey($key);
				$values.=($ctr?',':'').'?';
				$args[$ctr+1]=array($field['value'],$field['pdo_type']);
				$ctr++;
				$ckeys[]=$key;
			}
			$field['changed']=FALSE;
			unset($field);
		}
		if ($fields) {
			$this->db->exec(
				(preg_match('/mssql|dblib|sqlsrv/',$this->engine) &&
				array_intersect(array_keys($pkeys),$ckeys)?
					'SET IDENTITY_INSERT '.$this->table.' ON;':'').
				'INSERT INTO '.$this->table.' ('.$fields.') '.
				'VALUES ('.$values.')',$args
			);
			$seq=NULL;
			if ($this->engine=='pgsql') {
				$names=array_keys($pkeys);
				$seq=$this->source.'_'.end($names).'_seq';
			}
			if ($this->engine!='oci')
				$this->_id=$this->db->lastinsertid($seq);
			// Reload to obtain default and auto-increment field values
			$this->load($inc?
				array($inc.'=?',$this->db->value(
					$this->fields[$inc]['pdo_type'],$this->_id)):
				array($filter,$nkeys));
			if (isset($this->trigger['afterinsert']))
				\Base::instance()->call($this->trigger['afterinsert'],
					array($this,$pkeys));
		}
		return $this;
	}

	/**
	*	Update current record
	*	@return object
=======
		foreach ($this->fields as $key=>$field)
			if ($field['changed']) {
				$fields.=($ctr?',':'').
					($this->engine=='mysql'?('`'.$key.'`'):$key);
				$values.=($ctr?',':'').'?';
				$args[$ctr+1]=array($field['value'],$field['pdo_type']);
				$ctr++;
			}
		if ($fields)
			$this->db->exec(
				'INSERT INTO '.$this->table.' ('.$fields.') '.
				'VALUES ('.$values.');',$args
			);
		$pkeys=array();
		$out=array();
		$inc=array();
		foreach ($this->fields as $key=>$field) {
			$out+=array($key=>$field['value']);
			if ($field['pkey']) {
				$pkeys[]=$key;
				$field['previous']=$field['value'];
				if ($field['pdo_type']==\PDO::PARAM_INT &&
					is_null($field['value']) && !$field['nullable'])
					$inc[]=$key;
			}
		}
		$seq=NULL;
		if ($this->engine=='pgsql')
			$seq=$this->table.'_'.end($pkeys).'_seq';
		$this->_id=$this->db->lastinsertid($seq);
		$ctr=count($inc);
		if ($ctr!=1)
			return $out;
		// Reload to obtain default and auto-increment field values
		return $this->load(array($inc[0].'=?',
			$this->value($this->fields[$inc[0]]['pdo_type'],$this->_id)));
	}

	/**
		Update current record
		@return array
>>>>>>> 3.0.4 release
	**/
	function update() {
		$args=array();
		$ctr=0;
		$pairs='';
		$filter='';
<<<<<<< HEAD
		$pkeys=array();
		foreach ($this->fields as $key=>$field)
			if ($field['pkey'])
				$pkeys[$key]=$field['previous'];
		if (isset($this->trigger['beforeupdate']))
			\Base::instance()->call($this->trigger['beforeupdate'],
				array($this,$pkeys));
		foreach ($this->fields as $key=>$field)
			if ($field['changed']) {
				$pairs.=($pairs?',':'').$this->db->quotekey($key).'=?';
=======
		foreach ($this->fields as $key=>$field)
			if ($field['changed']) {
				$pairs.=($pairs?',':'').
					($this->engine=='mysql'?('`'.$key.'`'):$key).'=?';
>>>>>>> 3.0.4 release
				$args[$ctr+1]=array($field['value'],$field['pdo_type']);
				$ctr++;
			}
		foreach ($this->fields as $key=>$field)
			if ($field['pkey']) {
<<<<<<< HEAD
				$filter.=($filter?' AND ':'').$this->db->quotekey($key).'=?';
=======
				$filter.=($filter?' AND ':'').$key.'=?';
>>>>>>> 3.0.4 release
				$args[$ctr+1]=array($field['previous'],$field['pdo_type']);
				$ctr++;
			}
		if ($pairs) {
			$sql='UPDATE '.$this->table.' SET '.$pairs;
			if ($filter)
				$sql.=' WHERE '.$filter;
<<<<<<< HEAD
			$this->db->exec($sql,$args);
			if (isset($this->trigger['afterupdate']))
				\Base::instance()->call($this->trigger['afterupdate'],
					array($this,$pkeys));
		}
		return $this;
	}

	/**
	*	Delete current record
	*	@return int
	*	@param $filter string|array
=======
			return $this->db->exec($sql.';',$args);
		}
	}

	/**
		Delete current record
		@return int
		@param $filter string|array
>>>>>>> 3.0.4 release
	**/
	function erase($filter=NULL) {
		if ($filter) {
			$args=array();
			if (is_array($filter)) {
				$args=isset($filter[1]) && is_array($filter[1])?
					$filter[1]:
					array_slice($filter,1,NULL,TRUE);
				$args=is_array($args)?$args:array(1=>$args);
				list($filter)=$filter;
			}
			return $this->db->
				exec('DELETE FROM '.$this->table.' WHERE '.$filter.';',$args);
		}
		$args=array();
		$ctr=0;
		$filter='';
<<<<<<< HEAD
		$pkeys=array();
		foreach ($this->fields as $key=>&$field) {
			if ($field['pkey']) {
				$filter.=($filter?' AND ':'').$this->db->quotekey($key).'=?';
				$args[$ctr+1]=array($field['previous'],$field['pdo_type']);
				$pkeys[$key]=$field['previous'];
=======
		foreach ($this->fields as $key=>&$field) {
			if ($field['pkey']) {
				$filter.=($filter?' AND ':'').$key.'=?';
				$args[$ctr+1]=array($field['previous'],$field['pdo_type']);
>>>>>>> 3.0.4 release
				$ctr++;
			}
			$field['value']=NULL;
			$field['changed']=(bool)$field['default'];
			if ($field['pkey'])
				$field['previous']=NULL;
			unset($field);
		}
		foreach ($this->adhoc as &$field) {
			$field['value']=NULL;
			unset($field);
		}
		parent::erase();
		$this->skip(0);
<<<<<<< HEAD
		if (isset($this->trigger['beforeerase']))
			\Base::instance()->call($this->trigger['beforeerase'],
				array($this,$pkeys));
		$out=$this->db->
			exec('DELETE FROM '.$this->table.' WHERE '.$filter.';',$args);
		if (isset($this->trigger['aftererase']))
			\Base::instance()->call($this->trigger['aftererase'],
				array($this,$pkeys));
		return $out;
	}

	/**
	*	Reset cursor
	*	@return NULL
=======
		return $this->db->
			exec('DELETE FROM '.$this->table.' WHERE '.$filter.';',$args);
	}

	/**
		Reset cursor
		@return NULL
>>>>>>> 3.0.4 release
	**/
	function reset() {
		foreach ($this->fields as &$field) {
			$field['value']=NULL;
			$field['changed']=FALSE;
			if ($field['pkey'])
				$field['previous']=NULL;
			unset($field);
		}
		foreach ($this->adhoc as &$field) {
			$field['value']=NULL;
			unset($field);
		}
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
			if (in_array($key,array_keys($this->fields))) {
				$field=&$this->fields[$key];
				if ($field['value']!==$val) {
					$field['value']=$val;
					$field['changed']=TRUE;
				}
				unset($field);
			}
	}

	/**
<<<<<<< HEAD
	*	Populate hive array variable with mapper fields
	*	@return NULL
	*	@param $key string
	**/
	function copyto($key) {
		$var=&\Base::instance()->ref($key);
		foreach ($this->fields+$this->adhoc as $key=>$field)
=======
		Populate hive array variable with mapper fields
		@return NULL
		@param $key string
	**/
	function copyto($key) {
		$var=&\Base::instance()->ref($key);
		foreach ($this->fields as $key=>$field)
>>>>>>> 3.0.4 release
			$var[$key]=$field['value'];
	}

	/**
<<<<<<< HEAD
	*	Return schema
	*	@return array
	**/
	function schema() {
		return $this->fields;
	}

	/**
	*	Return field names
	*	@return array
	*	@param $adhoc bool
	**/
	function fields($adhoc=TRUE) {
		return array_keys($this->fields+($adhoc?$this->adhoc:array()));
	}

	/**
	*	Instantiate class
	*	@param $db object
	*	@param $table string
	*	@param $fields array|string
	*	@param $ttl int
	**/
	function __construct(\DB\SQL $db,$table,$fields=NULL,$ttl=60) {
		$this->db=$db;
		$this->engine=$db->driver();
		if ($this->engine=='oci')
			$table=strtoupper($table);
		$this->source=$table;
		$this->table=$this->db->quotekey($table);
		$this->fields=$db->schema($table,$fields,$ttl);
=======
		Instantiate class
		@param $db object
		@param $table string
		@param $ttl int
	**/
	function __construct(\DB\SQL $db,$table,$ttl=60) {
		$this->db=$db;
		$this->engine=$db->driver();
		$this->table=$table;
		$this->fields=$db->schema($table,$ttl);
>>>>>>> 3.0.4 release
		$this->reset();
	}

}
