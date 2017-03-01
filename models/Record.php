<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "record".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $host
 * @property string $type
 * @property string $value
 * @property string $ttl
 * @property string $auth_code
 * @property string $options
 * @property integer $status
 */
class Record extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['host', 'type', 'value', 'ttl', 'auth_code', 'options'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'host' => 'Host',
            'type' => 'Type',
            'value' => 'Value',
            'ttl' => 'Ttl',
            'auth_code' => 'Auth Code',
            'options' => 'Options',
            'status' => 'Status',
        ];
    }
    
    public function getRecordById($id)
    {
    	return Record::find()
    	->where(['id'=>$id])
    	->one();
    }
    
    public function getRecordByHost($host)
    {
    	return Record::find()
    	->where(['host'=>$host])
    	->all();
    }
    
    public function getRecordByUser($uid)
    {
    	return Record::find()
    	->where(['user_id'=>$uid])
    	->andWhere(['<>','status','0'])
    	->all();
    }
    
    public function getRecordByUserAndHost($uid,$host)
    {
    	return Record::find()
    	->where(['user_id'=>$uid,'host'=>$host])
    	->all();
    }
    
    public function updateRecord($id,$arr)
    {
    	$record = Record::findOne(['id'=>$id]);
    	
    	$record->host = $arr['host'];
    	$record->type = $arr['type'];
    	$record->value = $arr['value'];
    	$record->ttl = $arr['ttl'];
    	$record->auth_code = isset($arr['auth_code'])?$arr['auth_code']:$record['auth_code'];

    	return $record->save();
    }
    
    public function updateIpByAuthCode($domain,$auth_code,$ip,$status = 1)
    {   	
    	$record = Record::findOne(['host'=>$domain,'auth_code'=>$auth_code,'status'=>$status]);
    	if($record){
    		$record->value = $ip;
    		return $record->save();
    	}else{
    		return 'error_domain_not_exists';
    	}
    }
    
    public function updateStatus($id,$status)
    {
    	$record = Record::findOne(['id'=>$id]);
    	$record->status = $status;
    	return $record->save();
    }
    
    public function addNewRecord($arr)
    {   	
    	$record = new Record();
    	$record->user_id = $arr['uid'];
    	$record->host = $arr['host'];
    	$record->type = $arr['type'];
    	$record->value = $arr['value'];
    	$record->ttl = $arr['ttl'];
    	$record->auth_code = isset($arr['auth_code'])?$arr['auth_code']:Record::newAuthCode();
    	$record->options = '';
    	$record->status = 1;
    	
    	return $record->save();
    }
    
    public static function newAuthCode()
    {
    	return md5('auth'.time().rand(10000,99999));
    }
    
}
