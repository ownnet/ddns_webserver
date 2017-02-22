<?php
namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Config;


class UserController extends UserCenterController
{
	public function init()
	{
		$this->layout = 'usercenter_layout';
	}
	
	public function actionLogin()
	{
		$this->layout = 'blank';
		return $this->render('login');
	}
	
	public function actionDologin()
	{
		$arr=Yii::$app->request->post();
		$user = (new User()) -> getUserInfoByUser($arr['username']);
		 
		$pwd = md5($user['id'].$user['user'].$arr['password'].$user['salt']);
		if($pwd == $user['password']){ //登陆成功
			$session = Yii::$app->session;
			$session->set('id',$user['id']);
			return $this->redirect(Yii::$app->getUrlManager()->createUrl('user'));
		}else{
			//登陆失败
			echo '<script>alert("password_error")</script>';
			echo '<script>javascript:history.go(-1);</script>';
		}
	}
	
	public function actionLogout()
	{
		$session = Yii::$app->session;
		$session->remove('id');
		return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/login'));
	}
	
	public function actionIndex()
	{
		if($this->uid == null) {
			return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/login'));
		}
		
		if(Yii::$app->request->post())
		{
			$arr = Yii::$app->request->post();
			$rst1=(new User())->updateUserInfo($this->uid, $arr);
			$rst2 = 1;
			if($arr['password'] != ''){
				if($arr['password'] == $arr['password2']){
					$info = (new User())->getUserInfoByID($this->uid)->attributes;
					$rst2 = (new User())->updatePasswordByUserInfo($info, $arr['password']);
				}else{
					$rst2 = 0;
					Yii::$app->getSession()->setFlash('err_msg', '密码不一致');
					return $this->redirect(['info']);
				}
			}
			if($rst1 && $rst2){
				Yii::$app->getSession()->setFlash('info_msg', '保存成功');
				return $this->redirect(['index']);
			}else{
				Yii::$app->getSession()->setFlash('err_msg', '保存失败');
				return $this->redirect('index');
			}
		}else{
			$data['info'] = (new User())->getUserInfoByID($this->uid)->attributes;
			return $this->render('index',$data);
		}
	}
	
	private function registerCheck()
	{
		return (new Config())->readConfig('open_register');
	}
	
	public function actionRegister()
	{
		if($this->registerCheck()){
			$this->layout = 'blank';
			return $this->render('register');
		}else{
			$email = (new Config())->readConfig(['admin_email']);
			echo '注册未开放，请联系Email:'.$email;
		}
		
	}
	public function actionDoregister()
	{
		if(!$this->registerCheck()){
			echo '注册未开放';
			exit();
		}
		
		$arr=Yii::$app->request->post();
		//邮箱地址检查
		$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
		if(!preg_match( $pattern, $arr['email'])){
			echo 0;
			exit();
		}
		//用户名和邮箱唯一性检查
		$u=User::find()->where(['user'=>$arr['username']])->count();
		$e=User::find()->where(['email'=>$arr['email']])->count();
		if($u!=0||$e!=0){
			echo 0;
			exit();
		}
			
		$usr = new User();
		//写入用户
		$check1 = $usr->addNewUser($arr);
		//取出用户信息
		$getid = $usr->getUserInfoByUser($arr['username']);
		//将更新后的密码存入数据库
		$check2 = $usr->updatePasswordByUserInfo($getid, $arr['password']);
		//密码写入失败，删除用户名写入记录
		if($check2==0){
			$del = User::findOne(['user'=>$arr['username']]);
			$del->delete();
		}
			
		if($check1&&$check2){
			echo 1;
		}else{
			echo 0;
		}
	}
	public function actionCheckunique()
	{
		$arr=Yii::$app->request->post();
	
		$arr['type'] == "user";
		if($arr['type'] == "user"){
			echo User::find()
			->where(['user'=>$arr['str']])
			->count();
		}elseif($arr['type'] == "email"){
			echo User::find()
			->where(['email'=>$arr['str']])
			->count();
	
		}else{
			echo 'error';
		}
	}
	
	public function actionList()
	{
		$data['user']=(new User())->getUserList();
		return $this->render('list',$data);
	}
	
	public function actionAdd()
	{
		return $this->render('add');
	}
	
	public function actionEdit($id)
	{
		if($this->uid != 1){
			echo '权限错误';
			exit();
		}
		
		if(Yii::$app->request->post())
		{
			$data['info'] = (new User())->getUserInfoByID($id);
			
			$arr = Yii::$app->request->post();
			$rst1 = (new User())->updateUserInfo($id, $arr);
			$rst2 = 1;
			if($arr['password'] != ''){
				if($arr['password'] == $arr['password2']){
					$info = (new User())->getUserInfoByID($id)->attributes;
					$rst2 = (new User())->updatePasswordByUserInfo($info, $arr['password']);
				}else{
					$rst2 = 0;
					Yii::$app->getSession()->setFlash('err_msg', '密码不一致');
					return $this->redirect(Yii::$app->urlManager->createUrl('user/edit/'.$info['id']));
				}
			}
			if($rst1 && $rst2){
				Yii::$app->session->setFlash('info_msg','修改成功');
			}else{
				Yii::$app->session->setFlash('err_msg','修改失败');
			}
			return $this->redirect(Yii::$app->urlManager->createUrl('user/edit/'.$id));
		}else{
			$data['info'] = (new User())->getUserInfoByID($id)->attributes;
			return $this->render('edit',$data);
		}
		
	}
	
	public function actionDel($id)
	{
		$this->layout = 'blank';
		if($this->uid != 1){
			echo '权限错误';
			exit();
		}
	
		$data['user'] = (new User())->getUserInfoByID($id);
		$post = Yii::$app->request->post();
		if($post){
			if($post['del'] == 'true'){
				if((new User())->updateUserItem($id, 'status', 0)){
					return $this->redirect(Yii::$app->getUrlManager()->createUrl('user/list'));
				}else{
					echo 'unknow_error1';
				}
			}else{
				echo 'unknown_error2';
			}
		}
		return $this->render('del',$data);
	}
}