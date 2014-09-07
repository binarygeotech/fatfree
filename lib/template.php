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
//! XML-style template engine
class Template extends Preview {

	//@{ Error messages
	const
		E_Method='Call to undefined method %s()';
	//@}

	protected
		//! Template tags
		$tags,
=======
//! Template engine
class Template extends View {

	protected
		//! MIME type
		$mime,
		//! Template tags
		$tags='set|include|exclude|ignore|loop|repeat|check|true|false',
>>>>>>> 3.0.4 release
		//! Custom tag handlers
		$custom=array();

	/**
<<<<<<< HEAD
	*	Template -set- tag handler
	*	@return string
	*	@param $node array
=======
		Convert token to variable
		@return string
		@param $str string
	**/
	function token($str) {
		$self=$this;
		$str=preg_replace_callback(
			'/(?<!\w)@(\w(?:[\w\.\[\]]|\->|::)*)/',
			function($var) use($self) {
				// Convert from JS dot notation to PHP array notation
				return '$'.preg_replace_callback(
					'/(\.\w+)|\[((?:[^\[\]]*|(?R))*)\]/',
					function($expr) use($self) {
						$fw=Base::instance();
						return 
							'['.
							($expr[1]?
								$fw->stringify(substr($expr[1],1)):
								(preg_match('/^\w+/',
									$mix=$self->token($expr[2]))?
									$fw->stringify($mix):
									$mix)).
							']';
					},
					$var[1]
				);
			},
			$str
		);
		return trim(preg_replace('/{{(.+?)}}/',trim('\1'),$str));
	}

	/**
		Template -set- tag handler
		@return string
		@param $node array
>>>>>>> 3.0.4 release
	**/
	protected function _set(array $node) {
		$out='';
		foreach ($node['@attrib'] as $key=>$val)
			$out.='$'.$key.'='.
<<<<<<< HEAD
				(preg_match('/\{\{(.+?)\}\}/',$val)?
=======
				(preg_match('/{{(.+?)}}/',$val)?
>>>>>>> 3.0.4 release
					$this->token($val):
					Base::instance()->stringify($val)).'; ';
		return '<?php '.$out.'?>';
	}

	/**
<<<<<<< HEAD
	*	Template -include- tag handler
	*	@return string
	*	@param $node array
	**/
	protected function _include(array $node) {
		$attrib=$node['@attrib'];
		$hive=isset($attrib['with']) &&
			($attrib['with']=$this->token($attrib['with'])) &&
			preg_match_all('/(\w+)\h*=\h*(.+?)(?=,|$)/',
				$attrib['with'],$pairs,PREG_SET_ORDER)?
					'array('.implode(',',
						array_map(function($pair){
							return '\''.$pair[1].'\'=>'.
								(preg_match('/^\'.*\'$/',$pair[2])||preg_match('/\$/',$pair[2])?
									$pair[2]:
									\Base::instance()->stringify($pair[2]));
						},$pairs)).')+get_defined_vars()':
					'get_defined_vars()';
=======
		Template -include- tag handler
		@return string
		@param $node array
	**/
	protected function _include(array $node) {
		$attrib=$node['@attrib'];
>>>>>>> 3.0.4 release
		return
			'<?php '.(isset($attrib['if'])?
				('if ('.$this->token($attrib['if']).') '):'').
				('echo $this->render('.
<<<<<<< HEAD
					(preg_match('/\{\{(.+?)\}\}/',$attrib['href'])?
						$this->token($attrib['href']):
						Base::instance()->stringify($attrib['href'])).','.
					'$this->mime,'.$hive.'); ?>');
	}

	/**
	*	Template -exclude- tag handler
	*	@return string
=======
					(preg_match('/{{(.+?)}}/',$attrib['href'])?
						$this->token($attrib['href']):
						Base::instance()->stringify($attrib['href'])).','.
					'$this->mime,get_defined_vars()); ?>');
	}

	/**
		Template -exclude- tag handler
		@return string
>>>>>>> 3.0.4 release
	**/
	protected function _exclude() {
		return '';
	}

	/**
<<<<<<< HEAD
	*	Template -ignore- tag handler
	*	@return string
	*	@param $node array
=======
		Template -ignore- tag handler
		@return string
		@param $node array
>>>>>>> 3.0.4 release
	**/
	protected function _ignore(array $node) {
		return $node[0];
	}

	/**
<<<<<<< HEAD
	*	Template -loop- tag handler
	*	@return string
	*	@param $node array
=======
		Template -loop- tag handler
		@return string
		@param $node array
>>>>>>> 3.0.4 release
	**/
	protected function _loop(array $node) {
		$attrib=$node['@attrib'];
		unset($node['@attrib']);
		return
			'<?php for ('.
				$this->token($attrib['from']).';'.
				$this->token($attrib['to']).';'.
				$this->token($attrib['step']).'): ?>'.
				$this->build($node).
			'<?php endfor; ?>';
	}

	/**
<<<<<<< HEAD
	*	Template -repeat- tag handler
	*	@return string
	*	@param $node array
=======
		Template -repeat- tag handler
		@return string
		@param $node array
>>>>>>> 3.0.4 release
	**/
	protected function _repeat(array $node) {
		$attrib=$node['@attrib'];
		unset($node['@attrib']);
		return
			'<?php '.
				(isset($attrib['counter'])?
					(($ctr=$this->token($attrib['counter'])).'=0; '):'').
				'foreach (('.
				$this->token($attrib['group']).'?:array()) as '.
				(isset($attrib['key'])?
					($this->token($attrib['key']).'=>'):'').
				$this->token($attrib['value']).'):'.
				(isset($ctr)?(' '.$ctr.'++;'):'').' ?>'.
				$this->build($node).
			'<?php endforeach; ?>';
	}

	/**
<<<<<<< HEAD
	*	Template -check- tag handler
	*	@return string
	*	@param $node array
=======
		Template -check- tag handler
		@return string
		@param $node array
>>>>>>> 3.0.4 release
	**/
	protected function _check(array $node) {
		$attrib=$node['@attrib'];
		unset($node['@attrib']);
		// Grab <true> and <false> blocks
		foreach ($node as $pos=>$block)
			if (isset($block['true']))
				$true=array($pos,$block);
			elseif (isset($block['false']))
				$false=array($pos,$block);
		if (isset($true,$false) && $true[0]>$false[0])
			// Reverse <true> and <false> blocks
			list($node[$true[0]],$node[$false[0]])=array($false[1],$true[1]);
		return
			'<?php if ('.$this->token($attrib['if']).'): ?>'.
				$this->build($node).
			'<?php endif; ?>';
	}

	/**
<<<<<<< HEAD
	*	Template -true- tag handler
	*	@return string
	*	@param $node array
=======
		Template -true- tag handler
		@return string
		@param $node array
>>>>>>> 3.0.4 release
	**/
	protected function _true(array $node) {
		return $this->build($node);
	}

	/**
<<<<<<< HEAD
	*	Template -false- tag handler
	*	@return string
	*	@param $node array
=======
		Template -false- tag handler
		@return string
		@param $node array
>>>>>>> 3.0.4 release
	**/
	protected function _false(array $node) {
		return '<?php else: ?>'.$this->build($node);
	}

	/**
<<<<<<< HEAD
	*	Template -switch- tag handler
	*	@return string
	*	@param $node array
	**/
	protected function _switch(array $node) {
		$attrib=$node['@attrib'];
		unset($node['@attrib']);
		foreach ($node as $pos=>$block)
			if (is_string($block) && !preg_replace('/\s+/','',$block))
				unset($node[$pos]);
		return
			'<?php switch ('.$this->token($attrib['expr']).'): ?>'.
				$this->build($node).
			'<?php endswitch; ?>';
	}

	/**
	*	Template -case- tag handler
	*	@return string
	*	@param $node array
	**/
	protected function _case(array $node) {
		$attrib=$node['@attrib'];
		unset($node['@attrib']);
		return
			'<?php case '.(preg_match('/\{\{(.+?)\}\}/',$attrib['value'])?
				$this->token($attrib['value']):
				Base::instance()->stringify($attrib['value'])).': ?>'.
				$this->build($node).
			'<?php '.(isset($attrib['break'])?
				'if ('.$this->token($attrib['break']).') ':'').
				'break; ?>';
	}

	/**
	*	Template -default- tag handler
	*	@return string
	*	@param $node array
	**/
	protected function _default(array $node) {
		return
			'<?php default: ?>'.
				$this->build($node).
			'<?php break; ?>';
	}

	/**
	*	Assemble markup
	*	@return string
	*	@param $node array|string
	**/
	protected function build($node) {
		if (is_string($node))
			return parent::build($node);
=======
		Assemble markup
		@return string
		@param $node array|string
	**/
	protected function build($node) {
		if (is_string($node)) {
			$self=$this;
			return preg_replace_callback(
				'/{{(.+?)}}/s',
				function($expr) use($self) {
					$str=trim($self->token($expr[1]));
					if (preg_match('/^(.+?)\h*\|\h*(raw|esc|format)$/',
						$str,$parts))
						$str='Base::instance()->'.$parts[2].'('.$parts[1].')';
					return '<?php echo '.$str.'; ?>';
				},
				$node
			);
		}
>>>>>>> 3.0.4 release
		$out='';
		foreach ($node as $key=>$val)
			$out.=is_int($key)?$this->build($val):$this->{'_'.$key}($val);
		return $out;
	}

	/**
<<<<<<< HEAD
	*	Extend template with custom tag
	*	@return NULL
	*	@param $tag string
	*	@param $func callback
=======
		Extend template with custom tag
		@return NULL
		@param $tag string
		@param $func callback
>>>>>>> 3.0.4 release
	**/
	function extend($tag,$func) {
		$this->tags.='|'.$tag;
		$this->custom['_'.$tag]=$func;
	}

	/**
<<<<<<< HEAD
	*	Call custom tag handler
	*	@return string|FALSE
	*	@param $func callback
	*	@param $args array
	**/
	function __call($func,array $args) {
		if ($func[0]=='_')
			return call_user_func_array($this->custom[$func],$args);
		if (method_exists($this,$func))
			return call_user_func_array(array($this,$func),$args);
		user_error(sprintf(self::E_Method,$func));
	}

	/**
	*	Parse string for template directives and tokens
	*	@return string|array
	*	@param $text string
	**/
	function parse($text) {
		// Build tree structure
		for ($ptr=0,$len=strlen($text),$tree=array(),$node=&$tree,
			$stack=array(),$depth=0,$tmp='';$ptr<$len;)
			if (preg_match('/^<(\/?)(?:F3:)?'.
				'('.$this->tags.')\b((?:\h+[\w-]+'.
				'(?:\h*=\h*(?:"(?:.+?)"|\'(?:.+?)\'))?|'.
				'\h*\{\{.+?\}\})*)\h*(\/?)>/is',
				substr($text,$ptr),$match)) {
				if (strlen($tmp))
					$node[]=$tmp;
				// Element node
				if ($match[1]) {
					// Find matching start tag
					$save=$depth;
					$found=FALSE;
					while ($depth>0) {
						$depth--;
						foreach ($stack[$depth] as $item)
							if (is_array($item) && isset($item[$match[2]])) {
								// Start tag found
								$found=TRUE;
								break 2;
							}
					}
					if (!$found)
						// Unbalanced tag
						$depth=$save;
					$node=&$stack[$depth];
				}
				else {
					// Start tag
					$stack[$depth]=&$node;
					$node=&$node[][$match[2]];
					if ($match[3]) {
						// Process attributes
						preg_match_all(
							'/(?:\b([\w-]+)\h*'.
							'(?:=\h*(?:"(.*?)"|\'(.*?)\'))?|'.
							'(\{\{.+?\}\}))/s',
							$match[3],$attr,PREG_SET_ORDER);
						foreach ($attr as $kv)
							if (isset($kv[4]))
								$node['@attrib'][]=$kv[4];
							else
								$node['@attrib'][$kv[1]]=
									((isset($kv[2]) && $kv[2]!=='')?$kv[2]:
										((isset($kv[3]) && $kv[3]!=='')?$kv[3]:NULL));
					}
					if ($match[4])
						// Empty tag
						$node=&$stack[$depth];
					else
						$depth++;
				}
				$tmp='';
				$ptr+=strlen($match[0]);
			}
			else {
				// Text node
				$tmp.=substr($text,$ptr,1);
				$ptr++;
			}
		if (strlen($tmp))
			// Append trailing text
			$node[]=$tmp;
		// Break references
		unset($node);
		unset($stack);
		return $tree;
	}

	/**
	*	Class constructor
	*	return object
	**/
	function __construct() {
		$ref=new ReflectionClass(__CLASS__);
		$this->tags='';
		foreach ($ref->getmethods() as $method)
			if (preg_match('/^_(?=[[:alpha:]])/',$method->name))
				$this->tags.=(strlen($this->tags)?'|':'').
					substr($method->name,1);
=======
		Call custom tag handler
		@return string|FALSE
		@param $func callback
		@param $args array
	**/
	function __call($func,array $args) {
		return ($func[0]=='_')?
			call_user_func_array($this->custom[$func],$args):
			FALSE;
	}

	/**
		Render template
		@return string
		@param $file string
		@param $mime string
		@param $hive array
	**/
	function render($file,$mime='text/html',array $hive=NULL) {
		$fw=Base::instance();
		if (!is_dir($tmp=$fw->get('TEMP')))
			mkdir($tmp,Base::MODE,TRUE);
		foreach ($fw->split($fw->get('UI')) as $dir)
			if (is_file($view=$fw->fixslashes($dir.$file))) {
				if (!is_file($this->view=($tmp.'/'.
					$fw->hash($fw->get('ROOT').$fw->get('BASE')).'.'.
					$fw->hash($view).'.php')) ||
					filemtime($this->view)<filemtime($view)) {
					// Remove PHP code and comments
					$text=preg_replace('/<\?(?:php)?.+?\?>|{{\*.+?\*}}/is','',
						$fw->read($view));
					// Build tree structure
					for ($ptr=0,$len=strlen($text),$tree=array(),$node=&$tree,
						$stack=array(),$depth=0,$tmp='';$ptr<$len;)
						if (preg_match('/^<(\/?)(?:F3:)?('.$this->tags.')\b'.
							'((?:\h+\w+\h*=\h*(?:"(?:.+?)"|\'(?:.+?)\'))*)'.
							'\h*(\/?)>/is',substr($text,$ptr),$match)) {
							if (strlen($tmp))
								$node[]=$tmp;
							// Element node
							if ($match[1]) {
								// Find matching start tag
								$save=$depth;
								$found=FALSE;
								while ($depth>0) {
									$depth--;
									foreach ($stack[$depth] as $item)
										if (is_array($item) &&
											isset($item[$match[2]])) {
											// Start tag found
											$found=TRUE;
											break 2;
										}
								}
								if (!$found)
									// Unbalanced tag
									$depth=$save;
								$node=&$stack[$depth];
							}
							else {
								// Start tag
								$stack[$depth]=&$node;
								$node=&$node[][$match[2]];
								if ($match[3]) {
									// Process attributes
									preg_match_all(
										'/\b(\w+)\h*=\h*'.
										'(?:"(.+?)"|\'(.+?)\')/s',
										$match[3],$attr,PREG_SET_ORDER);
									foreach ($attr as $kv)
										$node['@attrib'][$kv[1]]=
											$kv[2]?:$kv[3];
								}
								if ($match[4])
									// Empty tag
									$node=&$stack[$depth];
								else
									$depth++;
							}
							$tmp='';
							$ptr+=strlen($match[0]);
						}
						else {
							// Text node
							$tmp.=$text[$ptr];
							$ptr++;
						}
					if (strlen($tmp))
						// Append trailing text
						$node[]=$tmp;
					// Break references
					unset($node);
					unset($stack);
					$fw->write($this->view,$this->build($tree));
				}
				if (isset($_COOKIE[session_name()]))
					@session_start();
				$fw->sync('SESSION');
				if (!$hive)
					$hive=$fw->hive();
				$this->hive=$fw->get('ESCAPE')?$fw->esc($hive):$hive;
				if (PHP_SAPI!='cli')
					header('Content-Type: '.($this->mime=$mime).'; '.
						'charset='.$fw->get('ENCODING'));
				return $this->sandbox();
			}
		user_error(sprintf(Base::E_Open,$file));
>>>>>>> 3.0.4 release
	}

}
