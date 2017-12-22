<?php

use yii\db\Migration;

class m171222_021712_add_column_fdd_template extends Migration
{
    public function Up()
    {
       if (!isset(Yii::$app->db->getTableSchema('fdd_template')->columns['is_auto'])) {
            $this->addColumn('fdd_template', 'is_auto', 'tinyint(1) not null default "1" COMMENT "类别，1.自动签章，2.手动签章" after template_id');           
        }
    }

    public function Down()
    {
        echo "m171222_021712_add_column_fdd_template cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171222_021712_add_column_fdd_template cannot be reverted.\n";

        return false;
    }
    */
}
