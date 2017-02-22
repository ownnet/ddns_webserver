<link href="css/chosen.min.css" rel="stylesheet">
<link href="css/charisma-app.css" rel="stylesheet">

<div class="ch-container">
    <div class="row">
    <div class="row">
        <div class="col-md-12 center login-header">
            <h2> </h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div  class="well col-md-5 center login-box">
            <form id="reg" class="form-horizontal" action="domain/del/<?=$domain['id']?>" method="post" >
            <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                <fieldset>
                    <p>
                    <h4>确认删除<?=$domain['host']?>?</h4>
                    </p>
                    <input type="hidden" name="del" value="true">

                    <p class="center col-md-5">
                    	<button type="submit" class="btn btn-success"><?=Yii::t('app', '确定');?></button>
                    	<a class="btn btn-danger" href="<?=Yii::$app->getUrlManager()->createUrl('domain/list')?>">取消</a>
                    </p>
                </fieldset>
            </form>
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->

</div><!--/.fluid-container-->