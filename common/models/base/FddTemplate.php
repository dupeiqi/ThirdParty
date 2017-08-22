<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "fdd_template".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $template_name
 * @property string $template_file
 * @property string $template_id
 * @property integer $visible
 * @property integer $updated_at
 * @property integer $created_at
 */
class FddTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fdd_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'visible', 'updated_at', 'created_at'], 'integer'],
            [['template_name'], 'string', 'max' => 50],
            [['template_file'], 'string', 'max' => 125],
            [['template_id'], 'string', 'max' => 32],
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
            'template_name' => '模版名称',
            'template_file' => '模版文件',
            'template_id' => '模版ID',
            'visible' => '是否可用',
            'updated_at' => '更新时间',
            'created_at' => '创造时间',
        ];
    }
}
