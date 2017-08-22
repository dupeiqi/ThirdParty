<?php

namespace common\models;

use Yii;
use common\models\base\FddTemplate as BaseFddTemplate;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class FddTemplate extends BaseFddTemplate
{
      public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }
    
//     public function saveTemp(){
//         
//        $this->created_at=$this->updated_at=time();
//        $this->token=md5($this->company_name.$this->created_at);
//         
//     }
}
