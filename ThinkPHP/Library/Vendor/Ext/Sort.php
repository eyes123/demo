<?php
/*
 +---------------------------------------------------------------+
| 名称: Ext/Sort.cs
| 版权：烟台一心信息技术有限公司
| 作者：David<kdage@163.com>
| 日期：2014-03-11
| 描述：Sort管理的操作
+---------------------------------------------------------------+
*/
class Ext_Sort
{

	/**
	 * 将一个二维数组按照多个列进行排序，类似 SQL 语句中的 ORDER BY
	 *
	 * 用法：
	 * @code php
	 * $rows = Ext_Sort::sortByMultiCols($rows, array(
	 *           'parent' => SORT_ASC,
	 *           'name' => SORT_DESC,
	 * ));
	 * @endcode
	 *
	 * @param array $rowset 要排序的数组
	 * @param array $args 排序的键
	 *
	 * @return array 排序后的数组
	 */
	static function sortByMultiCols($rowset, $args)
	{
		$sortArray = array();
		$sortRule = '';
		foreach ($args as $sortField => $sortDir)
		{
			foreach ($rowset as $offset => $row)
			{
				$sortArray[$sortField][$offset] = $row[$sortField];
			}
			$sortRule .= '$sortArray[\'' . $sortField . '\'], ' . $sortDir . ', ';
		}
		if (empty($sortArray) || empty($sortRule)) 
		{ 
			return $rowset; 
		}
		eval('array_multisort(' . $sortRule . '$rowset);');
		
		return $rowset;
	}
}