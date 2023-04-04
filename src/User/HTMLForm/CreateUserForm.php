<?php

namespace Alfs18\User\HTMLForm;

use Alfs18\User\User;
use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Create user",
            ],
            [
                "acronym" => [
                    "type"  => "text",
                ],

                "password" => [
                    "type"  => "password",
                ],

                "password-again" => [
                    "type"  => "password",
                    "validation" => [
                        "match" => "password"
                    ]
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
                    "value" => "Create user",
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
        $user = new User();
        // Get values from the submitted form
        $acronym = $this->form->value("acronym");
        $password = $user->changeCharacter($this->form->value("password"));
        $passwordAgain = $user->changeCharacter($this->form->value("password-again"));
        $points = $this->form->value("points");
        $created = $this->form->value("created");

        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password dig not match.");
            return false;
        }

        // Save to database
        // $db = $this->di->get("dbqb");
        // $password = password_hash($password, PASSWORD_DEFAULT);
        // $db->connect()
        //     ->insert("User", ["acronym", "password"])
        //     ->execute([$acronym, $password]);
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->acronym = $user->changeCharacter($acronym);
        $password = $user->changeCharacter($password);
        $user->setPassword($password);
        $user->setPicture($this->di);
        $user->points = intval($points);
        $user->created = $created;
        $user->saveUser($this->di);

        $this->form->addOutput("User was created.");
        return true;
    }
}
