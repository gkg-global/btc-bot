<?php

use yii\db\Migration;

/**
 * Class m180407_173209_bot_users
 */
class m180407_173209_bot_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180407_173209_bot_users cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable(
            'bot_users',
            [
                'id'            =>  'SERIAL'
                ,'external_id'  =>  'BIGINT'
                ,'firstname'    =>  'VARCHAR(32)'
                ,'lastname'     =>  'VARCHAR(32)'
                ,'pic'          =>  'VARCHAR(512)'
                ,'locale'       =>  'VARCHAR(16)'
                ,'timezone'     =>  'VARCHAR(16)'
                ,'gender'       =>  'VARCHAR(8)'
                ,'params'       =>  'TEXT'
                ,'created_at'   =>  'TIMESTAMP WITHOUT TIME ZONE DEFAULT now()'
            ]
        );

    }

    public function down()
    {
        $this->dropTable('bot_users');

    }

}
