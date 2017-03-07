<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $user
 * @property string $password
 * @property string $salt
 * @property string $email
 * @property string $token
 * @property string $last_auth_time
 * @property string $options
 * @property integer $status
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'password', 'salt', 'email', 'token', 'lastauth', 'options'], 'string'],
            [['status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'password' => 'Password',
            'salt' => 'Salt',
            'email' => 'Email',
            'token' => 'Token',
            'lastauth' => 'Last Auth Time',
            'options' => 'Options',
            'status' => 'Status',
        ];
    }
    
    public function getUserList(){
    	return User::find()->where(['<>','status','0'])->all();
    }
    
    public function getUserInfoByUser($user)
    {
    	return User::find()
    	->where(['user'=>$user])
    	->one();
    }
    
    public function checkPasswordByUser($user,$password)
    {
    	$user_obj = User::find()->where(['user'=>$user])->one();
    	if($user_obj){
    		$user_info = $user_obj->attributes;
    		if($user_info['password'] == md5($user_info['id'].$user.$password.$user_info['salt'])){
    			return $user_info;
    		}else{
    			return 'error:username_or_password_error';
    		}
    	}else{
    		return 'error:username_or_password_error';
    	}
    }
    
    public function getUserInfoByID($id)
    {
    	return User::find()
    	->where(['id'=>$id])
    	->one();
    }
    
    public function getUserByToken($token)
    {
    	return User::find()->where(['token'=>$token])->one();
    }
        
    public function addNewUser($arr)
    {
    	$user = new User();
    	$user->user=$arr['username'];
    	$user->email=$arr['email'];
    	$user->salt=time().rand(10000,99999);
    	$user->token = md5(time().rand(10000,99999));
    	$user->status = 1;
    	return $user->save();
    }
    
    public function updatePasswordByUserInfo($info,$password)
    {
    	$pwd = User::findOne(['user'=>$info['user']]);
    	$salt = time().rand(10000,99999);
    	$pwd->password = md5($info['id'].$info['user'].$password.$salt);
    	$pwd->salt = $salt;
    	return $pwd->save();
    }
    
    public function updateOptions($id,$value)
    {
    	$user = User::findOne(['id'=>$id]);
    	$user->options = $value;
    	return $user->save();
    }
    
    public function updateToken($id,$value)
    {
    	$user = User::findOne(['id'=>$id]);
    	$user->token = $value;
    	return $user->save();
    }
    
    public function updateLast($id,$value)
    {
    	$user = User::findOne(['id'=>$id]);
    	$user->lastauth = $value;
    	return $user->save();
    }
    
    public function updateUserInfo($id,$arr)
    {
    	$user = User::findOne(['id'=>$id]);
    	$user->email = $arr['email'];
    	return $user->save();
    }
    
    public function updateUserItem($id,$item,$value)
    {
    	$user = User::findOne(['id'=>$id]);
    	
    	switch ($item){
    		case 'user':
    			$user->user = $value;
    			break;
    		case 'password':
    			$user->password = $value;
    			break;
    		case 'salt':
    			$user->salt = $value;
    			break;
    		case 'email':
    			$user->email = $value;
    			break;
    		case 'token':
    			$user->token = $value;
    			break;
    		case 'lastauth':
    			$user->lastauth = $value;
    			break;
    		case 'status':
    			$user->status = $value;
    			break;
    	}
    	return $user->save();
    }
            
    /*option 字段操作*/
    //取项目，返回值为数组
    public static function getUserOption($id,$item)
    {
    	$info = json_decode((new User())->getUserInfoByID($id)['options'],true);
    
    	if($info == '') return false;
    
    	if(array_key_exists($item,$info))
    	{
    		return $info[$item];
    	}else{
    		return false;
    	}
    }
    
    //删除项目，返回值为剩余项目数组的json形式
    public static function removeUserOption($id,$item)
    {
    	$info = json_decode((new User())->getUserInfoByID($id)['options'],true);
    	if(array_key_exists($item,$info))
    	{
    		unset($info[$item]);
    		return json_encode($info);
    	}else{
    		return false;
    	}
    }
    //添加项目，返回值为添加后项目数组的json形式
    public static function addUserOption($id,$item,$value)
    {
    	$info = json_decode((new User())->getUserInfoByID($id)['options'],true);
    	if($info == '' || !array_key_exists($item,$info))
    	{
    		$info[$item] = $value;
    		return json_encode($info);
    	}else{
    		return false;
    	}
    }
    //更新
    public static function updateUserOption($id,$item,$key,$value)
    {
    	$info = json_decode((new User())->getUserInfoByID($id)['options'],true);
    	if(array_key_exists($item,$info)){
    		if(array_key_exists($key,$info[$item])){
    			$info[$item][$key]=$value;
    			return json_encode($info);
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    }
}
