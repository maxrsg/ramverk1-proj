<?php

namespace Magm19\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Magm19\User\User;

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
                "legend" => "Create new user",
            ],
            [
                "username" => [
                    "type"        => "text",
                    "label"       => "Username",
                    "validation" => ["not_empty"],
                ],

                "email" => [
                    "type"        => "email",
                    "label"       => "Email",
                    "validation" => ["not_empty"],
                ],

                "password" => [
                    "type"        => "password",
                    "label"       => "Password",
                    "validation" => ["not_empty"],
                ],

                "password-again" => [
                    "type"        => "password",
                    "label"       => "Confirm password",
                    "validation" => [
                        "match" => "password",
                        "not_empty"
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create",
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
        $username      = $this->form->value("username");
        $email         = $this->form->value("email");
        $password      = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");

        // Check password matches
        if ($password !== $passwordAgain ) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        // Save to database
        // $db = $this->di->get("dbqb");
        // $password = password_hash($password, PASSWORD_DEFAULT);
        // $db->connect()
        //    ->insert("User", ["username", "email", "password"])
        //    ->execute([$username, $email, $password]);
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->username = $username;
        $user->email = $email;
        $user->created = date("Y-m-d H:i:s");
        $user->setPassword($password);
        $user->save();

        $this->form->addOutput("User was created.");
        return true;
    }
}
