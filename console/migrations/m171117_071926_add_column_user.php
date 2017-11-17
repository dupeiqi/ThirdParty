<?php

use yii\db\Migration;

class m171117_071926_add_column_user extends Migration
{
    public function safeUp()
    {
        if (!isset(Yii::$app->db->getTableSchema('user')->columns['is_auto'])) {           
             $this->addColumn('user', 'is_auto', 'tinyint(1) not null default "1" COMMENT "类别，1.自动签章，2.手动签章" after type');
        }
    }

    public function safeDown()
    {
        echo "m171117_071926_add_column_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171117_071926_add_column_user cannot be reverted.\n";

        return false;
    }
    */
}
