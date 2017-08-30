<?php

use yii\db\Migration;

class m170802_034605_add_column_user extends Migration
{
    public function safeUp()
    {
        if (!isset(Yii::$app->db->getTableSchema('user')->columns['id_card'])) {           
             $this->addColumn('user', 'id_card', 'varchar(32) not null default "" COMMENT "身份证" after company_name');
        }
        if (!isset(Yii::$app->db->getTableSchema('user')->columns['mobile'])) {           
             $this->addColumn('user', 'mobile', 'varchar(11) not null default "" COMMENT "手机号" after company_name');
        }
         if (!isset(Yii::$app->db->getTableSchema('user')->columns['fdd_ca'])) {           
             $this->addColumn('user', 'fdd_ca', 'varchar(32) not null default "" COMMENT "法大大CA" after company_name');
        }
         if (!isset(Yii::$app->db->getTableSchema('user')->columns['type'])) {           
             $this->addColumn('user', 'type', 'tinyint(1) not null default "1" COMMENT "类别，1.公司，2.个人" after company_name');
        }
    }

    public function Down()
    {
        echo "m170802_034605_add_column_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170802_034605_add_column_user cannot be reverted.\n";

        return false;
    }
    */
}
