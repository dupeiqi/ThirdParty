<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "signature".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $src_url
 * @property string $dest_url
 * @property integer $count
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class Signature extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'signature';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'count', 'status', 'updated_at', 'created_at'], 'integer'],
            [['src_url', 'dest_url'], 'string', 'max' => 125],
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
            'src_url' => '源文件',
            'dest_url' => '签章文件',
            'count' => '数量',
            'status' => '状态',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',
        ];
    }
}
