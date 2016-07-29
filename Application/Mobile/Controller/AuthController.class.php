<?php

class AuthController extends BaseController
{
    public function __construct() {
        parent::__construct();
    }

    //订单列表
    public function user() {
        var_dump($_REQUEST);
    }

}