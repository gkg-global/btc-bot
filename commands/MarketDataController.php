<?php

namespace app\commands;

use app\models\MarketData;
use yii\console\Controller;
use yii\httpclient\Client;

class MarketDataController extends Controller
{

    public function actionIndex($message = 'hello world') {

        echo $message . "\n";

    }

    public function actionTicker() {

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('https://blockchain.info/ru/ticker')
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

        }

    }

}
