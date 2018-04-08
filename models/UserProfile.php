<?php

namespace app\models;

use Yii;
use yii\base\Model;

class UserProfile extends Model
{
    public $id;
    public $external_id;
    public $firstname;
    public $lastname;
    public $pic;
    public $locale;
    public $timezone;
    public $gender;
    public $params = [];

    public function getUserById() {

    }
    public function getUserByExternalId() {

    }
    public function saveProfile() {

        $sql = "INSERT INTO 
                  bot_users
                ( external_id
                , firstname 
                , lastname
                , pic
                , locale
                , timezone
                , gender
                , params
                )
                VALUES 
                ( :external_id
                , :firstname 
                , :lastname
                , :pic
                , :locale
                , :timezone
                , :gender
                , :params
                )
                ;
                ";

        $db = Yii::$app->db->createCommand($sql);
        $db->bindValue(':external_id', $this->external_id);
        $db->bindValue(':firstname', $this->firstname);
        $db->bindValue(':lastname', $this->lastname);
        $db->bindValue(':pic', $this->pic);
        $db->bindValue(':locale', $this->locale);
        $db->bindValue(':timezone', $this->timezone);
        $db->bindValue(':gender', $this->gender);
        $db->bindValue(':params', json_encode($this->params));

        $res = $db->queryOne();

        return $sql;

    }
    public static function getUsers() {

        $sql = "SELECT *
                FROM 
                  bot_users
                ;
                ";

        $db = Yii::$app->db->createCommand($sql);
        $res = $db->queryAll();

        return $res;

    }
    public static function getUsersExternalId() {

        $sql = "SELECT DISTINCT (external_id)
                FROM 
                  bot_users
                ;
                ";

        $db = Yii::$app->db->createCommand($sql);
        $res = $db->queryAll();

        return $res;

    }

}
