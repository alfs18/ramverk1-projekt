<?php

namespace Alfs18\User\HTMLForm;

use Alfs18\User\Comments;
use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class CreateCommentsForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param $acronym the name of the one who posted the comment.
     * @param $qId the questionId.
     */
    public function __construct(ContainerInterface $di, $acronym, $qId)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                // "legend" => "Kommentera",
                "class" => "comments",
            ],
            [
                "acronym" => [
                    "type"  => "hidden",
                    "value" => $acronym,
                ],

                "questionId" => [
                    "type"  => "hidden",
                    "value" => $qId,
                ],

                "created" => [
                    "type"  => "hidden",
                    "value" => date("d M Y, H:i"),
                ],

                "comment" => [
                    "type"  => "text",
                    "placeholder" => "Kommentera",
                ],

                "points" => [
                    "type"  => "hidden",
                    "value" => 0,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Skicka",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $acronym = $this->form->value("acronym");
        $qId = $this->form->value("questionId");
        $created = $this->form->value("created");
        $comment = $this->form->value("comment");
        $points = $this->form->value("points");

        // Save to database
        $res = new Comments();
        $res->setDb($this->di->get("dbqb"));
        $res->acronym = $acronym;
        $res->questionId = $qId;
        $res->created = $created;
        $res->comment = $res->changeCharacter($comment);
        $res->points = intval($points);
        // var_dump("Hello");
        // var_dump($res);
        $res->saveComment($this->di);

        $this->form->addOutput("Comment was created.");
        return true;
    }
}
