<?php

namespace App\Controllers;

use App\Controllers\UserController;

class UserValidationController
{
    private $data;
    private $errors = [];
    private $fields = ['email', 'name', 'last_name', 'phone', 'password', 'repeat_password'];
    private $users;

    public function __construct($registrationData) {
        $this->data = $registrationData;
        $this->users = new UserController;
    }

    public function validateForm()
    {
        //Check if all of the fields keys exist
        foreach ($this->fields as $field) {
            if(!array_key_exists($field, $this->data)){
                trigger_error($field. " Laukelis nerastas");
                return;
            }
        }

        //Call functions for validating every field of registration form
        $this->validateEmail();
        $this->validatePersonalDetails();
        $this->validatePhone();
        $this->validatePassword();

        //Create user if there are no errors
        if (empty($this->errors)) {
            $this->users->registerUser($this->data);
        } else {
            //Return array of errors
            return $this->errors;
        }
    }

    private function validateEmail()
    {
        //Remove any spaces from input field
        $email = trim($this->data['email']);
        //Check if value is not empty
        if (empty($email)) {
            $this->addError('email', 'El. pašto laukelis negali būti tuščias');
        //Check if email is valid
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('email', 'Neteisingai įvestas el. pašto laukelis');
        } else {
        //Check if email doesn't exit in database
            if (!$this->validateUniqueEmail($email)) {
                $this->addError('email', 'Vartotojas su tokiu el. pašto adresu jau registruotas');
            }
        }

    }

    private function validatePersonalDetails()
    {
        //Remove any spaces from input field and store it in array
        $details = [
            'name' => trim($this->data['name']),
            'last_name' => trim($this->data['last_name']
        )];

        foreach ($details as $key => $detail) {
            //Check if input field value is not empty
            if (empty($detail)) {
                $this->addError($key, 'Vardo ir pavardės laukelis negali būti tuščias');
                //Check if name and last name fields have no numbers, atleast one letter and not more than 30 letters.
            } elseif (!preg_match('/^[A-Za-z-ĄČĘĖĮŠŲŪąčęėįšųū]{1,30}$/', $detail)) {
                $this->addError($key, 'Vardo ir pavardės laukelis turi būti 1-30 raidžių, laukeli gali sudaryti tik raidės');
            }
        }
    }

    private function validatePhone()
    {
        //Remove any spaces from input field
        $phone = trim($this->data['phone']);
        //Check if input field value is not empty
        if (empty($phone)) {
            $this->addError('phone', 'Telefonu numerio laukelis negali būti tuščias');
        //Check if phone number is between 8 and 11
        } elseif (!preg_match('/^[0-9]{8,11}$/', $phone)) {
            $this->addError('phone', 'Telefono numerio laukelis turi būti 8-12 skaičių');
        }
    }

    private function validatePassword()
    {
        //Remove any spaces from input field
        $password = trim($this->data['password']);
        $confirmPassword = trim($this->data['repeat_password']);

        //Check if bouth password fields are not empty
        if (empty($password) || empty($confirmPassword)) {
            $this->addError('password', 'Slaptažodžio laukelis negali būti tuščias');
        //Check if bouth passwords are the same
        } elseif ($password != $confirmPassword) {
            $this->addError('password', 'Slaptažodžiai turi sutapti');
        //Password need to have upercase letter a number and have between 8 and 12 symbols
        } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,12}$/', $password)) {
            $this->addError('password', 'Slaptažodį turi sudaryti bent viena didžioji raidė, skaičius ir būti 8-12 simbolių');
        }

    }
        
    private function validateUniqueEmail($email)
    {
        $getUserByEmail = $this->users->findUserByEmail($email);

        //Check if we found a user
        if(!empty($getUserByEmail)){
            return false;
        }
        return true;
    }

    private function addError($key, $value)
    {
        //Add error to array with a key name of error and message
        $this->errors[$key] = $value;
    }
}
