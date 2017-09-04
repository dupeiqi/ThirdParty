<?php

namespace backend\models;

use Yii;
use \common\models\base\User as BaseUser;
use yii\db\ActiveRecord;
use common\models\Certificate;
use common\models\FddApi;
/**
 * This is the model class for table "credit_user".
 */
class User extends BaseUser {
    public function saveUser(){
        //个人用户去法大大获取CA
        if ($this->type==2){  
            
           if (empty($this->company_name)||empty($this->mobile)||empty($this->id_card)){
               return false;
           }
            $fdd=new FddApi();
            //获取法大大CA
            $ret= json_decode($fdd->invokeSyncPersonAuto($this->company_name, $this->mobile, $this->id_card),true);
            if ($ret['code']=='1000'){
                $this->fdd_ca=$ret['customer_id'];
            }else{
                return false;
            }
        }
        

        $this->created_at=$this->updated_at=time();
        $this->token=md5($this->company_name.$this->created_at);
     
        return $this->save();
    }

    public function getCertificate(){
        return $this -> hasOne(Certificate::className(),['company_id' => 'id']);
    }

}
