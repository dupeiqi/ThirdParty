<?php

use yii\db\Migration;

class m170829_031628_add_column_fdd_template extends Migration
{
    public function safeUp() {
        
        if (!isset(Yii::$app->db->getTableSchema('fdd_template')->columns['sign_keyword'])) {
            $this->addColumn('fdd_template', 'sign_keyword', 'varchar(125) not null default "" COMMENT "定位关键字" after template_id');
        }
    }

    public function safeDown()
    {
        echo "m170829_031628_add_column_fdd_template cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170829_031628_add_column_fdd_template cannot be reverted.\n";

        return false;
    }
    */
}
