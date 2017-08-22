<?php

use yii\db\Migration;

class m170801_092413_create_table_fdd_contract extends Migration
{
    public function Up()
    {
        if (!(Yii::$app->db->getTableSchema('fdd_contract'))) {
            $this->createTable('fdd_contract', array(
                'id' => "int NOT NULL AUTO_INCREMENT PRIMARY KEY",
                'user_id' => "int(11) not null default '0' comment '企业Id'",
                'sign_user_id' => "int(11) not null default '0' comment '签署用户id'",
                'contract_id' => "varchar(32) NOT NULL default '' comment '合同ID'",
                'doc_title' => "varchar(125) NOT NULL default '' comment '合同标题'",
                'file' => "varchar(125) NOT NULL default '' comment '合同文件'",
                'template_id' => "varchar(32) not null default '' comment '模版ID'",
                'parameter' => "varchar(1000) not null default '' comment '合同填充内容'",
                'sign_keyword' => "varchar(50) not null default '' comment '企业定位关键字'",
                'timestamp' => "varchar(16) NOT NULL default '' comment '请求时间'",              
                'status' => "tinyint(1) not null default '0' comment '状态,1,合同请求成功，0,请求失败'",
                'updated_at' => "int(11) not null default '0' comment '更新时间'",
                'created_at' => "int(11) not null default '0' comment '创建时间'",
            ), 'ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT "合同表"');
        }
        
    }

    public function Down()
    {
        echo "m170801_092413_create_table_fdd_contract cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170801_092413_create_table_fdd_contract cannot be reverted.\n";

        return false;
    }
    */
}
