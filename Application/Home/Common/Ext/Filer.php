<?php

/******************************************************************
*
##  Project:SKPHP,A concise and easy framework for PHP
##  Copyright: 2012 All rights reserved
##  version: 0.0.1
##  Author: Sun Kid <hujw@bronco1.com>
*
##  File: Ftp.php (Ext_Filer)
*
******************************************************************/
class Ext_Filer{

	public static function upFile($btnName,$dirName='image')
	{
		$result = array();
		//定义允许上传的文件扩展名
		$extArr = array(
				'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
				'flash' => array('swf', 'flv'),
				'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
				'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
				'excel' => array("csv")
		);
		//最大文件大小
		$max_size = 10000000;
		//原文件名
		$file_name = $_FILES[$btnName]['name'];
		//服务器上临时文件名
		$tmpName = $_FILES[$btnName]['tmp_name'];
		//文件大小
		$file_size = $_FILES[$btnName]['size'];
		//检查文件名
		if (!$file_name) {
			$result["message"]="请选择文件。";
			return $result;
		}
		
		//检查文件大小
		if ($file_size > $max_size) {
			$result["message"]="上传文件大小超过限制。";
			return $result;
		}
		
		//PHP上传失败
		if (!empty($_FILES[$btnName]['error'])) {
			switch($_FILES[$btnName]['error']){
				case '1':
					$error = '超过php.ini允许的大小。';
					break;
				case '2':
					$error = '超过表单允许的大小。';
					break;
				case '3':
					$error = '图片只有部分被上传。';
					break;
				case '4':
					$error = '请选择图片。';
					break;
				case '6':
					$error = '找不到临时目录。';
					break;
				case '7':
					$error = '写文件到硬盘出错。';
					break;
				case '8':
					$error = 'File upload stopped by extension。';
					break;
				case '999':
				default:
					$error = '未知错误。';
			}
			$result["message"]=$error;
			return $result;
		}
		
		$savePath = $_SERVER['DOCUMENT_ROOT'].__ROOT__.'/Public/Upload/';
	
		
		/* $savePath = str_replace("//", "/",$savePath);
		print_r($savePath); */
		//创建文件夹
		if ($dirName !== '') {
			$savePath .= $dirName . "/";
			
			if (!file_exists($savePath)) {
				mkdir($savePath,775);
			}
		}
		//检查目录
		if (@is_dir($savePath) === false) {
			$result["message"]="上传目录不存在。";
			return $result;
		}
		//检查目录写权限
		if (@is_writable($savePath) === false) {
			$result["message"]="上传目录没有写权限。";
			return $result;
		}
		//获得文件扩展名
		$tempArr = explode(".", $file_name);
		$fileExt = array_pop($tempArr);
		$fileExt = trim($fileExt);
		$fileExt = strtolower($fileExt);
		
		if(isset($extArr[$dirName]))
		{
			//检查扩展名
			if (in_array($fileExt, $extArr[$dirName]) === false) {
				$result["message"]="上传文件扩展名'".$dirName."'是不允许的扩展名。";
				return $result;
			}
		}
		else
		{
			$result["message"]="上传文件扩展名'".$dirName."'是不允许的扩展名。";
			return $result;
		}
		
		//新文件名
		$newFileName = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $fileExt;
		//开始上传
		$filePath = $savePath . $newFileName;
		if (move_uploaded_file($tmpName, $filePath) === false) {
			$result["message"]="上传失败。";
			return $result;
		}
		@chmod($filePath, 0644);
		$result["path"]=$filePath;
		return $result;
	}
	
	/**
	 * 功能: 得到指定文件的内容
	 * 参数: $file 目标文件
	 */
	public function getFileSource($file){
	    if(file_exists($file)){
	        return file_get_contents($file);
	    }
	    else
	        return false;
	}


	/**
	 * 功能:创建新文件，并写入内容，如果指定文件名已存在，那将直接覆盖
	 * 参数: $file -- 新文件名
	 * $source  文件内容
	 */
	public function writeFile($file,$source){
	    if($fp = fopen($file,'w')){
	        $filesource = fwrite($fp,$source);
	        fclose($fp);
	        return $filesource;
	    }
	    else
	        return false;
	}

	/**
	 * 功能: 移动文件
	 * 参数: $file -- 待移动的文件名
	 * $destfile -- 目标文件名
	 * $overwrite 如果目标文件存在，是否覆盖.默认是覆盖.
	 * $bak 是否保留原文件 默认是不保留即删除原文件
	 */
	public function moveFile($file,$destfile,$overwrite=1,$bak=0){
	    if(file_exists($destfile)){
	        if($overwrite)
	            unlink($destfile);
	        else
	            return false;
	    }
	    if($cf=copy($file,$destfile)){
	        if(!$bak)
	            return(unlink($file));
	        }
	    return($cf);
	}
  

	/**
	 * 功能: 这是下一涵数move的附助函数，功能就是移动目录
	 */
	private function movedir($dir,$destdir,$overwrite=1,$bak=0){
	     @set_time_limit(600);
	    if(!file_exists($destdir))
	        Ext_Filer::notfate_any_mkdir($destdir);
	    if(file_exists($dir)&&(is_dir($dir)))
	        {
	        if(substr($dir,-1)!='/')$dir.='/';
	        if(file_exists($destdir)&&(is_dir($destdir))){
	        if(substr($destdir,-1)!='/')$destdir.='/';
	            $h=opendir($dir);
	            while($file=readdir($h)){
	                if($file=='.'||$file=='..')
	                    {
	                    continue;
	                    $file="";
	                }
	                if(is_dir($dir.$file)){
	                    if(!file_exists($destdir.$file))
	                        Ext_Filer::notfate_mkdir($destdir.$file);
	                    else
	                        chmod($destdir.$file,0777);
	                    Ext_Filer::movedir($dir.$file,$destdir.$file,$overwrite,$bak);
	                    Ext_Filer::delforder($dir.$file);
	                    }
	                else
	                {
	                    if(file_exists($destdir.$file)){
	                        if($overwrite)unlink($destdir.$file);
	                        else{
	                            continue;
	                            $file="";
	                            }
	                    }
	                    if(copy($dir.$file,$destdir.$file))
	                        if(!$bak)
	                            if(file_exists($dir.$file)&&is_file($dir.$file))
	                                @unlink($dir.$file);
	                }
	            }
	        }
	        else
	            return false;
	    }
	    else
	        return false;
	}

	      
	/**
	 * 功能: 移动文件或目录
	 * 参数: $file -- 源文件/目录
	 *       $path -- 目标路径
	 *       $overwrite -- 如是目标路径中已存在该文件时，是否覆盖移动--  默认值是1, 即覆盖
	 *       $bak  -- 是否保留备份(原文件/目录)
	 */
	public function move($file,$path,$overwrite=1,$bak=0)
	     {
	    if(file_exists($file)){
	        if(is_dir($file)){
	            if(substr($file,-1)=='/')$dirname=basename(substr($file,0,strlen($file)-1));
	            else $dirname=basename($file);
	            if(substr($path,-1)!='/')$path.='/';
	            if($file!='.'||$file!='..'||$file!='../'||$file!='./')$path.=$dirname;
	            Ext_Filer::movedir($file,$path,$overwrite,$bak);
	            if(!$bak)Ext_Filer::delForder($file);
	            }
	        else{
	            if(file_exists($path)){
	                if(is_dir($path))chmod($path,0777);
	                else {
	                    if($overwrite)
	                        @unlink($path);
	                    else
	                        return false;
	                }
	            }
	            else
	                Ext_Filer::notfateAnyMkdir($path);
	            if(substr($path,-1)!='/')$path.='/';
	            Ext_Filer::movefile($file,$path.basename($file),$overwrite,$bak);
	        }
	    }
	    else
	        return false;
	}

	/**
	 * 功能: 删除目录,不管该目录下是否有文件或子目录，全部删除哦，小心别删错了哦!
	 * 参数: $file -- 源文件/目录
	 * @param unknown $file
	 * @return boolean
	 */
	public function delForder($file) {
	     chmod($file,0777);
	     if (is_dir($file)) {
	          $handle = opendir($file);
	          while($filename = readdir($handle)) {
	           if ($filename != "." && $filename != "..")
	            {
	                Ext_Filer::delforder($file."/".$filename);
	            }
	          }
	          closedir($handle);
	          return(rmdir($file));
	     }
	     else {
	        unlink($file);
	      }
	}
	
	
	/**
	 * 功能: 创建新目录,这是来自php.net的一段代码.弥补mkdir的不足.
	 * 参数: $dir -- 目录名
	 */
	public function notfateMkdir($dir,$mode=0777){
	    $u=umask(0);
	    $r=mkdir($dir,$mode);
	    umask($u);
	    return $r;
	}

	/**
	 * 功能: 创建新目录,与上面的notfate_mkdir有点不同，因为它多了一个any,即可以创建多级目录
	 *       如:notfate_any_mkdir("abc/abc/abc/abc/abc")
	 */
	public function notfateAnyMkdir($dirs,$mode=0777)
	{
	  if(!strrpos($dirs,'/'))
	    {
	      return(Ext_Filer::notfateMkdir($dirs,$mode));
	  }else
	      {
	      $forder=explode('/',$dirs);
	      $f='';
	      for($n=0;$n<count($forder);$n++)
	          {
	          if($forder[$n]=='') continue;
	          $f.=((($n==0)&&($forder[$n]<>''))?(''):('/')).$forder[$n];
	          if(file_exists($f)){
	              chmod($f,0777);
	              continue;
	              }
	          else
	              {
	              if(Ext_Filer::notfateMkdir($f,$mode)) continue;
	              else
	                  return false;
	          }
	        }
	        return true;
	      }
	}
	
	/**
	 * Goofy 2011-11-30
	* getDir()去文件夹列表，getFile()去对应文件夹下面的文件列表,二者的区别在于判断有没有“.”后缀的文件，其他都一样
	*/
	
	//获取文件目录列表,该方法返回数组
	function getDir($dir) {
		$dirArray[]=NULL;
		if (false != ($handle = opendir ($dir))) {
			$i=0;
			while ( false !== ($file = readdir ($handle)) ) {
				//去掉"“.”、“..”以及带“.xxx”后缀的文件
				if ($file != "." && $file != ".."&&!strpos($file,".")) {
					$dirArray[$i]=$file;
					$i++;
				}
			}
			//关闭句柄
			closedir ($handle);
		}
		return $dirArray;
	}
	
	//获取文件列表
	function getFile($dir) {
		$fileArray[]=NULL;
		if (false != ($handle = opendir ($dir))) {
			$i=0;
			while ( false !== ($file = readdir ($handle)) ) {
				//去掉"“.”、“..”以及带“.xxx”后缀的文件
				if ($file != "." && $file != ".."&&strpos($file,".")) {
					$fileArray[$i]=$file;
					if($i==100){
						break;
					}
					$i++;
				}
			}
			//关闭句柄
			closedir ($handle);
		}
		return $fileArray;
	}
	/**
	 * 文件的下载
	 * $fileUrl：文件所在路径
	 * */
	function fileLoad($fileUrl,$filename=null)
	{
		if(!empty($fileUrl))
		{
			$file = $fileUrl; // 要下载的文件
			if(empty($filename))
			{
				$filename=basename($file);
			}
			$ua = $_SERVER["HTTP_USER_AGENT"];
			$encoded_filename = urlencode($filename);
			$encoded_filename = str_replace("+", "%20", $encoded_filename);
			
			ob_clean();
			header('Pragma: public');
			header('Last-Modified:'.gmdate('D, d M Y H:i:s') . 'GMT');
			header('Cache-Control:no-store, no-cache, must-revalidate');
			header('Cache-Control:pre-check=0, post-check=0, max-age=0');
			header('Content-Transfer-Encoding:binary');
			header('Content-Encoding:none');
			header('Content-type:multipart/form-data');
			//header('Content-Disposition:attachment; filename="'.$filename.'"'); //设置下载的默认文件名
			if (preg_match("/MSIE/", $ua)) {
				header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
			} else if (preg_match("/Firefox/", $ua)) {
				header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
			} else {
				header('Content-Disposition: attachment; filename="' . $filename . '"');
			}
			header('Content-length:'. filesize($file));
			$fp = fopen($file, 'r'); //读取数据，开始下载
			while(connection_status() == 0 && $buf = @fread($fp, 8192)){
				echo $buf;
			}
			fclose($fp);
			@flush();
			@ob_flush();
			exit();
		}
	}

}
?>