<?php

use yii\db\Migration;

/**
 * Class m180314_232502_market_data_summary
 */
class m180314_232502_market_data_summary extends Migration
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
        echo "m180314_232502_market_data_summary cannot be reverted.\n";

        return false;
    }

    public function up() {

        $this->createTable(
            'bot_market_data_summary',
            [
                'id'            =>  'SERIAL'
                ,'date'         =>  'DATE'
                ,'exchange_id'  =>  'VARCHAR(32)'
                ,'market_id'    =>  'VARCHAR(16)'
                ,'max_buy'      =>  'NUMERIC(9,2)'
                ,'min_buy'      =>  'NUMERIC(9,2)'
                ,'created_at'   =>  'TIMESTAMP WITHOUT TIME ZONE DEFAULT now()'
                ,'updated_at'   =>  'TIMESTAMP WITHOUT TIME ZONE'
            ]
        );

    }

    public function down()
    {

        return $this->dropTable('bot_market_data_summary');

    }

}
