<?php

namespace app\controllers;

use app\models\FbHelper;
use pimax\FbBotApp;
use pimax\Messages\Message;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;


class FbController extends Controller
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

    public function actionBot() {

        //page token
        $token = Yii::$app->params['fb_page_token'];
        //verify token
        $verify_token = Yii::$app->params['fb_verify_token'];

        if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe' && $_REQUEST['hub_verify_token'] == $verify_token) {
            echo $_REQUEST['hub_challenge'];
        } else {

            //get request
            $data = json_decode(Yii::$app->request->getRawBody(), true);
            //$data = json_decode(file_get_contents('php://input'), true);
            //print_r($get);

            $fp = fopen('/var/www/btc-bot/messages.log', 'a');
            fwrite($fp, serialize($data) . "--" . "\n");

            if (!empty($data['entry'][0]['messaging'])) {

                foreach ($data['entry'][0]['messaging'] as $message) {

                    if ($message['sender']['id'] && $message['message']['text']) {

                        $bot = new FbBotApp($token);

                        //Delivery status ----------------------
                        if (!empty($message['delivery'])) {
                            continue;
                        }

                        // When bot receive button click from user
                    } else if (!empty($message['postback'])) {
                            $text = "Postback received: ".trim($message['postback']['payload']);
                            $bot->send(new Message($message['sender']['id'], $text));
                            continue;
                    }

                    //Command types ----------------------

                    $command = "";

                    if (!empty($message['message'])) {

                        $command = $message['message']['text'];

                    } else if (!empty($message['postback'])) {

                        $command = $message['postback']['payload'];

                    }

                    //FbHelper usage example
                    $fb_helper = new FbHelper();
                    $fb_helper->messageTemplate($message, $bot);
                    return 1;

                    //Command worker ----------------------

                }

            }

        }

    }
    public function actionBotTest() {

        $token = Yii::$app->params['fb_page_token'];
        $sender_id = Yii::$app->params['fb_test_sender_id'];

        $message = 'hi there. Current time is ' . date("Y-m-d H:i:s");

        $bot = new FbBotApp($token);
        $bot->send(new Message($sender_id, $message));

/*
        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$token;

        // initialize curl
        $ch = curl_init($url);
        // prepare response
        $jsonData = '{
                                        "recipient":{
                                            "id":"' . $sender_id . '"
                                            },
                                            "message":{
                                                "text":"You said, ' . $message . '_!!!' . '"
                                            }
                                        }';
        // curl setting to send a json post data
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        if (!empty($message)) {
            $result = curl_exec($ch); // user will get the message
        }
*/


    }



}
