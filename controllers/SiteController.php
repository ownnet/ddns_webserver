<?php

namespace app\controllers;

use Yii;
use app\models\Config;



class SiteController extends UserCenterController
{
	public function init()
	{
		$this->layout = 'usercenter_layout';
	}
	
    public function actionIndex()
    {
    	$post = Yii::$app->request->post();
    	if($post){
    		(new Config())->updateAllConfig($post);
    	}
    	
    	$config_obj = (new Config())->getAllConfig();
    	$data['config'] = array();
    	foreach ($config_obj as $item)
    	{
    		$data['config'][$item['key']] = $item['value'];
    	}
    	
    	return $this->render('index',$data);
    }
}
