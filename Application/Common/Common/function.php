<?php

/**
 * 公用的方法
 */
 function show($status,$message,$data=array()){
     $result = array(
         'status' => $status,
         'message' => $message,
         'data' => $data,
     );
     exit(json_encode($result));
 }

 function getMd5Password($password){
     return md5($password.C('MD5_PRE'));
 }

 function getMenuType($type){
     return $type == 1 ? '后端菜单' : '前端导航';
 }

 function status($s){
     if($s == 0){
         $str = '关闭';
     }elseif($s == 1){
         $str = '正常';
     }elseif($s == -1){
         $str = '删除';
     }
     return $str;
 }
 function getAdminMenuUrl($nav){
     $url = '/admin.php?c='.$nav['c'].'&a='.$nav.['a'];
     if($nav['f'] == 'index'){
         $url = '/admin.php?c='.$nav['c'];
     }
     return $url;
 }

 function getActive($navc){
     $c = strtolower(CONTROLLER_NAME);
     if(strtolower($navc) == $c){
         return 'class="active"';
     }
     return '';
 }

 function showKind($status,$data){
     header('Content-type:application/json;charset=UTF-8');
     if($status == 0){
         exit(json_encode(array('error'=>0,'url'=>$data)));
     }
     exit(json_encode(array('error'=>1,'message'=>'上传失败')));
 }
// 获取栏目名称
 function getCatName($navs,$id){
     foreach ($navs as $nav) {
         $navList[$nav['menu_id']] = $nav['name'];
     }
     return isset($navList[$id]) ? $navList[$id] : '';
 }
// 获取来源名称
function getCopyFromById($id){
    $copyFrom = C('COPY_FROM');
    return $copyFrom[$id] ? $copyFrom[$id] : '';
}

// 查看是否有缩略图
function isThumb($thumb){
    if ($thumb) {
        return '<span style="color:green">有</span>';
    }
    return '无';
}

 // 获取当前登录管理员的函数
 function getLoginUsername(){
     return $_SESSION['adminUser']['username'] ? $_SESSION['adminUser']['username'] : '';
 }