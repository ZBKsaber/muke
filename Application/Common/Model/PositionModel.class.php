<?php

namespace Common\Model;
use Think\Model;

class PositionModel extends Model{
    private $_db = '';
    public function __construct(){
        $this -> _db = M('Position');
    }

    /**
     * 获取状态为正常的推荐位栏目
     */
     public function getNormalPositions(){
         $conditions = array('status'=>1);
         $list = $this -> _db -> where($conditions) -> field('id,name') -> order('id desc') -> select();
         return $list;
     }

     /**
      * 根据id获取内容
      */
      public function find($id){
          if (!$id || !is_numeric($id)) {
             return array();
          }
          $data = $this -> _db -> field('id,name,description')-> where('id='.$id)->find();
          return $data;
      }
      /**
       * 根据id更改推荐位栏目
       */
       public function updatePositionById($id,$data){
           if(!$id || !is_numeric($id)){
               throw_exception('ID不合法');
           }
           if(!$data || !is_array($data)){
               throw_exception('更新的数据不合法');
           }
           return $this -> _db -> where('id='.$id) -> save($data);
       }

       public function updateStatusById($id,$status){
           if(!is_numeric($id) || !$id){
               throw_exception('ID不合法');
           }
           if(!is_numeric($status) || !$status){
               throw_exception('状态不合法');
           }

           $data['status'] = $status;
           return $this->_db->where('id='.$id)->save($data);
       }
       /**
        * 获取推荐位栏目的数量
        */
        public function getPositionCount($data=array()){
            $conditions = $data;
            // if(isset($data['title']) && $data['title']){
            //     $conditions['title'] = array('like','%'.$data['title'].'%');
            // }
            // if(isset($data['catid']) && $data['catid']){
            //     $conditions['catid'] = intval($data['catid']);
            // }
            return $this -> _db -> where($conditions) -> count('id');
        }
}
