<?php
return array(
    'URL_ROUTER_ON'		=>	true,
    //路由定义
    'URL_ROUTE_RULES'	=> 	array(
        'blog/:year\d/:month\d'	=>	'Home/Route/archive', //规则路由
        'blog/:id\d'			=>	'Home/Route/read', //规则路由
        'blog/:cate'			=>	'Home/Route/category', //规则路由
    ),
    'URL_MODEL'		=>	3, // 如果你的环境不支持PATHINFO 请设置为3
    'DB_TYPE'		=>	'mysql',
    'DB_HOST'		=>	'localhost',
    'DB_NAME'		=>	'db_wxmbht',
    'DB_USER'		=>	'root',
    'DB_PWD'		=>	'miaoli',
    'DB_PORT'		=>	'3306',
    'DB_PREFIX'		=>	'think_',
    'pageCount'   => 20,
    'SESSION_AUTO_START' => true,
    'SESSION_EXPIRE'=> 900,
    'TMPL_CACHE_ON' => true,
    'HTML_CACHE_ON'=>true,
    'SystemRole'	=> 'adminUser',

);