<?php

namespace common\models;

use Yii;
use common\models\base\User as BaseUser;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class GrUser extends BaseUser
{
      public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }
}
