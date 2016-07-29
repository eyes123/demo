<?php
class Ext_CsvExcel
{
	/**
	 * csv数据获取
	 */
	public static function getCsvData($filename)
	{
		setlocale(LC_ALL, 'zh_CN');//配置地域信息
		$handle = fopen($filename,"r");
//		 		$file_encoding = mb_detect_encoding($handle);
//
//		 		if ($file_encoding != 'ASCII'){
//		 			echo "<script type=\"text/javascript\">alert(\"文件编码错误,请重新上传!\"); </script>";
//		 			exit;
//		 		}
		 		//----------读取文件信息开始--------------
		$row = 0;
		$fileinfo=array();
		while ($rows = fgetcsv($handle,null,','))
		{
			//echo "<font color=red>$row</font>"; //可以知道总共有多少行
			$row++;
			$num = count($rows);
			// 这里会依次输出每行当中每个单元格的数据
			for ($i=0; $i<$num; $i++)
			{
				$value = mb_convert_encoding($rows[$i], "UTF-8", "GBK");//编码转换；
				$rows[$i] = $value;
				// 在这里对数据进行处理
			}
			if(!empty($rows))
			{
				$fileinfo[]=$rows;
			}
		}
		fclose($handle);
		return $fileinfo;
	}

	/**
	 * 输出CSV的头信息
	 * 注：使用此函数前后都不应有任何数据输出
	 * @param $data Array 下载的数据
	 * @param $file_name String 下载的文件名
	 */
	public static function outputCsvHeader($data, $fileName = 'export')
	{
		$pos = strrpos($fileName, '.csv');
	
		if($pos!==0)
		{
			$fileName = $fileName.".csv";
		}
		ob_end_clean();
		header('Content-Type: text/csv');
		// 		$str = mb_convert_encoding($file_name, 'gbk', 'utf-8');
		// 		header('Content-Disposition: attachment;filename="' .$str . '.csv"');
		$ua = $_SERVER["HTTP_USER_AGENT"];
		$encodedFileName = urlencode($fileName);
		$encodedFileName = str_replace("+", "%20", $encodedFileName);
	
		header("Content-type:application/vnd.ms-excel");
		if (preg_match("/MSIE/", $ua))
		{
			header('Content-Disposition: attachment; filename="' . $encodedFileName . '"');
		}
		else if (preg_match("/Firefox/", $ua))
		{
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $fileName . '"');
		}
		else
		{
			header('Content-Disposition: attachment; filename="' . $fileName . '"');
		}
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
        header ( 'Content-Type: application/vnd.ms-excel' );
        header ( 'Content-Disposition: attachment;filename='.$fileName );
        header ( 'Cache-Control: max-age=0' );
		$csv_data = '';
		foreach ($data as $line)
		{
			foreach ($line as $key => &$item)
			{
				$item = str_replace (',','，',str_replace(PHP_EOL,'',$item));   //过滤生成csv文件中的(,)逗号和换行
				$item = mb_convert_encoding($item, 'gbk', 'utf-8');
			}
			$csv_data .= implode(',', $line) . PHP_EOL;
		}
		echo $csv_data;
	}
}