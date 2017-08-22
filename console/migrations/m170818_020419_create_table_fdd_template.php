<?php

use yii\db\Migration;

class m170818_020419_create_table_fdd_template extends Migration
{
    public function Up()
    {
        if (!(Yii::$app->db->getTableSchema('fdd_template'))) {
            $this->createTable('fdd_template', array(
                'id' => "int NOT NULL AUTO_INCREMENT PRIMARY KEY",
                'user_id' => "int(11) not null default '0' comment '用户id'",
                'template_name' => "varchar(50) NOT NULL default '' comment '模版名称'",
                'template_file' => "varchar(125) NOT NULL default '' comment '模版文件'",  
                'template_id' => "varchar(32) not null default '' comment '模版ID'",
                'visible' => "tinyint(1) not null default '1' comment '是否可用,1,可用，2,不可用'",
                'updated_at' => "int(11) not null default '0' comment '更新时间'",
                'created_at' => "int(11) not null default '0' comment '创建时间'",
            ), 'ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT "模版表"');
        }
        
    }

    public function Down()
    {
        echo "m170818_020419_create_table_fdd_template cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170818_020419_create_table_fdd_template cannot be reverted.\n";

        return false;
    }
    */
}
