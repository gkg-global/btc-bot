<?php

namespace app\commands;

use app\controllers\BotCoreController;
use app\models\MarketData;
use yii\console\Controller;
use yii\httpclient\Client;

class MarketDataController extends Controller
{

    public static $volatility_thresholds = [1, 3, 5, 10, 20, 30, 40, 50];

    public function actionIndex($message = 'hello world') {

        echo $message . "\n";

    }

    public function actionTicker() {

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('https://blockchain.info/en/ticker')
            ->send();
        if ($response->isOk) {

            $data = [
                'timestamp'     =>  date('Y-m-d H:i:s')
                ,'exchange_id'  =>  'blockchain.info'
                ,'market_id'    =>  'BTC_USD'
                ,'buy'          =>  round($response->data['USD']['buy'])
                ,'sell'         =>  round($response->data['USD']['sell'])
            ];

            MarketData::saveMarketData($data);

            self::actionFluctuationManager($data);

        }

    }
    public function actionFluctuationManager($data) {

        # 1. Ticker - > Daily / weekly / monthly max & min setup + timestamp of the max & min (ToDo add later min / max from last years.)
        # 2. If the current market price is more or less then 10% -> notify all subscribed users.
        #
        # 3. Сравниваем с макс / мин сегодняшнего дня; далее проверяем в течении текущей недели; далее сравниваем с макс / мин прошлой недели; далее сравниваем с макс - мин прошлого месяца
        #
        # агрегированные макс / мин по дням.
        #
        # date | exchange_id | market_id | max_buy | min_buy | created_at | updated_at
        #

        $date_summary = MarketData::getDateSummary();

        if (!isset($date_summary['max_buy']) || empty($date_summary['max_buy'])) {

            // setup max & min number as $data['buy']
            MarketData::setupExtremums($data['buy']);

        } else if ($data['buy'] > $date_summary['max_buy']) {

            // update new max buy
            MarketData::updateMaxBuy($data['buy']);

            $prev_volatility = round((100 - ($date_summary['min_buy'] / $date_summary['max_buy'] * 100)), 2);
            $volatility = round((100 - ($date_summary['min_buy'] / $data['buy'] * 100)), 2);

            foreach (self::$volatility_thresholds as $key => $threshold) {

                // find threshold match
                if ($threshold <= intval($volatility)) {
                    continue;
                }
                // new volatility threshold thould be higher then previous
                if ($key != 0 && self::$volatility_thresholds[$key-1] > intval($prev_volatility)) {

                    // create Signal
                    $msg = 'BTC-USD to the moon! (' . $volatility . '%)';
                    $msg = 'BTC-USD to the moon today! From '.$date_summary['min_buy'].' to '.$data['buy'].' (' . $volatility . '%)';

                    BotCoreController::createSignal($msg);

                    // stop threshold cycle
                    break;

                }

                // stop threshold cycle
                break;

            }

        } else if ($data['buy'] < $date_summary['min_buy']) {

            // update new min buy
            MarketData::updateMinBuy($data['buy']);

            $prev_volatility = round((100 - ($date_summary['min_buy'] / $date_summary['max_buy'] * 100)), 2);
            $volatility = round((100 - ($data['buy'] / $date_summary['max_buy'] * 100)), 2);

            foreach (self::$volatility_thresholds as $key => $threshold) {

                // find threshold match
                if ($threshold <= intval($volatility)) {
                    continue;
                }
                // new volatility threshold thould be higher then previous
                if ($key != 0 && self::$volatility_thresholds[$key-1] > intval($prev_volatility)) {

                    // create Signal
                    $msg = 'BTC-USD price dropped! From '.$date_summary['max_buy'].' to '.$data['buy'].' (' . $volatility . '%)';

                    BotCoreController::createSignal($msg);

                    // stop threshold cycle
                    break;

                }

                // stop threshold cycle
                break;

            }

        }

        // search for the previous days / weeks / month

    }

}
