<?php

use yii\db\Migration;

class m171212_014031_add_column_fdd_contract extends Migration
{
    public function safeUp() {
        if (!isset(Yii::$app->db->getTableSchema('fdd_contract')->columns['callback'])) {
            $this->addColumn('fdd_contract', 'callback', 'varchar(200) not null default "" COMMENT "跳转网址" after sign_keyword');
        }
    }

    public function safeDown()
    {
        echo "m171212_014031_add_column_fdd_contract cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171212_014031_add_column_fdd_contract cannot be reverted.\n";

        return false;
    }
    */
}
