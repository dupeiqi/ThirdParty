<?php

use yii\db\Migration;

class m170519_021037_create_table_user extends Migration
{
    public function up()
    {
        if (!(Yii::$app->db->getTableSchema('user'))) {
            $this->createTable('user', array(
                'id' => "int NOT NULL AUTO_INCREMENT PRIMARY KEY",
                'company_name' => "varchar(125) NOT NULL default '' comment '公司名称'",
                'token' => "varchar(125) NOT NULL default '' comment 'Token'",
                'status' => "int(11) not null default '0' comment '状态'",
                'updated_at' => "int(11) not null default '0' comment '更新时间'",
                'created_at' => "int(11) not null default '0' comment '创建时间'",
            ), 'ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT "用户表"');
        }
    }

    public function down()
    {
        echo "m170519_021037_create_table_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
