<?php
class BaseController extends Controller
{
	public function __construct(){
		parent::__construct();
        import("Org.SessionManage");
        import("Org.Page");
    }

    function  sepePage($count,$param,$pageCount=0)
    {
        import('Org.Page');
        if($pageCount==0)
        {
            $pageCount = C('pageCount');
        }
        $page      = new Page((int)$count,$pageCount,$param);
        $nowPage   = isset($_GET['p'])?$_GET['p']:1;
        $limit     = $nowPage.','.$page->listRows;
        $this->pageCount = $pageCount;
        $this->currentPage = $nowPage;
        $this->page = $page->show();

        return $limit;
    }






}

?>