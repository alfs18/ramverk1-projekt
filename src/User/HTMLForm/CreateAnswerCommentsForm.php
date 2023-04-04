<?php

namespace Alfs18\User\HTMLForm;

use Alfs18\User\Comments;
use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class CreateAnswerCommentsForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param $acronym the name of the one who posted the comment.
     * @param $aId the answerId.
     */
    public function __construct(ContainerInterface $di, $acronym, $aId)
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

                "answerId" => [
                    "type"  => "hidden",
                    "value" => $aId,
                ],

                "created" => [
                    "type"  => "hidden",
                    "value" => date("d M Y, H:i"),
                ],

                "comment" => [
                    "type"  => "text",
                    "placeholder" => "Kommentera svar",
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
        $aId = $this->form->value("answerId");
        $created = $this->form->value("created");
        $comment = $this->form->value("comment");
        $points = $this->form->value("points");

        // Save to database
        $res = new Comments();
        $res->setDb($this->di->get("dbqb"));
        $res->acronym = $acronym;
        $res->answerId = $aId;
        $res->created = $created;
        $res->comment = $res->changeCharacter($comment);
        $res->points = intval($points);
        $res->saveAnswerComment($this->di);

        $this->form->addOutput("Comment was created.");
        return true;
    }
}
