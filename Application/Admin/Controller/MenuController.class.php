<?php
/**
 * 后台菜单管理相关
 */
namespace Admin\Controller;
use Think\Controller;
class MenuController extends CommonController {

    public function index(){
        $data = array();
        // 接收前端传递过来的搜索框的值
        if(isset($_REQUEST['type']) && in_array($_REQUEST['type'], array('0','1'))){
            $data['type'] = intval($_REQUEST['type']);
            $this -> assign('type',$data['type']);
        }else{
            $this -> assign('type', -1);
        }
        /**
         * 分页操作逻辑
         */
         // 获取要当前页
         $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
         $pageSize = $_REQUEST['pageSize'] ? $_REQUEST['pageSize'] : 3;
         // 获取数据
         $menus = D('Menu') -> getMenus($data,$page,$pageSize);
         // 获取数据总条数
         $menusCount = D('Menu') -> getMenusCount($data);

         // 调用tp框架自带的分页类
         $res = new \Think\Page($menusCount,$pageSize);
         $pageRes = $res -> show();
        //  dump($menus);exit;
         $this -> assign('pageRes',$pageRes);
         $this -> assign('menus',$menus);
    	 $this->display();
    }

    public function add() {
        if($_POST){
            // 判断非空字段
            if(!isset($_POST['name']) || !$_POST['name']){
                return show(0,'菜单名不能为空');
            }
            if(!isset($_POST['m']) || !$_POST['m']){
                return show(0,'模块名不能为空');
            }
            if(!isset($_POST['c']) || !$_POST['c']){
                return show(0,'控制器不能为空');
            }
            if(!isset($_POST['f']) || !$_POST['f']){
                return show(0,'方法名不能为空');
            }
            // 一个是添加数据,一个是更新数据
            if($_POST['menu_id']){
                return $this -> save($_POST);
            }
            $menuId = D('Menu') -> insert($_POST);
            if($menuId){
                return show(1,'添加成功',$menuId);
            }
            return show(0,'添加失败',$menuId);
        }else{
            $this -> display();
        }
    }
    // 修改菜单 仅仅是显示表单
    public function edit(){
        $menuId = $_GET['id'];
        $menu = D('Menu') -> find($menuId);
        $this -> assign('menu',$menu);
        $this -> display();
    }

    public function save($data){
        $menuId = $data['menu_id'];
        unset($data['menu_id']);
        try {
            $id = D('Menu') -> updateMenuById($menuId,$data);
            if($id === false){
                return show(0,'更新失败');
            }
            return show(1,'更新成功');
        } catch (Exception $e) {
            return show(0,$e->getMessage());
        }
    }

    /**
     * js ajax提交的删除数据的操作
     */
    public function setStatus(){
        // 获取要修改的数据的id
        try {
            if($_POST){
                $id = $_POST['id'];
                $status = $_POST['status'];
                // 执行数据更新操作
                $res = D('Menu')->updateStatusById($id,$status);
                if($res){
                    return show(1,'操作成功');
                }else{
                    return show(0,'操作失败');
                }
            }
        } catch (Exception $e) {
            return show(0,$e->getMessage());
        }

        return show(0,'没有提交数据');
    }

    public function listorder(){
        $listorder = $_POST['listorder'];
        $jumpUrl = $_SERVER['HTTP_REFERER'];
        $errors = array();
        if($listorder){
            try {
                foreach($listorder as $menuId => $v){
                    //执行更新
                    $id = D('Menu') -> updateMenuListorderById($menuId,$v);
                    if($id === false){
                        $errors[] = $menuId;
                    }
                }
            } catch (Exception $e) {
                return show(0,$e->getMessage(),array('jump_url'=>$jumpUrl));
            }
            if($errors){
                return show(0,'排序失败-'.implode(',',$errors),array('jump_url'=>$jumpUrl));
            }
            return show(1,'排序成功',array('jump_url'=>$jumpUrl));
        }
        return show(0,'排序数据错误',array('jump_url'=>$jumpUrl));
    }
}
