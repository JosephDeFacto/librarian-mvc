<?php


namespace App\Core;


class Validator
{
    public $errors = [];

    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    public function isValidPhoneNumber($value)
    {

    }

    public function value($value)
    {
        $this->$value = $value;

        return $this;
    }

    public function match($value)
    {
        if ($this->$value != $value) {
            $this->errors[] = "Values must match";
        }
    }
    public function isEmail($value)
    {
       if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
           return true;
       }
    }

    public function pswdLength($name)
    {
        if ($name < 8) {
            $this->errors[] = "Password must contains at least 8 characters";
        }
    }

    public function isEmpty($name)
    {
        if (empty($this->name)) {
            return "Field(s) must be filled in";
        }
    }
    /*
    public function isEmpty($name)
    {
        if (empty($this->$name)) {
            $this->errors[] = "Field(s) cannot be empty.";
        }
    }
    */

    public function success()
    {
        if (empty($this->errors)) {
            return "OK";
        }
    }

    public function getErrors()
    {
        if (!$this->success()) {
            return $this->errors;
        }

    }

    public function displayErrors()
    {
        $output = '<ul>';
        foreach ($this->getErrors() as $error) {
            $output .= '<li>' . $error . '</li>';
        }
        $output = '</ul>';

        return $output;
    }
}