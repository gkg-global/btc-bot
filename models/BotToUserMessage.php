<?php

namespace app\models;

use Yii;
use yii\base\Model;

class BotToUserMessage extends Model
{
    public $id;
    public $recipient_id;
    public $message;
    public $message_type;

    public function getMessageById() {

    }
    public function getMessagesByIntentId() {

    }
    public function saveMessage($msg = false) {

        $sql = "INSERT INTO 
                  bot_to_user_messages
                ( recipient_id
                , message 
                , message_type
                )
                VALUES 
                ( :recipient_id
                , :message
                , :message_type               
                )
                ;
                ";

        $db = Yii::$app->db->createCommand($sql);
        $db->bindValue(':recipient_id', $this->recipient_id);
        $db->bindValue(':message', $this->message);
        $db->bindValue(':message_type', $this->message_type);

        $res = $db->queryOne();

        return $sql;

    }

}
