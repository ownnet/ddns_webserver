<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<base href="<?= Url::home() ?>">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">    
    <link href="css/charisma-app.css" rel="stylesheet">
    <link href="css/fullcalendar.css" rel="stylesheet">
	<link href="css/fullcalendar.print.css" rel="stylesheet">
	<link href="css/chosen.min.css" rel="stylesheet">
	<link href="css/colorbox.css" rel="stylesheet">
	<link href="css/responsive-tables.css" rel="stylesheet">
	<link href="css/bootstrap-tour.min.css" rel="stylesheet">
	<link href="css/jquery.noty.css" rel="stylesheet">
	<link href="css/noty_theme_default.css" rel="stylesheet">
	<link href="css/elfinder.min.css" rel="stylesheet">
	<link href="css/elfinder.theme.css" rel="stylesheet">
	<link href="css/jquery.iphone.toggle.css" rel="stylesheet">
	<link href="css/uploadify.css" rel="stylesheet">
	<link href="css/animate.min.css" rel="stylesheet">
	<link href="css/jquery-confirm.min.css" rel="stylesheet">
	<link href="css/font-awesome.css" rel="stylesheet">
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="navbar navbar-default" role="navigation" >
        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"> <img alt="Charisma Logo" src="<?=Yii::$app->getUrlManager()->createUrl('')?>images/logo20.png" class="hidden-xs"/>
                <span>用户中心</span></a>

            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> admin</span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?=Yii::$app->getUrlManager()->createUrl('user')?>">Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="<?=Yii::$app->getUrlManager()->createUrl('user/logout')?>">Logout</a></li>
                </ul>
            </div>
            <!-- user dropdown ends -->

            <ul class="collapse navbar-collapse nav navbar-nav top-menu">
                <li><a href="../"><i class="glyphicon glyphicon-globe"></i> Visit Site</a></li>
                <li>
                    <form class="navbar-search pull-left">
                        <input placeholder="Search" class="search-query form-control col-md-10" name="query" type="text">
                    </form>
                </li>
            </ul>

        </div>
    </div>
    <div class="ch-container">
    <div class="row">
        
        <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header">主菜单</li>
                        <li><a class="ajax-link" href="<?=Yii::$app->getUrlManager()->createUrl('user')?>"><i class="fa fa-user"></i><span>个人信息</span></a>
                        </li>
                        <li class="accordion">
                        	<a href="#"><i class="fa fa-ioxhost"></i><span> 域名管理</span></a>
                        	<ul class="nav nav-pills nav-stacked">
                                <li><a href="<?=Yii::$app->getUrlManager()->createUrl('domain/list')?>">域名列表</a></li>
                                <li><a href="<?=Yii::$app->getUrlManager()->createUrl('domain/new')?>">添加新域名</a></li>
                            </ul>
                        </li>
                        <li class="accordion">
                        	<a href="#"><i class="fa fa-group"></i><span> 站点管理</span></a>
                        	<ul class="nav nav-pills nav-stacked">
                        	    <li><a href="<?=Yii::$app->getUrlManager()->createUrl('site')?>">站点配置</a></li>
                                <li><a href="<?=Yii::$app->getUrlManager()->createUrl('user/list')?>">用户列表</a></li>
                                <li><a href="<?=Yii::$app->getUrlManager()->createUrl('user/add')?>">添加新用户</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->
        
        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>

    <div id="content" class="col-lg-10 col-sm-10">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
    </div>


<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= date('Y') ?></p>
        <p class="pull-right"></p>
    </div>
</footer>
</div>
<script src="js/jquery-1.12.2.min.js"></script>
<?php $this->endBody() ?>
<script src="js/jquery.cookie.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/fullcalendar.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/chosen.jquery.min.js"></script>
<script src="js/jquery.colorbox-min.js"></script>
<script src="js/jquery.noty.js"></script>
<script src="js/responsive-tables.js"></script>
<script src="js/bootstrap-tour.min.js"></script>
<script src="js/jquery.raty.min.js"></script>
<script src="js/jquery.iphone.toggle.js"></script>
<script src="js/jquery.autogrow-textarea.js"></script>
<script src="js/jquery.uploadify-3.1.min.js"></script>
<script src="js/jquery.history.js"></script>
<script src="js/charisma.js"></script>
<script src="js/jquery-confirm.min.js"></script>
<script>
function newAlert(t,c,f){
	$.alert({
	    title: t,
	    content: c,
	    confirmButton: 'OK',
	    confirm: function(){
		    if(f==1)window.location.reload(); 
	    }
	});
}
</script>
</body>
</html>
<?php $this->endPage() ?>
