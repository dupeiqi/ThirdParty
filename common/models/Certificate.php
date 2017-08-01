<?php

namespace common\models;

use Yii;
use \common\models\base\Certificate as BaseCertificate;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "credit_user".
 */
class Certificate extends BaseCertificate {
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

}
