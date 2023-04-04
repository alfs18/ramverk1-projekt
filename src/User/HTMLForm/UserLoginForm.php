<?php

namespace Alfs18\User\HTMLForm;

use Alfs18\User\User;
use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
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
                "legend" => "User Login",
                "class" => "login"
            ],
            [
                "user" => [
                    "type"        => "text",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "password" => [
                    "type"        => "password",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Login",
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
        // $this->form->addOutput(
        //     "Trying to login as: "
        //     . $this->form->value("user")
        //     . "<br>Password is kept a secret..."
        //     //. $this->form->value("password")
        // );
        //
        // // Remember values during resubmit, useful when failing (return false)
        // // and asking the user to resubmit the form.
        // $this->form->rememberValues();
        //
        // return true;

        $res = new User();
        // Get values from the submitted form

        $acronym       = $res->changeCharacter($this->form->value("user"));
        $password      = $res->changeCharacter($this->form->value("password"));


        // Try to login
        $db = $this->di->get("dbqb");
        $db->connect();
        $user = $db->select("password")
                   ->from("User")
                   ->where("acronym = ?")
                   ->execute([$acronym])
                   ->fetch();

        // $user is null if user is not found
        if (!$user || !password_verify($password, $user->password)) {
            var_dump($acronym);
            var_dump($password);
           $this->form->rememberValues();
           $this->form->addOutput("User $acronym or password $password did not match.");
           return false;
        }

        // $_SESSION["status"] = "Logga ut";
        // $_SESSION["status_url"] = "user/logout";
        $_SESSION["status"] = [
            "text" => "Profil",
            "url" => "user/profile",
            "title" => "Profil",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Logga ut",
                        "url" => "user/logout",
                        "title" => "Logga ut",
                    ],
                ],
            ],
        ];
        $_SESSION["acronym"] = $acronym;
        // $this->form->addOutput("User logged in.");
        return true;
    }
}
