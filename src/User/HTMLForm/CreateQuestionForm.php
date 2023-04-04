<?php

namespace Alfs18\User\HTMLForm;

use Alfs18\User\Question;
use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class CreateQuestionForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $acronym)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Create question",
            ],
            [
                "acronym" => [
                    "type"  => "hidden",
                    "value" => $acronym,
                ],

                "question" => [
                    "type"  => "textarea",
                ],

                "tags" => [
                    "type"  => "text",
                ],

                "points" => [
                    "type"  => "hidden",
                    "value" => 0,
                ],

                "created" => [
                    "type"  => "hidden",
                    "value" => date("d M Y, H:i"),
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Ställ fråga",
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
        $question = $this->form->value("question");
        $tags = $this->form->value("tags");
        $points = $this->form->value("points");
        $created = $this->form->value("created");

        // Save to database
        $quest = new Question();
        $quest->setDb($this->di->get("dbqb"));
        $quest->acronym = $acronym;
        $quest->question = $quest->changeCharacter($question);
        $quest->tags = $quest->changeCharacter($tags);
        $quest->points = intval($points);
        $quest->created = $created;
        $quest->saveQuestion($this->di);

        $this->form->addOutput("Question was created.");
        return true;
    }
}
