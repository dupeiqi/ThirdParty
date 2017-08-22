<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "fdd_signature".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $transaction_id
 * @property string $contract_id
 * @property string $customer_id
 * @property string $doc_title
 * @property integer $client_role
 * @property string $sign_keyword
 * @property string $download_url
 * @property string $viewpdf_url
 * @property integer $status
 * @property string $timestamp
 * @property integer $updated_at
 * @property integer $created_at
 */
class FddSignature extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fdd_signature';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','sign_user_id', 'client_role', 'status', 'updated_at', 'created_at'], 'integer'],
            [['transaction_id', 'contract_id', 'customer_id'], 'string', 'max' => 32],
            [['doc_title', 'sign_keyword'], 'string', 'max' => 125],
            [['download_url', 'viewpdf_url'], 'string', 'max' => 255],
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
            'transaction_id' => '交易号',
            'contract_id' => '合同ID',
            'customer_id' => '客户编号CA注册',
            'doc_title' => '合同标题',
            'client_role' => '客户角色',
            'sign_keyword' => '定位关键字',
            'download_url' => '合同下载地址',
            'viewpdf_url' => '合同查看地址',
            'status' => '状态',
            'timestamp' => '请求时间',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',
        ];
    }
}
