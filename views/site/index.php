<?php
$this->title = 'My Yii Application';
?>

<div id="content" class="col-lg-10 col-sm-12">
	<ul class="breadcrumb">
		<li><a href="/">首页</a></li>
		<li><a href="user">站点配置</a></li>
	</ul>

	<div class="box col-md-12">
		<div class="box-inner">
			<div class="box-header well" data-original-title="">
				<h2>
					<i class="glyphicon glyphicon-user"></i> Responsive, Swipable Table
				</h2>
				<div class="box-icon">
					<a href="#" class="btn btn-minimize btn-round btn-default"><i
						class="glyphicon glyphicon-chevron-up"></i></a> <a href="#"
						class="btn btn-close btn-round btn-default"><i
						class="glyphicon glyphicon-remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<form id="w0" action="site" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_csrf" value="<?php echo Yii::$app->getRequest()->getCsrfToken();?>">
					<table class="table table-striped table-bordered responsive">
						<thead>
							<tr>
								<th>项目</th>
								<th>值</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>开放注册</td>
								<td class="center"><input name="open_register" data-no-uniform="true" type="checkbox" class="iphone-toggle" <?=$config['open_register']?'checked':''?>></td>
							</tr>
							<tr>
								<td>邀请码注册</td>
								<td class="center"><input name="invitation_allow"  data-no-uniform="true" type="checkbox" class="iphone-toggle" <?=$config['invitation_allow']?'checked':''?>></td>
							</tr>
							<tr>
								<td>语言</td>
								<td class="center">
								<select style="height: 2em" name = "default_language" class="ui-select">
									<option value="zh-CN" <?=($config['default_language'] == 'zh-CN')?'selected':''?>>简体中文</option>
									<option value="en-US" <?=($config['default_language'] == 'en-US')?'selected':''?>>English</option>
								</select>
								</td>
							</tr>
							<tr>
								<td>管理员邮箱</td>
								<td class="center"><input type="text" id="admin_email" class="form-control" name="admin_email" maxlength="255" value="<?=$config['admin_email']?>"></td>
							</tr>
						</tbody>
					</table>
					<div class="form-group">
	    				<button type="submit" class="btn btn-success">提交修改</button>
	    			</div>
				</form>
			</div>
		</div>
	</div>

</div>