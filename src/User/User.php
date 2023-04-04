<?php

namespace Alfs18\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * Example of FormModel implementation.
 */
class User extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "User";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $acronym;
    public $password;
    public $info;
    public $points;
    public $picture;
    public $created;
    public $updated;
    public $deleted;
    public $active;

    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }



    /**
     * Set the profile picture.
     *
     * @param object $di
     *
     * @return void
     */
    public function setPicture($di)
    {
        $db = $di->get("dbqb");
        $db->connect();
        $res = $db->select("name")
                   ->from("Pictures")
                   ->where("acronym = ?")
                   ->execute(["default"])
                   ->fetchAll();

        $array = [];
        foreach ($res as $val) {
            // var_dump($val->name);
            array_push($array, $val->name);
        }
        // var_dump($array);

        $pic = array_rand($array, 1);
        // var_dump($array[$pic]);
        $this->picture = $array[$pic];
    }



    /**
     * Verify the acronym and the password, if successful the object
     * contains all details from the databse row.
     *
     * @param string $acronym acronym to check.
     * @param string $password the password to use.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function verifyPassword($acronym, $password)
    {
        $this->find("acronym", $acronym);
        return password_verify($password, $this->password);
    }


    /**
     * Verify the acronym and the password, if successful the object
     * contains all details from the databse row.
     *
     * @param string $acronym acronym to check.
     * @param string $password the password to use.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function saveUser($di)
    {
        $db = $di->get("dbqb");
        $db->connect()
            ->insert("User", ["acronym", "password", "picture", "points", "created"])
            ->execute([$this->acronym, $this->password, $this->picture, $this->points, $this->created]);
    }


    /**
     * Change character to ÅÄÖ if needed.
     *
     * @param string $text     The string/text to be checked.
     *
     * @return array
     */
    public function changeCharacter($text)
    {
        $characters = [
            "/&Aring;/" => "Å",
            "/&aring;/" => "å",
            "/&Auml;/" => "Ä",
            "/&auml;/" => "ä",
            "/&Ouml;/" => "Ö",
            "/&ouml;/" => "ö"
        ];

        foreach ($characters as $key => $val) {
            $text = preg_replace($key, $val, $text);
        }
        return $text;
    }
}
