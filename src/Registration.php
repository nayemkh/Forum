<?php

namespace Registration;

class Controller
{
    public $fieldNames = ['email', 'username', 'password'];

    public $messages = [];

    public function run()
    {
        // Validate submission if form is submitted
        if ($this->checkSubmission()) {
            $validationStatus = $this->validateSubmission($this->getValues());
        }
    }

    public function checkSubmission()
    {
        if (!empty($_POST['submit'])) {
            return true;
        }
    }

    public function getValues()
    {
        if (!empty($_POST['submit'])) {
            $formValues = [];
            foreach ($this->fieldNames as $fieldName) {
                if (isset($_POST[$fieldName]) && trim($_POST[$fieldName]) !== '') {
                    $formValues[$fieldName][] = $_POST[$fieldName];
                }
            }
        }
        return $formValues;
    }

    public function validateSubmission($formValues)
    {
        $validation = false;

        // Check for empty fields
        foreach ($this->fieldNames as $fieldName) {
            if (!isset($formValues[$fieldName])) {
                $this->messages['error'][] = sprintf("The '%s' field must be filled in", ucfirst($fieldName));
            }
        }

        // Pass validation if no errors found
        if (!isset($this->messages['error'])) {
            $validation = true;
        }

        return $validation;
    }
}
