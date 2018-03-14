<?php

namespace app\models;

use Yii;
use yii\base\Model;

class MarketData extends Model
{

    public static function saveMarketData($data) {

        $sql = "INSERT INTO 
                  bot_market_data
                (timestamp
                ,exchange_id
                ,market_id
                ,buy
                ,sell 
                )
                VALUES 
                (:timestamp
                ,:exchange_id
                ,:market_id
                ,:buy
                ,:sell 
                )
                RETURNING id;
                ";

        $db = Yii::$app->db->createCommand($sql);
        $db->bindValue(':timestamp', $data['timestamp']);
        $db->bindValue(':exchange_id', $data['exchange_id']);
        $db->bindValue(':market_id', $data['market_id']);
        $db->bindValue(':buy', $data['buy']);
        $db->bindValue(':sell', $data['sell']);

        $res = $db->queryOne();

        return $res;

    }

}
