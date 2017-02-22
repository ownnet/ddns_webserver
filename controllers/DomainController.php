<?php
namespace app\controllers;

use Yii;
use app\models\Record;

class DomainController extends UserCenterController
{
	public function init()
	{
		$this->layout = 'usercenter_layout';
	}
	
	public function actionIndex()
	{
// 		Yii::$app->language = 'zh-CN';
// 		echo Yii::t('app', 'Goodbye_flag');
	}
	
	public function actionList()
	{
		$data['domain'] = (new Record())->getRecordByUser($this->uid);
		return $this->render('list',$data);
	}
	
	public function actionNew()
	{
		$post = Yii::$app->request->post();
		if($post){
			if($post['host'] == ''){
				Yii::$app->session->setFlash('err_msg','请输入有效地主机记录');
			}else{
				$post['uid'] = $this->uid;
				if((new Record())->addNewRecord($post)){
					Yii::$app->session->setFlash('info_msg','添加成功');
				}else{
					Yii::$app->session->setFlash('err_msg','添加失败');
				}
			}
		}else{
		}
		return $this->render('new');
	}
	
	public function actionEdit($id)
	{
		$domain = (new Record())->getRecordById($id);
		if($domain['user_id'] == $this->uid){
			$data['domain'] = $domain;
			$post = Yii::$app->request->post();
			if($post){
				if((new Record())->updateRecord($id, $post)){
					$data['domain'] = (new Record())->getRecordById($id);
					Yii::$app->session->setFlash('info_msg','修改成功');
				}else{
					Yii::$app->session->setFlash('err_msg','修改失败');
				}
			}
			return $this->render('edit',$data);
		}else{
			echo '权限错误';
		}
	}
	
	public function actionDel($id)
	{
		$this->layout = 'blank';
		
		$data['domain'] = (new Record())->getRecordById($id);
		if($data['domain']['user_id'] == $this->uid){
			$post = Yii::$app->request->post();
			if($post){
				if($post['del'] == 'true'){
					if((new Record())->updateStatus($id, 0)){
						return $this->redirect(Yii::$app->getUrlManager()->createUrl('domain/list'));
					}else{
						echo 'unknow_error1';
					}
				}else{
					echo 'unknown_error2';
				}
			}
		}else{
			echo '权限错误';
		}
		
		return $this->render('del',$data);
	}
}