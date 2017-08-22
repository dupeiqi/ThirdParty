<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "data_dict".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $dict_name
 * @property string $dict_value
 * @property integer $template_id
 * @property integer $visible
 * @property integer $updated_at
 * @property integer $created_at
 */
class DataDict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data_dict';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'template_id', 'visible', 'updated_at', 'created_at'], 'integer'],
            [['dict_name'], 'string', 'max' => 50],
            [['dict_value'], 'string', 'max' => 125],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'dict_name' => '字典名称',
            'dict_value' => '字典值',
            'template_id' => '模版ID',
            'visible' => '是否可用',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',
        ];
    }
}
