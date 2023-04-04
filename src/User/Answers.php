<?php

namespace Alfs18\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * Example of FormModel implementation.
 */
class Answers extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Answers";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $questionId;
    public $acronym;
    public $answer;
    public $points;
    public $created;

    /**
     * Verify the acronym and the password, if successful the object
     * contains all details from the databse row.
     *
     * @param string $acronym acronym to check.
     * @param string $question the question asked.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function saveAnswer($di)
    {
        $db = $di->get("dbqb");
        $db->connect()
            ->insert("Answers", ["questionId", "acronym", "answer", "points", "created"])
            ->execute([$this->questionId, $this->acronym, $this->answer, $this->points, $this->created]);
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
