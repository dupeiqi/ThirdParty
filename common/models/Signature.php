<?php

namespace common\models;

use Yii;
use \common\models\base\Signature as BaseSignature;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "credit_user".
 */
class Signature extends BaseSignature {
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

}
