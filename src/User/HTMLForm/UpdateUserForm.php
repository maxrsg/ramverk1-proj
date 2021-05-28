<?php

namespace Magm19\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Magm19\User\User;

/**
 * Example of FormModel implementation.
 */
class UpdateUserForm extends FormModel
{

    private $user;
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $this->user = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Updatera användare",
            ],
            [
                "username" => [
                    "type"        => "text",
                    "label"       => "Användarnamn",
                    "value" => $this->user->username,
                    "validation" => [
                        "not_empty",
                        "custom_test" => [
                            "message" => "Användarnamn kan inte vara längre än 25 bokstäver!",
                            "test" => function ($value) {
                                return strlen($value) <= 25;
                            }
                        ]
                    ],
                ],

                "email" => [
                    "type"        => "email",
                    "label"       => "Email",
                    "validation" => ["not_empty"],
                    "value" => $this->user->email
                ],

                "password" => [
                    "type"        => "password",
                    "label"       => "Skriv in ditt Lösenord för att verifiera ändringarna",
                    "validation" => [
                        "not_empty",
                        "custom_test" => [
                            "message" => "Lösenordet stämmer inte!",
                            "test" => function ($value) {
                                return $this->verifyPassword($this->user->username, $value);
                            }
                        ]
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Spara",
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


        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $this->user->id);
        $user->username = $username;
        $user->email = $email;
        $user->updated = date("Y-m-d H:i:s");
        $user->save();

        $this->form->addOutput("User was created.");
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true.
     */
    public function callbackSuccess()
    {
        $this->di->session->delete("user");
        $this->di->get("response")->redirect("user")->send();
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     *
     * @return Question
     */
    public function getItemDetails($id) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);
        return $user;
    }


    private function verifyPassword($username, $password)
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        return $user->verifyPassword($username, $password);
    }
}
