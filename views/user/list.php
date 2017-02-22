<?php
$this->title = '用户列表';
?>
<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">用户列表</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-user"></i> Datatable + Responsive</h2>

        <div class="box-icon">
            <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
            <a href="#" class="btn btn-minimize btn-round btn-default"><i
                    class="glyphicon glyphicon-chevron-up"></i></a>
            <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
    </div>
    <div class="box-content">
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Last Auth Time</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
<?php foreach ($user as $item):?>
    <tr>
        <td><?=$item['user']?></td>
        <td class="center"><?=$item['email']?></td>
        <td class="center"><?=$item['lastauth']?date("Y-m-d H:i:s",$item['lastauth']):'Never'?></td>
        <td class="center">
            <?php if($item['status'] == '1'){?>
            <span class="label-success label label-default">Normal</span>
            <?php }else{?>
            <span class="label-warning label label-warning">Ban</span>
            <?php }?>
        </td>
        <td class="center">
            <a class="btn btn-info" href="<?=Yii::$app->getUrlManager()->createUrl('user/edit/'.$item['id'])?>">
                <i class="glyphicon glyphicon-edit icon-white"></i>
                Edit
            </a>
            <a class="btn btn-danger" href="<?=Yii::$app->getUrlManager()->createUrl('user/del/'.$item['id'])?>">
                <i class="glyphicon glyphicon-trash icon-white"></i>
                Delete
            </a>
        </td>
    </tr>
<?php endforeach;?>
    </tbody>
    </table>
    </div>
    </div>
    </div>
</div>