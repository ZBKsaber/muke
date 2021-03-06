<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

/**
 * basic基本配置
 */
class BasicController extends CommonController{

    public function index(){
        $res = D('Basic')->select();
        $this -> assign('vo',$res);
        $this -> display();
    }

    public function add(){
        if ($_POST) {
            if (!$_POST['title'] && !isset($_POST['title'])) {
                return show(0,'站点标题不能为空');
            }
            if (!$_POST['keywords'] && !isset($_POST['keywords'])) {
                return show(0,'站点关键词不能为空');
            }
            if (!$_POST['description'] && !isset($_POST['description'])) {
                return show(0,'站点描述不能为空');
            }
            D('Basic')->save($_POST);
            return show(1,'配置成功');
        }else{
            return show(0,'没有提交的数据');
        }
    }
}
