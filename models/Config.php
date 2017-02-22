<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
        ];
    }
    
    public function getAllConfig()
    {
    	return Config::find()->all();
    }
    
    public function updateAllConfig($arr)
    {
    	$config_list = ['open_register','invitation_allow','default_language','admin_email'];
    	
    	foreach ($config_list as $config_key){
    		if(isset($arr[$config_key])){
    			$this->updateConfig($config_key, $arr[$config_key]);
    		}else{
    			$this->updateConfig($config_key, '');
    		}
    	}
    }
    
    public function createConfig($key,$value)
    {
    	$config = new Config();
    	$config -> key = $key;
    	$config -> value = $value;
    	return $config->save();
    }
    
    public function readConfig($key)
    {
    	return Config::find()
    	->where(['key'=>$key])
    	->one()['value'];
    }
    
    public function updateConfig($key,$value)
    {
    	$config = Config::findOne(['key'=>$key]);
    	$config -> value = $value;
    	return $config->save();
    }
    
    public function deleteConfig($id)
    {
    	$config = Config::findOne(['key'=>$key]);
    	return $config->delete();
    }
}
