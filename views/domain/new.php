<?php
$this->title = 'Add New Domain';
?>

<div id="content" class="col-lg-10 col-sm-10">
	<ul class="breadcrumb"><li><a href="/">Home</a></li>
		<li><a href="domain">Domain</a></li>
	</ul>
	
	<div class="article-create">
    	<h1>创建新域名</h1>
    	<h3 style="color:red"><?=Yii::$app->session->getFlash('err_msg')?></h3>
    	<h3 style="color:green"><?=Yii::$app->session->getFlash('info_msg')?></h3>
    	<style type="text/css">
    	    img{width:10px;height:10px;}
    	</style>
    	<div class="article-form">
            <form id="w0" name="w0" action="domain/new" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_csrf" value="<?php echo Yii::$app->getRequest()->getCsrfToken();?>">
                <div class="form-group field-article-title required">
                    <label class="control-label" for="article-title">主机记录</label>
                    <input type="text" id="name" class="form-control" name="host" maxlength="255" value="" placeholder="example.com">
                    
                    <label class="control-label" for="article-title">记录类型</label>
                    <select name="type" class="ui-select">
						<option value="A" selected>A</option>
						<option value="CNAME">CNAME</option>
						<option value="MX">MX</option>
						<option value="NS">NS</option>
						<option value="TXT">TXT</option>
						<option value="AAAA">AAAA</option>
						<option value="SRV">SRV</option>
						<option value="REDIRECT_URL">显性URL</option>
						<option value="FORWARD_URL">隐性URL</option>
					</select>
					<br />
					<label class="control-label" for="article-title">记录值(若用于DDNS服务直接留空或任意填写)</label>
                    <input type="text" id="brief" class="form-control" name="value" maxlength="255" value="">
                    <label class="control-label" for="article-title">TTL(秒)</label>
                    <input type="text" id="brief" class="form-control" name="ttl" maxlength="10" value="1800">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success"><?=Yii::t('app', '提交');?></button>
                </div>
            </form>
        </div>
    </div>
</div>
