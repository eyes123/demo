<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form action="upload-file.php" method="post" enctype="multipart/form-data">
    <label for="file">文件名:</label>
    <input type="file" name="file" id="file" />
    <br />
    <input type="submit" name="submit" value="提交" />
</form>
</body>
</html>