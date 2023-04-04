<?php

namespace Alfs18\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * Example of FormModel implementation.
 */
class Comments extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comments";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     * @var integer $questionId the id of the question the
     *                          comment is connected to.
     * @var integer $answerId the id of the answer the
     *                        comment is connected to.
     * @var string $acronym the creator of the comment.
     * @var string $comment the comment.
     * @var integer $points the points of the comment.
     * @var string $created date and time of comment's creation.
     */
    public $id;
    public $questionId;
    public $answerId;
    public $acronym;
    public $comment;
    public $points;
    public $created;

    /**
     * Save comment to database.
     *
     * @param object $di.
     *
     * @return void
     */
    public function saveComment($di)
    {
        $db = $di->get("dbqb");
        $db->connect()
            ->insert("Comments", ["questionId", "acronym", "comment", "points", "created"])
            ->execute([$this->questionId, $this->acronym, $this->comment, $this->points, $this->created]);
    }


    /**
     * Save answer comment to database.
     *
     * @param object $di.
     *
     * @return void
     */
    public function saveAnswerComment($di)
    {
        $db = $di->get("dbqb");
        $db->connect()
            ->insert("AnswerComments", ["answerId", "acronym", "comment", "points", "created"])
            ->execute([$this->answerId, $this->acronym, $this->comment, $this->points, $this->created]);
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
