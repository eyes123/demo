<?php
/******************************************************************
*
##  Project:SKPHP,A concise and easy framework for PHP
##  Copyright: 2012 All rights reserved
##  version: 0.0.1
##  Author: Sun Kid <hujw@bronco1.com>
*
##  File: Captcha.php (SKFrame_Ext_Captcha)
*
******************************************************************/
class SKFrame_Ext_Captcha
{
	//变量依次为 图像对象，验证码字符数，基础字符串，随机后的字符串，验证码长度，验证码高度，验证码SESSION名称
	private $ImgObj;
	public $StringLength=4;
	public $BaseSting;
	public $RandSting;
	public $Width=100;
	public $Height=32;
	public $CaptchaSessionName='CaptchaCode';
	//以下变量依次为 是否加上干扰点，是否加上干扰线，干扰点个数，干扰线个数，字体，字体颜色，字号，字符编码，左侧留白长度，字间距 
	public $IsDrawPIxel=true;
	public $IsDrawLine=true;
	public $PixelNumber=150;	
	public $LineNumber=4;
	public $FontFace;
	public $FontColor;
	public $FontSize=12;
	public $CharSet;
	public $LeftSpeace=2;
	public $SpaceWidth=0.5;
	public function __construct()
	{
		if(!function_exists("gd_info"))
		{
			new SKFrame_App_Error("GD库未启用或不正常！");
			exit();
		}
	}
	//设定基础字串和启用SESSION
	public function setCaptchaStr()
	{
        if(!isset($_SESSION) && !ini_get('session.auto_start')){
            session_start();  
        }
		if(empty($this->BaseString)){
		    $this->BaseString=strtoupper(md5(time()));
        }
		$_SESSION[$this->CaptchaSessionName]=$this->RandSting;
		$BackgroundColor = imagecolorallocate ($this->ImgObj, 240, 240, 240);
	}
	//设置点状干扰
	public function setRandPixel()
	{
		for ($i=0;$i<$this->PixelNumber;$i++)
		{
		    $PixelColor= imagecolorallocate ($this->ImgObj, rand(0,255), rand(0,255), rand(0,255));
		    imagesetpixel($this->ImgObj,rand(0,$this->Width),rand(0,$this->Height),$PixelColor);
		}
	}
	//加入干扰线段
	public function setRandLine()
	{
		for ($i=0;$i<$this->LineNumber;$i++)
		{
		    $LineColor = imagecolorallocate ($this->ImgObj, rand(0,255), rand(0,255), rand(0,255));
		    imageline($this->ImgObj,rand(0,$this->Width),rand(0,$this->Height),rand(0,$this->Width),rand(0,$this->Height),$LineColor);
		}
	}
	//输出PNG图像
	public function createCaptcha()
	{
		$this->ImgObj = @imagecreate ($this->Width, $this->Height);
		$this->setCaptchaStr();
		$TotalLeter=strlen($this->BaseString);
		for ($i=0;$i<$this->StringLength;$i++)
		{
			if(count($this->FontColor)<3)
				$RandFontColor = imagecolorallocate ($this->ImgObj, rand(0,255), rand(0,128), rand(0,255));
			else
				$RandFontColor = imagecolorallocate ($this->ImgObj, $this->FontColor['0'], $this->FontColor['1'], $this->FontColor['2']);
			if($i==0)
				$FontX =$this->LeftSpeace;
			else
				$FontX+= $this->FontSize+$this->SpaceWidth;
			$SplitNum=($this->CharSet=="CH")?3:1;
			if(isset($this->FontFace))
			{
				$TempChr=mb_strcut($this->BaseString, rand(0,$TotalLeter-$SplitNum),$SplitNum, 'utf-8');
				imagettftext($this->ImgObj,$this->FontSize,rand(-20,20),$FontX,rand($this->FontSize,$this->Height),$RandFontColor,$this->FontFace,$TempChr);
				$this->RandSting.=$TempChr;				
			}
			else
			{
				$TempChr=$this->BaseString{rand(0,$TotalLeter)};
				imagestring($this->ImgObj, 9, $FontX, 2, $TempChr, $RandFontColor);
				$this->RandSting.=$TempChr;	
			}
			$_SESSION["$this->CaptchaSessionName"]=$this->RandSting;
		}
        if($this->IsDrawPIxel)
	        $this->setRandPixel();
        if($this->IsDrawLine)
	        $this->setRandLine();
        header ("Content-type:image/png");		
        imagepng ($this->ImgObj);
        imagedestroy ($this->ImgObj);
	}
}
?>
