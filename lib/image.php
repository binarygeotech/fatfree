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

//! Image manipulation tools
class Image {

	//@{ Messages
	const
<<<<<<< HEAD
		E_Color='Invalid color specified: %s',
		E_Font='CAPTCHA font not found',
		E_Length='Invalid CAPTCHA length: %s';
=======
		E_Color='Invalid color specified: %s';
>>>>>>> 3.0.4 release
	//@}

	//@{ Positional cues
	const
		POS_Left=1,
		POS_Center=2,
		POS_Right=4,
		POS_Top=8,
		POS_Middle=16,
		POS_Bottom=32;
	//@}

<<<<<<< HEAD
	protected
=======
	private
>>>>>>> 3.0.4 release
		//! Source filename
		$file,
		//! Image resource
		$data,
		//! Enable/disable history
		$flag=FALSE,
		//! Filter count
		$count=0;

	/**
<<<<<<< HEAD
	*	Convert RGB hex triad to array
	*	@return array|FALSE
	*	@param $color int
=======
		Convert RGB hex triad to array
		@return array|FALSE
		@param $color int
>>>>>>> 3.0.4 release
	**/
	function rgb($color) {
		$hex=str_pad($hex=dechex($color),$color<4096?3:6,'0',STR_PAD_LEFT);
		if (($len=strlen($hex))>6)
			user_error(sprintf(self::E_Color,'0x'.$hex));
		$color=str_split($hex,$len/3);
		foreach ($color as &$hue) {
			$hue=hexdec(str_repeat($hue,6/$len));
			unset($hue);
		}
		return $color;
	}

	/**
<<<<<<< HEAD
	*	Invert image
	*	@return object
=======
		Invert image
		@return object
>>>>>>> 3.0.4 release
	**/
	function invert() {
		imagefilter($this->data,IMG_FILTER_NEGATE);
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Adjust brightness (range:-255 to 255)
	*	@return object
	*	@param $level int
=======
		Adjust brightness (range:-255 to 255)
		@return object
		@param $level int
>>>>>>> 3.0.4 release
	**/
	function brightness($level) {
		imagefilter($this->data,IMG_FILTER_BRIGHTNESS,$level);
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Adjust contrast (range:-100 to 100)
	*	@return object
	*	@param $level int
=======
		Adjust contrast (range:-100 to 100)
		@return object
		@param $level int
>>>>>>> 3.0.4 release
	**/
	function contrast($level) {
		imagefilter($this->data,IMG_FILTER_CONTRAST,$level);
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Convert to grayscale
	*	@return object
=======
		Convert to grayscale
		@return object
>>>>>>> 3.0.4 release
	**/
	function grayscale() {
		imagefilter($this->data,IMG_FILTER_GRAYSCALE);
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Adjust smoothness
	*	@return object
	*	@param $level int
=======
		Adjust smoothness
		@return object
		@param $level int
>>>>>>> 3.0.4 release
	**/
	function smooth($level) {
		imagefilter($this->data,IMG_FILTER_SMOOTH,$level);
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Emboss the image
	*	@return object
=======
		Emboss the image
		@return object
>>>>>>> 3.0.4 release
	**/
	function emboss() {
		imagefilter($this->data,IMG_FILTER_EMBOSS);
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Apply sepia effect
	*	@return object
=======
		Apply sepia effect
		@return object
>>>>>>> 3.0.4 release
	**/
	function sepia() {
		imagefilter($this->data,IMG_FILTER_GRAYSCALE);
		imagefilter($this->data,IMG_FILTER_COLORIZE,90,60,45);
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Pixelate the image
	*	@return object
	*	@param $size int
=======
		Pixelate the image
		@return object
		@param $size int
>>>>>>> 3.0.4 release
	**/
	function pixelate($size) {
		imagefilter($this->data,IMG_FILTER_PIXELATE,$size,TRUE);
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Blur the image using Gaussian filter
	*	@return object
	*	@param $selective bool
=======
		Blur the image using Gaussian filter
		@return object
		@param $selective bool
>>>>>>> 3.0.4 release
	**/
	function blur($selective=FALSE) {
		imagefilter($this->data,
			$selective?IMG_FILTER_SELECTIVE_BLUR:IMG_FILTER_GAUSSIAN_BLUR);
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Apply sketch effect
	*	@return object
=======
		Apply sketch effect
		@return object
>>>>>>> 3.0.4 release
	**/
	function sketch() {
		imagefilter($this->data,IMG_FILTER_MEAN_REMOVAL);
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Flip on horizontal axis
	*	@return object
=======
		Flip on horizontal axis
		@return object
>>>>>>> 3.0.4 release
	**/
	function hflip() {
		$tmp=imagecreatetruecolor(
			$width=$this->width(),$height=$this->height());
		imagesavealpha($tmp,TRUE);
		imagefill($tmp,0,0,IMG_COLOR_TRANSPARENT);
		imagecopyresampled($tmp,$this->data,
			0,0,$width-1,0,$width,$height,-$width,$height);
		imagedestroy($this->data);
		$this->data=$tmp;
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Flip on vertical axis
	*	@return object
=======
		Flip on vertical axis
		@return object
>>>>>>> 3.0.4 release
	**/
	function vflip() {
		$tmp=imagecreatetruecolor(
			$width=$this->width(),$height=$this->height());
		imagesavealpha($tmp,TRUE);
		imagefill($tmp,0,0,IMG_COLOR_TRANSPARENT);
		imagecopyresampled($tmp,$this->data,
			0,0,0,$height-1,$width,$height,$width,-$height);
		imagedestroy($this->data);
		$this->data=$tmp;
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Crop the image
	*	@return object
	*	@param $x1 int
	*	@param $y1 int
	*	@param $x2 int
	*	@param $y2 int
	**/
	function crop($x1,$y1,$x2,$y2) {
		$tmp=imagecreatetruecolor($width=$x2-$x1+1,$height=$y2-$y1+1);
		imagesavealpha($tmp,TRUE);
		imagefill($tmp,0,0,IMG_COLOR_TRANSPARENT);
		imagecopyresampled($tmp,$this->data,
			0,0,$x1,$y1,$width,$height,$width,$height);
		imagedestroy($this->data);
		$this->data=$tmp;
		return $this->save();
	}

	/**
	*	Resize image (Maintain aspect ratio); Crop relative to center
	*	if flag is enabled; Enlargement allowed if flag is enabled
	*	@return object
	*	@param $width int
	*	@param $height int
	*	@param $crop bool
	*	@param $enlarge bool
	**/
	function resize($width,$height,$crop=TRUE,$enlarge=TRUE) {
=======
		Resize image (Maintain aspect ratio); Crop relative to center
		if flag is enabled
		@return object
		@param $width int
		@param $height int
		@param $crop bool
	**/
	function resize($width,$height,$crop=TRUE) {
>>>>>>> 3.0.4 release
		// Adjust dimensions; retain aspect ratio
		$ratio=($origw=imagesx($this->data))/($origh=imagesy($this->data));
		if (!$crop)
			if ($width/$ratio<=$height)
				$height=$width/$ratio;
			else
				$width=$height*$ratio;
<<<<<<< HEAD
		if (!$enlarge) {
			$width=min($origw,$width);
			$height=min($origh,$height);
		}
=======
>>>>>>> 3.0.4 release
		// Create blank image
		$tmp=imagecreatetruecolor($width,$height);
		imagesavealpha($tmp,TRUE);
		imagefill($tmp,0,0,IMG_COLOR_TRANSPARENT);
		// Resize
		if ($crop) {
			if ($width/$ratio<=$height) {
				$cropw=$origh*$width/$height;
				imagecopyresampled($tmp,$this->data,
					0,0,($origw-$cropw)/2,0,$width,$height,$cropw,$origh);
			}
			else {
				$croph=$origw*$height/$width;
				imagecopyresampled($tmp,$this->data,
					0,0,0,($origh-$croph)/2,$width,$height,$origw,$croph);
			}
		}
		else
			imagecopyresampled($tmp,$this->data,
				0,0,0,0,$width,$height,$origw,$origh);
		imagedestroy($this->data);
		$this->data=$tmp;
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Rotate image
	*	@return object
	*	@param $angle int
	**/
	function rotate($angle) {
		$this->data=imagerotate($this->data,$angle,
			imagecolorallocatealpha($this->data,0,0,0,127));
=======
		Rotate image
		@return object
		@param $angle int
	**/
	function rotate($angle) {
		$this->data=imagerotate($this->data,$angle,IMG_COLOR_TRANSPARENT);
>>>>>>> 3.0.4 release
		imagesavealpha($this->data,TRUE);
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Apply an image overlay
	*	@return object
	*	@param $img object
	*	@param $align int|array
	*	@param $alpha int
	**/
	function overlay(Image $img,$align=NULL,$alpha=100) {
		if (is_null($align))
			$align=self::POS_Right|self::POS_Bottom;
		if (is_array($align)) {
			list($posx,$posy)=$align;
			$align = 0;
		}
=======
		Apply an image overlay
		@return object
		@param $img object
		@param $align int
	**/
	function overlay(Image $img,$align=NULL) {
		if (is_null($align))
			$align=self::POS_Right|self::POS_Bottom;
>>>>>>> 3.0.4 release
		$ovr=imagecreatefromstring($img->dump());
		imagesavealpha($ovr,TRUE);
		$imgw=$this->width();
		$imgh=$this->height();
		$ovrw=imagesx($ovr);
		$ovrh=imagesy($ovr);
		if ($align & self::POS_Left)
			$posx=0;
		if ($align & self::POS_Center)
			$posx=($imgw-$ovrw)/2;
		if ($align & self::POS_Right)
			$posx=$imgw-$ovrw;
		if ($align & self::POS_Top)
			$posy=0;
		if ($align & self::POS_Middle)
			$posy=($imgh-$ovrh)/2;
		if ($align & self::POS_Bottom)
			$posy=$imgh-$ovrh;
		if (empty($posx))
			$posx=0;
		if (empty($posy))
			$posy=0;
<<<<<<< HEAD
		if ($alpha==100)
			imagecopy($this->data,$ovr,$posx,$posy,0,0,$ovrw,$ovrh);
		else {
			$cut=imagecreatetruecolor($ovrw,$ovrh);
			imagecopy($cut,$this->data,0,0,$posx,$posy,$ovrw,$ovrh);
			imagecopy($cut,$ovr,0,0,0,0,$ovrw,$ovrh);
			imagecopymerge($this->data,
				$cut,$posx,$posy,0,0,$ovrw,$ovrh,$alpha);
		}
=======
		imagecopy($this->data,$ovr,$posx,$posy,0,0,$ovrw,$ovrh);
>>>>>>> 3.0.4 release
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Generate identicon
	*	@return object
	*	@param $str string
	*	@param $size int
	*	@param $blocks int
=======
		Generate identicon
			@return object
			@param $str string
			@param $size int
			@param $blocks int
>>>>>>> 3.0.4 release
	**/
	function identicon($str,$size=64,$blocks=4) {
		$sprites=array(
			array(.5,1,1,0,1,1),
			array(.5,0,1,0,.5,1,0,1),
			array(.5,0,1,0,1,1,.5,1,1,.5),
			array(0,.5,.5,0,1,.5,.5,1,.5,.5),
			array(0,.5,1,0,1,1,0,1,1,.5),
			array(1,0,1,1,.5,1,1,.5,.5,.5),
			array(0,0,1,0,1,.5,0,0,.5,1,0,1),
			array(0,0,.5,0,1,.5,.5,1,0,1,.5,.5),
			array(.5,0,.5,.5,1,.5,1,1,.5,1,.5,.5,0,.5),
			array(0,0,1,0,.5,.5,1,.5,.5,1,.5,.5,0,1),
			array(0,.5,.5,1,1,.5,.5,0,1,0,1,1,0,1),
			array(.5,0,1,0,1,1,.5,1,1,.75,.5,.5,1,.25),
			array(0,.5,.5,0,.5,.5,1,0,1,.5,.5,1,.5,.5,0,1),
			array(0,0,1,0,1,1,0,1,1,.5,.5,.25,.5,.75,0,.5,.5,.25),
			array(0,.5,.5,.5,.5,0,1,0,.5,.5,1,.5,.5,1,.5,.5,0,1),
			array(0,0,1,0,.5,.5,.5,0,0,.5,1,.5,.5,1,.5,.5,0,1)
		);
<<<<<<< HEAD
		$hash=sha1($str);
		$this->data=imagecreatetruecolor($size,$size);
		list($r,$g,$b)=$this->rgb(hexdec(substr($hash,-3)));
		$fg=imagecolorallocate($this->data,$r,$g,$b);
		imagefill($this->data,0,0,IMG_COLOR_TRANSPARENT);
=======
		$this->data=imagecreatetruecolor($size,$size);
		list($r,$g,$b)=$this->rgb(mt_rand(0x333,0xCCC));
		$fg=imagecolorallocate($this->data,$r,$g,$b);
		imagefill($this->data,0,0,IMG_COLOR_TRANSPARENT);
		$hash=sha1($str);
>>>>>>> 3.0.4 release
		$ctr=count($sprites);
		$dim=$blocks*floor($size/$blocks)*2/$blocks;
		for ($j=0,$y=ceil($blocks/2);$j<$y;$j++)
			for ($i=$j,$x=$blocks-1-$j;$i<$x;$i++) {
				$sprite=imagecreatetruecolor($dim,$dim);
				imagefill($sprite,0,0,IMG_COLOR_TRANSPARENT);
				if ($block=$sprites[
					hexdec($hash[($j*$blocks+$i)*2])%$ctr]) {
					for ($k=0,$pts=count($block);$k<$pts;$k++)
						$block[$k]*=$dim;
					imagefilledpolygon($sprite,$block,$pts/2,$fg);
				}
				$sprite=imagerotate($sprite,
					90*(hexdec($hash[($j*$blocks+$i)*2+1])%4),
<<<<<<< HEAD
					imagecolorallocatealpha($sprite,0,0,0,127));
=======
					IMG_COLOR_TRANSPARENT);
>>>>>>> 3.0.4 release
				for ($k=0;$k<4;$k++) {
					imagecopyresampled($this->data,$sprite,
						$i*$dim/2,$j*$dim/2,0,0,$dim/2,$dim/2,$dim,$dim);
					$this->data=imagerotate($this->data,90,
<<<<<<< HEAD
						imagecolorallocatealpha($this->data,0,0,0,127));
=======
						IMG_COLOR_TRANSPARENT);
>>>>>>> 3.0.4 release
				}
				imagedestroy($sprite);
			}
		imagesavealpha($this->data,TRUE);
		return $this->save();
	}

	/**
<<<<<<< HEAD
	*	Generate CAPTCHA image
	*	@return object|FALSE
	*	@param $font string
	*	@param $size int
	*	@param $len int
	*	@param $key string
	*	@param $path string
	*	@param $fg int
	*	@param $bg int
	**/
	function captcha($font,$size=24,$len=5,
		$key=NULL,$path='',$fg=0xFFFFFF,$bg=0x000000) {
		if ((!$ssl=extension_loaded('openssl')) && ($len<4 || $len>13)) {
			user_error(sprintf(self::E_Length,$len));
			return FALSE;
		}
		$fw=Base::instance();
		foreach ($fw->split($path?:$fw->get('UI').';./') as $dir)
			if (is_file($path=$dir.$font)) {
				$seed=strtoupper(substr(
					$ssl?bin2hex(openssl_random_pseudo_bytes($len)):uniqid(),
					-$len));
=======
		Generate CAPTCHA image
		@return object|FALSE
		@param $font string
		@param $size int
		@param $len int
		@param $key string
	**/
	function captcha($font,$size=24,$len=5,$key=NULL) {
		$fw=Base::instance();
		foreach ($fw->split($fw->get('UI')) as $dir)
			if (is_file($path=$dir.$font)) {
				$seed=strtoupper(substr(uniqid(),-$len));
>>>>>>> 3.0.4 release
				$block=$size*3;
				$tmp=array();
				for ($i=0,$width=0,$height=0;$i<$len;$i++) {
					// Process at 2x magnification
					$box=imagettfbbox($size*2,0,$path,$seed[$i]);
					$w=$box[2]-$box[0];
					$h=$box[1]-$box[5];
					$char=imagecreatetruecolor($block,$block);
<<<<<<< HEAD
					imagefill($char,0,0,$bg);
					imagettftext($char,$size*2,0,
						($block-$w)/2,$block-($block-$h)/2,
						$fg,$path,$seed[$i]);
					$char=imagerotate($char,mt_rand(-30,30),
						imagecolorallocatealpha($char,0,0,0,127));
=======
					imagefill($char,0,0,0);
					imagettftext($char,$size*2,0,
						($block-$w)/2,$block-($block-$h)/2,
						0xFFFFFF,$path,$seed[$i]);
					$char=imagerotate($char,
						mt_rand(-30,30),IMG_COLOR_TRANSPARENT);
>>>>>>> 3.0.4 release
					// Reduce to normal size
					$tmp[$i]=imagecreatetruecolor(
						($w=imagesx($char))/2,($h=imagesy($char))/2);
					imagefill($tmp[$i],0,0,IMG_COLOR_TRANSPARENT);
<<<<<<< HEAD
					imagecopyresampled($tmp[$i],
						$char,0,0,0,0,$w/2,$h/2,$w,$h);
=======
					imagecopyresampled($tmp[$i],$char,0,0,0,0,$w/2,$h/2,$w,$h);
>>>>>>> 3.0.4 release
					imagedestroy($char);
					$width+=$i+1<$len?$block/2:$w/2;
					$height=max($height,$h/2);
				}
				$this->data=imagecreatetruecolor($width,$height);
				imagefill($this->data,0,0,IMG_COLOR_TRANSPARENT);
				for ($i=0;$i<$len;$i++) {
					imagecopy($this->data,$tmp[$i],
						$i*$block/2,($height-imagesy($tmp[$i]))/2,0,0,
						imagesx($tmp[$i]),imagesy($tmp[$i]));
					imagedestroy($tmp[$i]);
				}
				imagesavealpha($this->data,TRUE);
				if ($key)
					$fw->set($key,$seed);
				return $this->save();
			}
<<<<<<< HEAD
		user_error(self::E_Font);
=======
>>>>>>> 3.0.4 release
		return FALSE;
	}

	/**
<<<<<<< HEAD
	*	Return image width
	*	@return int
=======
		Return image width
		@return int
>>>>>>> 3.0.4 release
	**/
	function width() {
		return imagesx($this->data);
	}

	/**
<<<<<<< HEAD
	*	Return image height
	*	@return int
=======
		Return image height
		@return int
>>>>>>> 3.0.4 release
	**/
	function height() {
		return imagesy($this->data);
	}

	/**
<<<<<<< HEAD
	*	Send image to HTTP client
	*	@return NULL
=======
		Send image to HTTP client
		@return NULL
>>>>>>> 3.0.4 release
	**/
	function render() {
		$args=func_get_args();
		$format=$args?array_shift($args):'png';
		if (PHP_SAPI!='cli') {
			header('Content-Type: image/'.$format);
			header('X-Powered-By: '.Base::instance()->get('PACKAGE'));
		}
<<<<<<< HEAD
		call_user_func_array('image'.$format,
			array_merge(array($this->data),$args));
	}

	/**
	*	Return image as a string
	*	@return string
=======
		call_user_func_array('image'.$format,array($this->data)+$args);
	}

	/**
		Return image as a string
		@return string
>>>>>>> 3.0.4 release
	**/
	function dump() {
		$args=func_get_args();
		$format=$args?array_shift($args):'png';
		ob_start();
<<<<<<< HEAD
		call_user_func_array('image'.$format,
			array_merge(array($this->data),$args));
=======
		call_user_func_array('image'.$format,array($this->data)+$args);
>>>>>>> 3.0.4 release
		return ob_get_clean();
	}

	/**
<<<<<<< HEAD
	*	Save current state
	*	@return object
=======
		Save current state
		@return object
>>>>>>> 3.0.4 release
	**/
	function save() {
		$fw=Base::instance();
		if ($this->flag) {
			if (!is_dir($dir=$fw->get('TEMP')))
				mkdir($dir,Base::MODE,TRUE);
			$this->count++;
			$fw->write($dir.'/'.
				$fw->hash($fw->get('ROOT').$fw->get('BASE')).'.'.
				$fw->hash($this->file).'-'.$this->count.'.png',
				$this->dump());
		}
		return $this;
	}

	/**
<<<<<<< HEAD
	*	Revert to specified state
	*	@return object
	*	@param $state int
=======
		Revert to specified state
		@return object
		@param $state int
>>>>>>> 3.0.4 release
	**/
	function restore($state=1) {
		$fw=Base::instance();
		if ($this->flag && is_file($file=($path=$fw->get('TEMP').
			$fw->hash($fw->get('ROOT').$fw->get('BASE')).'.'.
			$fw->hash($this->file).'-').$state.'.png')) {
			if (is_resource($this->data))
				imagedestroy($this->data);
			$this->data=imagecreatefromstring($fw->read($file));
			imagesavealpha($this->data,TRUE);
			foreach (glob($path.'*.png',GLOB_NOSORT) as $match)
				if (preg_match('/-(\d+)\.png/',$match,$parts) &&
					$parts[1]>$state)
					@unlink($match);
			$this->count=$state;
		}
		return $this;
	}

	/**
<<<<<<< HEAD
	*	Undo most recently applied filter
	*	@return object
=======
		Undo most recently applied filter
		@return object
>>>>>>> 3.0.4 release
	**/
	function undo() {
		if ($this->flag) {
			if ($this->count)
				$this->count--;
			return $this->restore($this->count);
		}
		return $this;
	}

	/**
<<<<<<< HEAD
	*	Load string
	*	@return object
	*	@param $str string
	**/
	function load($str) {
		$this->data=imagecreatefromstring($str);
		imagesavealpha($this->data,TRUE);
		$this->save();
		return $this;
	}

	/**
	*	Instantiate image
	*	@param $file string
	*	@param $flag bool
	*	@param $path string
	**/
	function __construct($file=NULL,$flag=FALSE,$path='') {
=======
		Instantiate image
		@param $file string
		@param $flag bool
	**/
	function __construct($file=NULL,$flag=FALSE) {
>>>>>>> 3.0.4 release
		$this->flag=$flag;
		if ($file) {
			$fw=Base::instance();
			// Create image from file
			$this->file=$file;
<<<<<<< HEAD
			foreach ($fw->split($path?:$fw->get('UI').';./') as $dir)
				if (is_file($dir.$file))
					return $this->load($fw->read($dir.$file));
=======
			foreach ($fw->split($fw->get('UI')) as $dir)
				if (is_file($dir.$file)) {
					$this->data=imagecreatefromstring($fw->read($dir.$file));
					imagesavealpha($this->data,TRUE);
					$this->save();
				}
>>>>>>> 3.0.4 release
		}
	}

	/**
<<<<<<< HEAD
	*	Wrap-up
	*	@return NULL
=======
		Wrap-up
		@return NULL
>>>>>>> 3.0.4 release
	**/
	function __destruct() {
		if (is_resource($this->data)) {
			imagedestroy($this->data);
			$fw=Base::instance();
			$path=$fw->get('TEMP').
				$fw->hash($fw->get('ROOT').$fw->get('BASE')).'.'.
				$fw->hash($this->file);
<<<<<<< HEAD
			if ($glob=@glob($path.'*.png',GLOB_NOSORT))
				foreach ($glob as $match)
					if (preg_match('/-(\d+)\.png/',$match))
						@unlink($match);
=======
			foreach (glob($path.'*.png',GLOB_NOSORT) as $match)
				if (preg_match('/-(\d+)\.png/',$match))
					@unlink($match);
>>>>>>> 3.0.4 release
		}
	}

}
