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
    public static function getDateSummary($market_id = 'BTC_USD', $date = false) {

        if (!$date) {
            $date = date('Y-m-d');
        }

        $sql = "SELECT *
                FROM 
                  bot_market_data_summary
                WHERE
                date            = :date
                AND market_id   = :market_id
                ;
                ";

        $db = Yii::$app->db->createCommand($sql);
        $db->bindValue(':date', $date);
        $db->bindValue(':market_id', $market_id);

        $res = $db->queryOne();

        return $res;

    }
    public static function setupExtremums($max_buy, $market_id = 'BTC_USD', $date = false) {

        if (!$date) {
            $date = date('Y-m-d');
        }

        $sql = "INSERT INTO 
                  bot_market_data_summary
                (date
                ,exchange_id
                ,market_id
                ,max_buy
                ,min_buy 
                ,updated_at
                )
                VALUES 
                (:date
                ,:exchange_id
                ,:market_id
                ,:max_buy
                ,:min_buy
                ,:updated_at
                )
                ";

        $db = Yii::$app->db->createCommand($sql);
        $db->bindValue(':date', $date);
        $db->bindValue(':exchange_id', 'blockchain.info');
        $db->bindValue(':market_id', $market_id);
        $db->bindValue(':max_buy', $max_buy);
        $db->bindValue(':min_buy', $max_buy);
        $db->bindValue(':updated_at', date('Y-m-d H:i:s'));

        $res = $db->queryOne();

        return $res;

    }
    public static function updateMaxBuy($max_buy, $market_id = 'BTC_USD', $date = false) {

        if (!$date) {
            $date = date('Y-m-d');
        }

        $sql = "UPDATE bot_market_data_summary
                SET 
                  max_buy = :max_buy
                  ,updated_at = now()
                WHERE
                date            = :date
                AND market_id   = :market_id
                ;
                ";

        $db = Yii::$app->db->createCommand($sql);
        $db->bindValue(':date', $date);
        $db->bindValue(':market_id', $market_id);
        $db->bindValue(':max_buy', $max_buy);

        $res = $db->queryOne();

        return $res;

    }
    public static function updateMinBuy($min_buy, $market_id = 'BTC_USD', $date = false) {

        if (!$date) {
            $date = date('Y-m-d');
        }

        $sql = "UPDATE bot_market_data_summary
                SET 
                  min_buy = :min_buy
                  ,updated_at = now()
                WHERE
                date            = :date
                AND market_id   = :market_id
                ;
                ";

        $db = Yii::$app->db->createCommand($sql);
        $db->bindValue(':date', $date);
        $db->bindValue(':market_id', $market_id);
        $db->bindValue(':min_buy', $min_buy);

        $res = $db->queryOne();

        return $res;

    }

}
