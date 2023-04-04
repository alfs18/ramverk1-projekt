<?php

namespace Alfs18\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * Example of FormModel implementation.
 */
class Question extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Question";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $acronym;
    public $question;
    // public $qComments;
    // public $answer;
    // public $aComments;
    public $tags;
    public $points;
    public $created;
    public $updated;
    public $deleted;

    /**
     * Verify the acronym and the password, if successful the object
     * contains all details from the databse row.
     *
     * @param string $acronym acronym to check.
     * @param string $question the question asked.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function saveQuestion($di)
    {
        $db = $di->get("dbqb");
        // $db->connect();
        // $user = $db->select("question, tags")
        //            ->from("Question")
        //            ->where("acronym = ?")
        //            ->execute([$this->acronym])
        //            ->fetchAll();
        // var_dump($user)
        $db->connect()
            ->insert("Question", ["acronym", "question", "tags", "points", "created"])
            ->execute([$this->acronym, $this->question, $this->tags, $this->points, $this->created]);
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
