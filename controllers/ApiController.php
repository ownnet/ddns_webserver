<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Record;
use app\models\User;



class ApiController extends Controller
{
	public $enableCsrfValidation = false;
	
	public function init()
	{
		$this->layout = 'blank';
	}
	
	public function actionIndex()
	{
		echo md5('0user1user119852');
	}
	
	public function actionGetip()
	{
		if (getenv("HTTP_CLIENT_IP"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
			$ip = getenv("REMOTE_ADDR");
		else $ip = null;
		
		echo $ip;
	}
	
	public function actionGettime()
	{
		date_default_timezone_set(Yii::$app->params['timezone']);
		echo time();
	}
	
	public function actionGetuserinfo($token = '')
	{
		$user_obj = (new User)->getUserByToken($token);
		if($user_obj){
			echo json_encode($user_obj->attributes);
		}else{
			echo 'error:unknown_user';
		}
	}
	
	public function actionGetdomaininfo($token = '',$domain = '')
	{
		$user_info = (new User())->getUserByToken($token);
		if($user_info) {
			$user_id = $user_info['id'];
		}
		$record = (new Record())->getRecordByHost($domain);
		$rst = array();
		foreach ($record as $item){
			if($item['user_id'] == $user_id){
				$rst[] = $item->attributes;
			}				
		}
		echo json_encode($rst);
	}
	
	public function actionGetauthcode($token = '',$domain = '')
	{
		$user_info = (new User())->getUserByToken($token);
		if($user_info) {
			$user_id = $user_info['id'];
		}
		$record = (new Record())->getRecordByHost($domain);
		$rst = array();
		foreach ($record as $item){
			if($item['user_id'] == $user_id){
				$rst[] = $item->attributes['auth_code'];
			}
		}
		echo json_encode($rst);
	}
	
	public function actionGetdomainlist($token = '')
	{
		$user_info = (new User())->getUserByToken($token);
		if($user_info){
			$record = (new Record())->getRecordByUser($user_info->attributes['id']);
			$record_arr = array();
			foreach ($record as $item){
				$record_arr[] = $item->attributes;
			}

			if($record_arr){
				echo json_encode($record_arr);
			}else{
				echo 'error:domain_list_empty';
			}
		}else{
			echo 'error:unkown_user';
		}
	}
	
	public function actionUpdate($version = '')
	{
		switch ($version){
			case 'safe':
				echo $this->safeVersion(Yii::$app->request->post());
				break;
			case 'username':
				echo $this->usernameVersion($_GET);
				break;
			case 'authcode':
				echo $this->authcodeVersion($_GET);
				break;
			default:
				echo 'error:unknown_update_version';
		}
		
	}
	
	/**
	 * 通过时间授权码验证域名，授权码在最长90秒内有效，时间授权码计算方法为：
	 * 服务器时间戳/30 与 域名的auth_code 拼接后计算md5
	 * md5((string)((intval(time/30)) + (string)auth_code)
	 */
	private function safeVersion($post)
	{
		$time_auth_code = intval(time()/30);		
		$record_obj = (new Record())->getRecordByHost($post['domain']);
		
		foreach ($record_obj as $item){
			if($post['auth'] == md5($time_auth_code.$item['auth_code']) OR 
					$post['auth'] == md5((string)($time_auth_code - 1).$item['auth_code']) OR 
					$post['auth'] == md5((string)($time_auth_code + 1).$item['auth_code'])){
				(new Record())->updateIpByAuthCode($item['auth_code'], $post['ip']);
				return 'success';
			}
		}
		
		return 'error:time_'.$time_auth_code;
	}
	
	/**
	 * 通过用户名/密码/域名方式更新ip，该方法仅支持一个域名仅对应一个ip的情况
	 * 若同一域名包涵多条记录，请使用其他两种方法
	 */
	private function usernameVersion($get)
	{
		$user = (new User())->checkPasswordByUser($get['username'], $get['password']);
		if(is_array($user)){
			$record = (new Record())->getRecordByUserAndHost($user['id'],$get['domain']);
			if (count($record) >= 2){
				return 'error:too_more_record_founded';
			}elseif(count($record) == 0){
				return 'error:domain_not_exists';
			}else{
				if((new Record())->updateIpByAuthCode($record[0]['auth_code'], $get['ip'])){
					return 'success';
				}else{
					return 'error:db_error';
				}
			}
		}else{
			return $user;
		}
	}
	
	/**
	 * 通过域名auth_code更新记录
	 */
	private function authcodeVersion($get)
	{
		if((new Record())->updateIpByAuthCode($get['auth_code'], $get['ip'])){
			return 'success';
		}else{
			return 'error:auth_code_invalid';
		}
	}
	
	public function actionAuth()
	{
		$post = Yii::$app->request->post();
		
		$user_info = (new User())->getUserInfoByUser($post['username']);
		$time =(string)time();

		if($user_info){
			if($user_info['password'] == md5($user_info['id'].$post['username'].$post['password'].$user_info['salt'])){
				//密码正确
				//1、检查是否允许多点登陆
				if((new User())->getUserOption($user_info['id'], ['multi_login'])){
					//允许多点登陆
					if(time()-$user_info['last_auth_time'] > 86400){
						//时间超过24h，重新生成token
						$token =  md5($user_info['id'].time());
						(new User())->updateToken($user_info['id'],$token);
						echo $token;
					}else{
						echo $user_info['token'];
					}
				
				}else{
					//不允许多点登陆
					$token =  md5($user_info['id'].time());
					(new User())->updateToken($user_info['id'],$token);
					echo $token;
				}
				
				//2.更新last_auth_time
				(new User())->updateUserItem($user_info['id'], 'lastauth', $time);			
			}else{
				echo 'error:username_or_password_error';
			}
		}else{
			echo 'error:username_or_password_error';
		}
	}
	
	public function actionKeepalive()
	{
		$post = Yii::$app->request->post();
		if($post){
			$user_info = (new User())->getUserByToken($post['token']);
			if($user_info){
				if((new User())->updateUserItem($user_info['id'], 'last_auth_time', time())){
					echo 'success';
				}else{
					echo 'error:db_error';
				}
			}else{
				echo 'error:token_expired';
			}
		}
	}
}