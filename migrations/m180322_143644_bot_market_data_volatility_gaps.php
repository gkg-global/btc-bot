<?php

use yii\db\Migration;

/**
 * Class m180322_143644_bot_market_data_volatility_gaps
 */
class m180322_143644_bot_market_data_volatility_gaps extends Migration
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
        echo "m180322_143644_bot_market_data_volatility_gaps cannot be reverted.\n";

        return false;
    }

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable(
            'bot_market_data_volatility_gaps',
            [
                'id'                =>  'SERIAL'
                ,'buy_from'         =>  'NUMERIC(9,2)'
                ,'buy_to'           =>  'NUMERIC(9,2)'
                ,'volatility_gap'   =>  'INT'
                ,'created_at'       =>  'TIMESTAMP WITHOUT TIME ZONE DEFAULT now()'
            ]
        );
    }

    public function down()
    {
        $this->dropTable('bot_market_data_volatility_gaps');
    }
}
