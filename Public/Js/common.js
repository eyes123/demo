//function showMessage(title,mContent)
//{
//	
////	alert(mContent);
//	if(mContent!='')
//	{
//		art.dialog({			
//			title: title,
//			content: mContent,
//			time:3000
//			});	
//	}
//}
//返回json数组
function getArrayByJson(json) {
	var obj = new Function("return " + json)();
	return obj;
}
function mypost(postUrl)
{
	//alert(postUrl);
	$.post(postUrl,function(data){
		//alert(data);
		var mydata = getArrayByJson(data).data;
		
		if(mydata.type=='alert')
		{
			alert(mydata.data);
		}
		else if(mydata.type=='eval')
		{
			eval(mydata.data);
		}
		else if(mydata.type=='refresh')
		{
			history.go(0);
		}
	});
}
/**
* 将数值转化为正整数形式
*
* @param btn input
*/
function valueIntCurrency(btn,moren) {

	var n = parseInt(btn.value);
	if(n<0 || n == 'NaN' || !n)
	{
		if(!moren)
		{
			n = 0;
		}
		else
		{
			n = moren;
		}
	}
	btn.value = n;
}

/**
 * 将数值四舍五入(保留2位小数)
 * @param {Object} x
 */
function changeTwoDecimal_f(x) {
	//alert(x);
    var f_x = parseFloat(x);
    if (isNaN(f_x)) {
        //alert('function:changeTwoDecimal->parameter error');
        return false;
    }
    var f_x = Math.round(x * 100) / 100;
    var s_x = f_x.toString();
    var pos_decimal = s_x.indexOf('.');
    if (pos_decimal < 0) {
        pos_decimal = s_x.length;
        s_x += '.';
    }
    while (s_x.length <= pos_decimal + 2) {
        s_x += '0';
    }
    return s_x;
}
/**
* 将数值四舍五入(保留2位小数)后格式化成金额形式
*
* @param num 数值(Number或者String)
* @return 金额格式的字符串,如'1,234,567.45'
* @type String
*/
function valueFormatCurrency(e) {
	e.value = formatCurrency(e.value);
}

/**
* 将数值四舍五入(保留2位小数)后格式化成金额形式
*
* @param num 数值(Number或者String)
* @return 金额格式的字符串,如'1,234,567.45'
* @type String
*/
function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + ',' +
    num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num + '.' + cents);
}

/* 
数字判断函数，返回true表示是全部数字，返回false表示不全部是数字 
*/
function isNumber(str) {
	if ("" == str) {
		return false;
	}
	var reg = /\D/;
	return str.match(reg) == null;
}

function valueIntCurrency1(e)
{
//	alert(1);
	if(isNumber(e.value)==false)
	{
		e.value ="";
	}
}

/* 
正double类型 
*/
function isZDouble(str) {
	if ("" == str) {
		return false;
	}
	var reg = /^\d{1,9}$|^\d{1,9}[.]\d{1,2}$/;
	return str.match(reg) == null;
}