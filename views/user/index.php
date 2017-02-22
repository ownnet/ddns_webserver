<?php
$this->title = '用户信息';
?>
<div id="content" class="col-lg-10 col-sm-10">
	<ul class="breadcrumb"><li><a href="/">首页</a></li>
		<li><a href="user">用户信息</a></li>
	</ul>
	
	<div class="article-create">
    	<h1>用户信息</h1>
    	<h3 style="color:red"><?=Yii::$app->session->getFlash('err_msg')?></h3>
    	<h3 style="color:green"><?=Yii::$app->session->getFlash('info_msg')?></h3>
    	<style type="text/css">
    	    img{width:10px;height:10px;}
    	</style>
    	<div class="article-form">
    		<div class="form-group field-article-title required">
	    		<label class="control-label" for="article-title">Token</label>
	    		<input type="text" id="email" class="form-control" name="email" maxlength="255" value="<?=$info['token']?>" disabled>
	    	</div>
	    	<form id="w0" action="user" method="post" enctype="multipart/form-data">
	    	<input type="hidden" name="_csrf" value="<?php echo Yii::$app->getRequest()->getCsrfToken();?>">
	    	<div class="form-group field-article-title required">
	    		<label class="control-label" for="article-title">用户名</label>
	    		<input type="text" id="user" class="form-control" name="user" maxlength="255" value="<?=$info['user']?>" disabled>
	    	</div>
	    	<div class="form-group field-article-title required">
	    		<label class="control-label" for="article-title">邮箱</label>
	    		<input type="text" id="email" class="form-control" name="email" maxlength="255" value="<?=$info['email']?>">
	    	</div>
	    	<div class="form-group field-article-title required">
	    		<label class="control-label" for="article-title">密码</label>
	    		<input type="password" id="password" class="form-control" name="password" maxlength="255">
	    		<div class="help-block">不修改密码时请勿填写</div>
	    	</div>
	    	<div class="form-group field-article-title required">
	    		<label class="control-label" for="article-title">确认密码</label>
	    		<input type="password" id="password2" class="form-control" name="password2" maxlength="255">
	    	</div>
	    	<div class="form-group">
	    		<button type="submit" class="btn btn-success">提交修改</button>
	    	</div>
	    	</form>
    	</div>
    </div>
</div>