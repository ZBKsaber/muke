<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TP后台管理平台</title>
    <!-- Bootstrap Core CSS -->
    <link href="Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="Public/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="Public/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="Public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="Public/css/sing/common.css" />
    <link rel="stylesheet" href="Public/css/party/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="Public/css/party/uploadify.css">
    <!-- 引入自定义分页样式css -->
    <link rel="stylesheet" type="text/css" href="Public/css/pageStyle.css">

    <!-- jQuery -->
    <script src="/Public/js/jquery.js"></script>
    <script src="/Public/js/bootstrap.min.js"></script>
    <script src="/Public/js/dialog/layer.js"></script>
    <script src="/Public/js/dialog.js"></script>
    <script type="text/javascript" src="/Public/js/party/jquery.uploadify.js"></script>
</head>

<body>
<div id="wrapper">

  <?php
 $navs = D('Menu')->getAdminMenus(); $index = 'index'; ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" >ZBK内容管理平台</a>
    </div>
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user"></i> <?php echo $_SESSION['admin_user']['username'];?><b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>
                  <a href="/admin.php?c=admin&a=personal"><i class="fa fa-fw fa-user"></i> 个人中心</a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="/admin.php?m=admin&c=login&a=loginout"><i class="fa fa-fw fa-power-off"></i> 退出</a>
                </li>
            </ul>
        </li>
    </ul>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav nav_list">
            <li <?php echo (getActive($index)); ?>>
                <a href="admin.php"><i class="fa fa-fw fa-dashboard"></i> 首页</a>
            </li>
            <?php if(is_array($navs)): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><li <?php echo (getActive($nav["c"])); ?>>
                    <a href="<?php echo (getAdminMenuUrl($nav)); ?>"><i class="fa fa-fw fa-bar-chart-o"></i><?php echo ($nav["name"]); ?></a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</nav>

  <div id="page-wrapper">

    <div class="container-fluid" >

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">

          <ol class="breadcrumb">
            <li>
              <i class="fa fa-dashboard"></i>  <a href="/admin.php?c=content">文章管理</a>
            </li>
            <li class="active">
              <i class="fa fa-table"></i>文章列表
            </li>
          </ol>
        </div>
      </div>
      <!-- /.row -->
      <div style="margin-bottom:10px;">
        <button  id="button-add" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>添加文章
        </button>
      </div>
      <div class="row">
        <form action="/admin.php" method="get">
          <div class="col-md-4">
            <div class="input-group">
              <span class="input-group-addon">栏目</span>
              <select class="form-control" name="catid">
                <option value='' >全部分类</option>
                <?php if(is_array($webSiteMenu)): foreach($webSiteMenu as $key=>$sitenav): ?><option value="<?php echo ($sitenav["menu_id"]); ?>" <?php if($sitenav["menu_id"] == $catid): ?>selected="selected"<?php endif; ?>><?php echo ($sitenav["name"]); ?></option><?php endforeach; endif; ?>
              </select>
            </div>
          </div>
          <input type="hidden" name="c" value="content"/>
          <input type="hidden" name="a" value="index"/>
          <div class="col-md-4">
            <div class="input-group">
              <input class="form-control" name="title" type="text" value="<?php echo ($title); ?>" placeholder="文章标题" />
                <span class="input-group-btn">
                  <button id="sub_data" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
                </span>
            </div>
          </div>
        </form>
      </div>
      <div class="row">
        <div class="col-lg-8">
          <h3></h3>
          <div class="table-responsive">
            <form id="singcms-listorder">
              <table class="table table-bordered table-hover singcms-table">
                <thead>
                <tr>
                  <th id="singcms-checkbox-all" width="10"><input type="checkbox"/></th>
                  <th width="14">排序</th>
                  <th>id</th>
                  <th>标题</th>
                  <th>栏目</th>
                  <th>来源</th>
                  <th>封面图</th>
                  <th>时间</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($news)): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$new): $mod = ($i % 2 );++$i;?><tr>
                    <td><input type="checkbox" name="pushcheck" value="<?php echo ($new["news_id"]); ?>"></td>
                    <td><input size=4 type='text' name='listorder[<?php echo ($new["news_id"]); ?>]' value="<?php echo ($new["listorder"]); ?>"/></td>
                    <td><?php echo ($new["news_id"]); ?></td>
                    <td><a target="_blank" href="/index.php?c=detail&a=view&id=<?php echo ($new["news_id"]); ?>"><?php echo ($new["title"]); ?></a></td>
                    <td><?php echo (getCatName($webSiteMenu,$new["catid"])); ?></td>
                    <td><?php echo (getCopyFromById($new["copyfrom"])); ?></td>
                    <td>
                        <?php echo (isThumb($new["thumb"])); ?>
                    </td>
                    <td><?php echo (date("Y-m-d H:i:s",$new["create_time"])); ?></td>
                    <td>
                        <span  attr-status="<?php if($new['status'] == 1): ?>0<?php else: ?>1<?php endif; ?>"  attr-id="<?php echo ($new["news_id"]); ?>" class="sing_cursor singcms-on-off" id="singcms-on-off" ><?php echo (status($new["status"])); ?></span>
                    </td>
                    <td>
                        <span class="sing_cursor glyphicon glyphicon-edit" aria-hidden="true" id="singcms-edit" attr-id="<?php echo ($new["news_id"]); ?>"></span>
                        <a href="javascript:void(0)" id="singcms-delete"  attr-id="<?php echo ($new["news_id"]); ?>"  attr-message="删除">
                            <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                        </a>
                        <a target="_blank" href="/index.php?c=detail&a=view&id=<?php echo ($new["news_id"]); ?>" class="sing_cursor glyphicon glyphicon-eye-open" aria-hidden="true"  ></a>
                    </td>
                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
              </table>
            </form>
            <div class="input-group col-md-4">
                <select style="width:auto;" class="form-control" name="position_id" id="select_push">
                    <option value="0">请选择推荐位</option>
                    <?php if(is_array($positions)): foreach($positions as $key=>$position): ?><option value="<?php echo ($position["id"]); ?>"><?php echo ($position["name"]); ?></option><?php endforeach; endif; ?>
                </select>
                <button type="button" id="singcms_push" class="btn btn-primary">推送</button>
            </div>
            <div style="margin-top:10px;">
              <button id="button-listorder" type="button" class="btn btn-primary dropdown-toggle"><span class="glyphicon glyphicon glyphicon-resize-vertical" aria-hidden="true"></span>更新排序 </button>
            </div>
            <nav class="text-center">
                <ul class="pagination">
                    <?php echo ($pageres); ?>
                </ul>
            </nav>
          </div>
        </div>

      </div>
      <!-- /.row -->



    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<script>
  var SCOPE = {
    'edit_url' : '/admin.php?c=content&a=edit',
    'add_url' : '/admin.php?c=content&a=add',
    'set_status_url' : '/admin.php?c=content&a=setStatus',
    'sing_news_view_url' : '/index.php?c=view',
    'listorder_url' : '/admin.php?c=content&a=listorder',
    'push_url' : '/admin.php?c=content&a=push',
  }
</script>
        <script src="/Public/js/admin/common.js"></script>
    </body>
</html>