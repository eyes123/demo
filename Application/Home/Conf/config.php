<?php
return array(
    'URL_ROUTER_ON'		=>	true,
    'pic_dir'     => '/Public/Upload/Img/',
    'web_root'    => 'http://192.168.21.30/demo',
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

//    'DB_PARAMS'  => array(),//数据库连接参数
//    'DB_DEBUG'    =>TURE,//数据库调用模式,开启之后可以记录sql日志
//    'DB_FIELDS_CACHE'    => ture,//启动字段缓存
//    'DB_CHARSET'          =>   'utf8',//数据库编码默认采用utf8
//    'DB_DEPLOY_TYPE'     =>  0,//数据库部署方式:0 集中式(单一服务器)1,分布式(主从服务器)
//    'DB_RW_SEPARATE'    => false,//数据库读写是否分离 主从式有效
//    'DB_MASTER_NUM'      =>  1,//读写分离之后,祝福器数量

);