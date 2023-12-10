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

        // Store data in DB if validation passes
        if (isset($validationStatus) && $validationStatus) {
            $this->storeInfo($this->getValues());
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
                    $formValues[$fieldName] = $_POST[$fieldName];
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

    public function storeInfo($formValues)
    {
        try {
            $conn = connectDatabase();

            // Hash password
            $password = password_hash($formValues['password'], PASSWORD_DEFAULT);

            // Insert data into DB
            $query = 'INSERT INTO users (email, username, password) VALUES (?, ?, ?)';
            $statement = $conn->prepare($query);
            $statement->execute([$formValues['email'], $formValues['username'], $password]);

            $this->messages['success'][] = sprintf('Your registration was successful, %s.', ucfirst($formValues['username']));
        } catch (\PDOException $e) {
            $this->messages['error'][] = 'There was an issue connecting to the database, please try again later.';
        }
    }
}
