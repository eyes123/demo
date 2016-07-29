<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>品牌表操作</title>
    
<link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />

<link rel="stylesheet" type="text/css" href="/demo/Public/Css/tab.css" />
<link rel="stylesheet" type="text/css" href="/demo/Public/Css/addAdvertisement.css" />

<link rel="stylesheet" type="text/css" href="/demo/Public/Js/diashow/skins/css/diashow.css" />
<script type="text/javascript" src="/demo/Public/Js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/demo/Public/Js/diashow/diashow.js"></script>
<script type="text/javascript">

	var module = "/demo/index.php?s=/Home";
	$(document).ready(function()
	{
		//alert(1);
		var message = '<?php echo ($message); ?>';
		if(message!='')
		{
			showMessage('<?php echo ($message); ?>','<?php echo ($url); ?>','<?php echo ($time); ?>');
		}
	});
</script> 

    <script type="text/javascript" src="/demo/Public/Js/Jquery.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/common.js"></script>
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/common.css" />
    <link rel="stylesheet" type="text/css" href="/demo/Public/Css/category.css" />
    <link rel="stylesheet" type="text/css" href="/demo/Public/Js/diashow/skins/css/diashow.css" />
    <script type="text/javascript" src="/demo/Public/Js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="/demo/Public/Js/diashow/diashow.js"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            var message = '<?php echo ($message); ?>';
            if(message!='')
            {
                showMessage('<?php echo ($message); ?>','<?php echo ($url); ?>','<?php echo ($time); ?>');
            }
        });
    </script>
</head>
<body>
<div class="form_div">
    <form action=""  enctype="multipart/form-data" method="post" name="form1">
            <div class="line">
                <div class="input_left">手机图片：</div>
                <div class="input_right file_field">
                    <div class="fileInputContainer">
                        <input class="fileInput" type="file" name="shouji_url_file" id="shouji_url" onchange="newImgUploadShouji(this.form,this)"/>
                        <input type="hidden" name="shouji_url" value="<?php echo ($ad["shouji_url"]); ?>"/>
                    </div>
                    <div class="shouji_url_displayphoto">
                        <?php if(!empty($shouji_url_pics)): if(is_array($shouji_url_pics)): foreach($shouji_url_pics as $k=>$pic): ?><div id="shouji_url_Img<?php echo ($k+1); ?>" style="position:relative" class="upload_img_item" >
                                    <img width="100px" height="100px" src="<?php echo ($pic_dir); echo ($pic); ?>"  alt="缩略图片" />
                                </div><?php endforeach; endif; endif; ?>
                    </div>
                </div>
            </div>
            <div class="line">
                <div class="input_left">图片：</div>

                <div class="input_right file_field">
                    <div class="fileInputContainer">
                        <input class="fileInput" type="file" name="picture_url_file" id="picture_url" onchange="newImgUpload(this.form,this)"/>
                        <input type="hidden" name="picture_url" value="<?php echo ($ad["picture_url"]); ?>"/>
                    </div>
                    <div class="picture_url_displayphoto">
                        <?php if(!empty($picture_url_pics)): if(is_array($picture_url_pics)): foreach($picture_url_pics as $k=>$pic): ?><div id="picture_url_Img<?php echo ($k+1); ?>" style="position:relative" class="upload_img_item" >
                                    <img width="100px" height="100px" src="<?php echo ($pic_dir); echo ($pic); ?>"  alt="图片" />
                                    <a class="delete_btn" title="删除" onclick="newDeleteImg('picture_url','<?php echo ($k+1); ?>')" style="position: absolute; top: 0px; right: 0px; display: none;" target="uploadframe">
                                        <img alt="删除" src="/demo/Public/images/icon_del.gif">
                                     </a>
                                </div><?php endforeach; endif; endif; ?>
                    </div>
                </div>
            </div>
        <div class="line">
            <input type="submit"  value="提交" class="button" onclick="return submit2(this.form)"/>
            <input type="reset" name="reset" value="重置" class="button"/>
        </div>
    </form>
</div>
<iframe name="uploadframe" style="display:none;width:0px;height:0px;" ></iframe>
<script type="text/javascript">

    function newDeleteImg(pre,id)
    {
        form1.target  = "uploadframe";
        form1.action = "/demo/Home/Project/newDeleteImg?id="+id+"&pre="+pre;
        form1.submit();

    }
    function newImgUpload(form,btn)
    {
        form.target  = "uploadframe";
        form.action = "/demo/Home/Project/newUploadImgAjax?one=n&pre="+btn.id;
        form.submit();
    }
    function newImgUploadShouji(form,btn)
    {
        form.target  = "uploadframe";
        form.action = "/demo/Home/Project/newUploadImgAjax?one=y&pre="+btn.id;
        form.submit();
    }
    function submit2(form) {
        form.target = "";
        form.action = "";
        form.submit();
    }
</script>
</body>
</html>