<?php

namespace common\models;

use Yii;
use \common\models\base\FddContract as BaseFddContract;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class FddContract extends BaseFddContract
{
      public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }
}
