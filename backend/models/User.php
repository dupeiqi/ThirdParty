<?php

namespace backend\models;

use Yii;
use \common\models\base\User as BaseUser;
use yii\db\ActiveRecord;
use common\models\Certificate;

/**
 * This is the model class for table "credit_user".
 */
class User extends BaseUser {
    public function saveUser(){
        $this->created_at=$this->updated_at=time();
        $this->token=md5($this->company_name.$this->created_at);
        return $this->save();
    }

    public function getCertificate(){
        return $this -> hasOne(Certificate::className(),['company_id' => 'id']);
    }

}
