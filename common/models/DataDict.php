<?php

namespace common\models;

use Yii;
use common\models\base\DataDict as BaseDataDict;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class DataDict extends BaseDataDict
{
      public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }    

}
