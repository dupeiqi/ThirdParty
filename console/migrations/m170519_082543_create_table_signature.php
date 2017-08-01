<?php

use yii\db\Migration;

class m170519_082543_create_table_signature extends Migration
{
    public function up()
    {
        if (!(Yii::$app->db->getTableSchema('signature'))) {
            $this->createTable('signature', array(
                'id' => "int NOT NULL AUTO_INCREMENT PRIMARY KEY",
                'company_id' => "int(11) not null default '0' comment '企业Id'",
                'src_url' => "varchar(125) NOT NULL default '' comment '源文件'",
                'dest_url' => "varchar(125) NOT NULL default '' comment '签章文件'",
                'count' => "int(11) not null default '0' comment '数量'",
                'status' => "int(11) not null default '0' comment '状态'",
                'updated_at' => "int(11) not null default '0' comment '更新时间'",
                'created_at' => "int(11) not null default '0' comment '创建时间'",
            ), 'ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT "签章表"');
        }
    }

    public function down()
    {
        echo "m170519_082543_create_table_signature cannot be reverted.\n";

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
