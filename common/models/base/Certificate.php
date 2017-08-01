<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "certificate".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $pfx_url
 * @property string $key_url
 * @property integer $count
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Certificate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'certificate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'count', 'status', 'updated_at', 'created_at'], 'integer'],
            [['pfx_url', 'key_url'], 'string', 'max' => 125],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => '企业Id',
            'pfx_url' => '证书',
            'key_url' => 'key',
            'count' => '数量',
            'status' => '状态',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',
        ];
    }
}
