<?php

namespace app\models;

use Yii;
use yii\base\Model;

class BotMessage extends Model
{
    public $id;
    public $sender_id;
    public $message;
    public $intent_id;
    public $locale;
    public $created_at;
    public $original_msg;
    public $returning_id;

    public function getMessageById() {

    }
    public function getMessagesByIntentId() {

    }
    public function saveMessage($msg = false) {

        $sql = "INSERT INTO 
                  bot_messages
                ( sender_id
                , message
                , original_msg 
                )
                VALUES 
                ( :sender_id
                , :message
                , :original_msg 
                )
                RETURNING id;
                ";

        $data = Yii::$app->db->createCommand($sql);
        $data->bindValue(':sender_id', $this->sender_id);
        $data->bindValue(':message', $this->message);
        $data->bindValue(':original_msg', $this->original_msg);

        $res = $data->queryOne();

        $this->returning_id = $res['id'];

        return $this->returning_id;

    }
    public function updateMessageNlpData() {

        $sql = "UPDATE 
                  bot_messages
                SET
                  intent_id   = :intent_id
                  ,locale     = :locale
                WHERE 
                  id          = :id
                ;
                ";

        $data = Yii::$app->db->createCommand($sql);
        $data->bindValue(':intent_id', $this->intent_id);
        $data->bindValue(':locale', $this->locale);
        $data->bindValue(':id', $this->returning_id);

        return $data->queryOne();

    }

}
