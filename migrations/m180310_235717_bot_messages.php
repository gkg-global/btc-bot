<?php

use yii\db\Migration;

/**
 * Class m180310_235717_bot_messages
 */
class m180310_235717_bot_messages extends Migration
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
        echo "m180310_235717_bot_messages cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable(
            'bot_messages',
            [
                'id'            =>  'SERIAL'
                ,'sender_id'    =>  'BIGINT'
                ,'message'      =>  'TEXT'
                ,'intent_id'    =>  'VARCHAR(64)'
                ,'locale'       =>  'VARCHAR(16)'
                ,'created_at'   =>  'TIMESTAMP WITHOUT TIME ZONE DEFAULT now()'
                ,'original_msg' =>  'JSONB'
            ]
        );
    }

    public function down()
    {
        $this->dropTable('bot_messages');
    }

}
