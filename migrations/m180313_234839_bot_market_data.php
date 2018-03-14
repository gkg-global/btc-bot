<?php

use yii\db\Migration;

/**
 * Class m180313_234839_bot_market_data
 */
class m180313_234839_bot_market_data extends Migration
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
        echo "m180313_234839_bot_market_data cannot be reverted.\n";

        return false;
    }


    public function up() {

        $this->createTable(
            'bot_market_data',
            [
                'id'            =>  'SERIAL'
                ,'timestamp'    =>  'TIMESTAMP'
                ,'exchange_id'  =>  'VARCHAR(32)'
                ,'market_id'    =>  'VARCHAR(16)'
                ,'buy'          =>  'NUMERIC(9,2)'
                ,'sell'         =>  'NUMERIC(9,2)'
                ,'created_at'   =>  'TIMESTAMP WITHOUT TIME ZONE DEFAULT now()'
            ]
        );

    }

    public function down()
    {

        return $this->dropTable('bot_market_data');

    }

}
