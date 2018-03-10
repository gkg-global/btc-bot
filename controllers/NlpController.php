<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;


class NlpController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout'],
                'rules' => [
                    [
                        'allow' => true,
                        //'actions' => ['login', 'signup'],
                        //'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        //'actions' => ['login','signup','logout','about','index','contact' ],
                        //'roles' => ['?'],
                    ],
                ],

            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {

        // To bypass from FB bot
        $this->enableCsrfValidation = false;

        // To get original post data from FB bot
        //$this->post_orig_data = Yii::$app->request->getRawBody();

        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        echo 'Test is ok';
    }

    public function actionTest() {

        echo 'Test is ok';

    }
    //NLP processing via Dialogflow API v1
    public static function processNLP($intent = 'Hello!') {

        $postData = array('query' => array($intent), 'lang' => 'en', 'sessionId' => time());
        $jsonData = json_encode($postData);
        $v = date('Ymd');

        $ch = curl_init('https://api.api.ai/v1/query?v='.$v);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer '.Yii::$app->params['dialogflow_auth_key']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch));
        //print_r($result->result->fulfillment->speech);
        curl_close($ch);

        return $result;

    }

}
