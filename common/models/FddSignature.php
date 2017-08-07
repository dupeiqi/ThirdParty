<?php

namespace common\models;

use Yii;
use common\models\base\FddSignature as BaseFddSignature;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class FddSignature extends BaseFddSignature
{
      public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }
}
