<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "fdd_contract".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $contract_id
 * @property string $doc_title
 * @property string $file
 * @property string $timestamp
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class FddContract extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fdd_contract';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'updated_at', 'created_at'], 'integer'],
            [['contract_id'], 'string', 'max' => 32],
            [['doc_title', 'file'], 'string', 'max' => 125],
            [['timestamp'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '企业Id或用户id',
            'contract_id' => '合同ID',
            'doc_title' => '合同标题',
            'file' => '合同文件',
            'timestamp' => '请示时间',
            'status' => '状态',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',
        ];
    }
}
