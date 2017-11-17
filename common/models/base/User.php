<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $id_card
 * @property integer $mobile
 * @property string $token
 * @property integer $type
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type','is_auto', 'status', 'updated_at', 'created_at'], 'integer'],
            [['mobile'],'match','pattern'=>'/^1[3|4|5|7|8]\d{9}$/','message'=>'手机格式不正确!'],
            [['company_name', 'token'], 'string', 'max' => 125],
            [['id_card','fdd_ca'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => '公司名称或姓名',
            'id_card' => '身份证',
            'mobile' => '手机号',
            'token' => 'Token',
            'fdd_ca' => '法大大CA',
            'type' => '类行',
            'is_auto' => '是否签章',
            'status' => '状态',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',
        ];
    }
}
