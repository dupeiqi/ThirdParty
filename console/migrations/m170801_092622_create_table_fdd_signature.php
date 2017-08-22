<?php

use yii\db\Migration;

class m170801_092622_create_table_fdd_signature extends Migration
{
    public function Up() {
        if (!(Yii::$app->db->getTableSchema('fdd_signature'))) {
            $this->createTable('fdd_signature', array(
                'id' => "int NOT NULL AUTO_INCREMENT PRIMARY KEY",
                'user_id' => "int(11) not null default '0' comment '企业Id'",
                'sign_user_id' => "int(11) not null default '0' comment '签署用户id'",
                'transaction_id' => "varchar(32) NOT NULL default '' comment '交易号'",
                'contract_id' => "varchar(32) NOT NULL default '' comment '合同ID'",
                'customer_id' => "varchar(32) NOT NULL default '' comment '客户编号CA注册'",
                'doc_title' => "varchar(125) NOT NULL default '' comment '合同标题'",
                'client_role' => "tinyint(1) not null default '0' comment '客户角色:1-接入平台 2-担保公司3-投资人 4-借款人'",
                'sign_keyword' => "varchar(125) NOT NULL default '' comment '定位关键字'",
                'download_url' => "varchar(255) NOT NULL default '' comment '合同下载地址'",
                'viewpdf_url' => "varchar(255) NOT NULL default '' comment '合同查看地址'",
                'status' => "tinyint(1) not null default '0' comment '状态,1,签署成功，0,签署失败'",
                'timestamp' => "varchar(16) NOT NULL default '' comment '请求时间'",
                'updated_at' => "int(11) not null default '0' comment '更新时间'",
                'created_at' => "int(11) not null default '0' comment '创建时间'",
                    ), 'ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT "商务签署表"');
        }
    }

    public function Down()
    {
        echo "m170801_092622_create_table_fdd_signature cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170801_092622_create_table_fdd_signature cannot be reverted.\n";

        return false;
    }
    */
}
