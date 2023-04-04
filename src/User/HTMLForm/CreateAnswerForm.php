<?php

namespace Alfs18\User\HTMLForm;

use Alfs18\User\Answers;
use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class CreateAnswerForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param $acronym the name of the one who posted the answer.
     * @param $id the id of the question.
     */
    public function __construct(ContainerInterface $di, $acronym, $id, $text)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Svar",
            ],
            [
                "acronym" => [
                    "type"  => "hidden",
                    "value" => "$acronym",
                ],

                "questionId" => [
                    "type"  => "hidden",
                    "value" => "$id",
                ],

                "answer" => [
                    "type"  => "$text",
                ],

                "points" => [
                    "type"  => "hidden",
                    "value" => 0,
                ],

                "created" => [
                    "type"  => "hidden",
                    "value" => date("Y-m-d, H:i"),
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
        $questionId = $this->form->value("questionId");
        $answer = $this->form->value("answer");
        $points = $this->form->value("points");
        $created = $this->form->value("created");

        // spara info om tid för skapande...

        // Save to database
        $res = new Answers();
        $res->setDb($this->di->get("dbqb"));
        $res->acronym = $acronym;
        $res->questionId = $questionId;
        $res->answer = $res->changeCharacter($answer);
        $res->points = intval($points);
        $res->created = $created;
        $res->saveAnswer($this->di);

        $this->form->addOutput("Answer was created.");
        return true;
    }
}
