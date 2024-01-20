<?php

namespace Login;

use PDOException;

class Controller
{
    public $fieldNames = ['username', 'password'];

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
                    $formValues[$fieldName] = trim($_POST[$fieldName]);
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

        // Check for match in db
        try {
            $conn = connectDatabase();

            $query = 'SELECT username, password FROM users WHERE username = ? LIMIT 1';
            $statement = $conn->prepare($query);
            $statement->execute([$formValues['username']]);

            $results = $statement->fetch();

            if ((isset($results['username']) && (isset($results['password'])) && password_verify($formValues['password'], $results['password']))) {
                $this->messages['success'][] = sprintf('You have successfully logged in, %s.', $formValues['username']);
            } else {
                $this->messages['error'][] = 'Your login details are incorrect.';
            }
        } catch (PDOException $e) {
            $this->messages['error'][] = 'There was an issue connecting to the database, please try again later.';
        }

        // Pass validation if no errors found
        if (!isset($this->messages['error'])) {
            $validation = true;
        }

        return $validation;
    }
}
