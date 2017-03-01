<?php 
	$this->title = 'Login';
?>
<link href="css/chosen.min.css" rel="stylesheet">
<link href="css/charisma-app.css" rel="stylesheet">
<div class="ch-container">
    <div class="row">
        
<!--     <div class="row">
        <div class="col-md-12 center login-header">
            <h2>Welcome to Charisma</h2>
        </div>
    </div>
-->

    <div class="row">
        <div class="well col-md-5 center login-box">
            <div class="alert alert-info">
                Please login with your Username and Password.
            </div>
            <form id="login" class="form-horizontal" action="user/dologin" method="post" >
            <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input id="username" name="username" type="text" class="form-control" placeholder="Username">
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="clearfix"></div>

                    <div class="input-prepend">
                        <label class="remember" for="remember">
                        <input id="rememberme" name="rememberme" type="checkbox" id="remember"> 记住我</label>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        <label class="remember" for="remember">
                        <input id="keeplogin" name="keeplogin" type="checkbox" id="keeplogin"> 保持登陆</label>
                    </div>
                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <button type="submit" class="btn btn-primary">登陆</button>
                    </p>
                    <p class="pull-right col-md-5">
                    <label style="font-weight: 100;color:#999">没有账户？</label>
                      <a href="<?=Yii::$app->urlManager->createUrl('user/register')?>" >注册</a>
                    </p>
                </fieldset>
            </form>
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->

</div><!--/.fluid-container-->