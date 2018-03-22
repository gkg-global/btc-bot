<?php

use yii\db\Migration;

/**
 * Class m180322_002111_bot_to_user_messages
 */
class m180322_002111_bot_to_user_messages extends Migration
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
        echo "m180322_002111_bot_to_user_messages cannot be reverted.\n";

        return false;
    }

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable(
            'bot_to_user_messages',
            [
                'id'            =>  'SERIAL'
                ,'recipient_id' =>  'BIGINT'
                ,'message'      =>  'TEXT'
                ,'message_type' =>  'VARCHAR(32)'
                ,'created_at'   =>  'TIMESTAMP WITHOUT TIME ZONE DEFAULT now()'
            ]
        );
    }

    public function down()
    {
        $this->dropTable('bot_to_user_messages');
    }
}
