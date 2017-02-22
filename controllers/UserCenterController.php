<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\base\Object;
use yii\db\Exception;



class UserCenterController extends Controller
{
	public $uid = '';
	public $action_name = '';
	public $controller_name = '';
	public $name = '';
	public $shop_id = '';
	public $home_url = '';
	public $cache = '';

	
	//构造函数，完成一些初始化工作
	public function __construct($id, $module, $config = [])
	{
		//启用缓存（受common/config/main.php控制）
		$this->cache = Yii::$app->cache;
		//将控制器名和方法名存入变量
		$this->controller_name = $this->getControllerName();
		$this->action_name = $this->getActionName();
		//站点url
		$this->home_url = Yii::$app->request->hostInfo.Yii::$app->user->returnUrl;
		//获取uid，未登录则为null
		$this->uid = empty(Yii::$app->session['id'])?null:Yii::$app->session['id'];
		
		//获取uid及传递姓名及头像参数
		/*
		$user_info = $this->getUserByUID($this->uid);
		$this->view->params['name'] = $user_info['name'];
		$this->view->params['photo'] = $user_info['photo'];
		$this->name = $this->view->params['name'];
		*/
		
		//继续执行父类中的构造函数
		parent::__construct($id, $module, $config = []);

	}
		
	/**
	 * 用户登录状态检查
	 * @param string $auto_redirect 检查失败时是否自动跳转至登录页；默认跳转
	 */
	public function loginCheck($auto_redirect = true)
	{
		if(!Yii::$app->session['id']){
			if($auto_redirect){
				return $this->redirect( Yii::$app->getUrlManager()->createUrl('user/login'));
			}else{
				return 0;
			}
		}else{
			return 1;
		}
	}
	
	/**
	 * 获取方法名
	 * @return string
	 */
	public function getActionName()
	{
		return isset(explode('/',Yii::$app->requestedRoute)[1])?explode('/',Yii::$app->requestedRoute)[1]:'index';
	}
	
	/**
	 * 获取控制器名称
	 * @return string
	 */
	public function getControllerName()
	{
		return (explode('/',Yii::$app->requestedRoute)[0] != '')?explode('/',Yii::$app->requestedRoute)[0]:'site';
	}
	
	/**
	 * 通过User ID获取用户姓名及头像
	 * @param unknown $uid
	 */
	public function getUserByUID($uid)
	{
		/*
		if($uid != 0){
			$info = (new User())->getUserInfoByID($uid);
			$data['name'] = empty($info['name'])?$info['user']:$info['name'];
			$data['photo'] = empty($info['photo'])?'../images/user-unlogin-icon.png':$info['photo'];
			return $data;
		}else{
			return null;
		}	
		*/	
	}
}