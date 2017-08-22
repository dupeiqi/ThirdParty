<?php

use yii\db\Migration;

class m170818_015451_create_table_data_dict extends Migration
{
   public function Up()
    {
        if (!(Yii::$app->db->getTableSchema('data_dict'))) {
            $this->createTable('data_dict', array(
                'id' => "int NOT NULL AUTO_INCREMENT PRIMARY KEY",
                'user_id' => "int(11) not null default '0' comment '用户id'",
                'dict_name' => "varchar(50) NOT NULL default '' comment '字典名称'",
                'dict_value' => "varchar(125) NOT NULL default '' comment '字典值'",  
                'template_id' => "int(11) not null default '0' comment '模版ID'",
                'visible' => "tinyint(1) not null default '1' comment '是否显示,1,显示，2,不显示'",
                'updated_at' => "int(11) not null default '0' comment '更新时间'",
                'created_at' => "int(11) not null default '0' comment '创建时间'",
            ), 'ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT "模版数据字典表"');
        }
        
    }

    public function Down()
    {
        echo "m170818_015451_create_table_data_dict cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170818_015451_create_table_data_dict cannot be reverted.\n";

        return false;
    }
    */
}
