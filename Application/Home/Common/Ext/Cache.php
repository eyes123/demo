<?php
/******************************************************************
*
##  Project:SKPHP,A concise and easy framework for PHP
##  Copyright: 2012 All rights reserved
##  version: 0.0.1
##  Author: Sun Kid <hujw@bronco1.com>
*
##  File: Cache.php (SKFrame_Ext_Cache)
*
******************************************************************/
class SKFrame_Ext_Cache
{
     //数组转换成字串
    private function arrayeval($array, $level = 0) {
	    $space = '';
	    for($i = 0; $i <= $level; $i++) {
		    $space .= "\t";
	    }
	    $evaluate = "Array\n$space(\n";
	    $comma = $space;
	    foreach($array as $key => $val) {
		    $key = is_string($key) ? '\''.addcslashes($key, '\'\\').'\'' : $key;
		    $val = !is_array($val) && (!preg_match("/^\-?\d+$/", $val) || strlen($val) > 12 || substr($val, 0, 1)=='0') ? '\''.addcslashes($val, '\'\\').'\'' : $val;
		    if(is_array($val)) {
			    $evaluate .= "$comma$key => ".$this->arrayeval($val, $level + 1);
		    } else {
			    $evaluate .= "$comma$key => $val";
		    }
		    $comma = ",\n$space";
	    }
	    $evaluate .= "\n$space)";
	    return $evaluate;
    }
    
    //写入文件
    private function swritefile($filename, $writetext, $openmod='w') {
        if(@$fp = fopen($filename, $openmod)) {
            flock($fp, 2);
            fwrite($fp, $writetext);
            fclose($fp);
            return true;
        } else {
            new SKFrame_App_Error("File: $filename write error.");
            return false;
        }
    }

    //写入
    function cache_write($name, $var, $values) {
	    $cachefile = SitePath.'/C/App/data/'.$name.'.php';
	    $cachetext = "<?php\r\n".
            "/******************************************************************\r\n".
            "*\r\n".
            "##  Project:SKPHP,A concise and easy framework for PHP\r\n".
            "##  Copyright: 2012 All rights reserved\r\n".
            "##  version: 0.0.1\r\n".
            "##  Author: Sun Kid <hujw@bronco1.com>\r\n".
            "*\r\n".
            "##  File: $name.php \r\n".
            "*\r\n".
            "******************************************************************/\r\n".
		    '$GLOBALS[\''.$var.'\']='.$this->arrayeval($values).
		    "\r\n?>";
	    if(!$this->swritefile($cachefile, $cachetext)) {
		    exit("File: $cachefile write error.");
	    }
    }
}
?>