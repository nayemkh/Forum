<?php

namespace Registration;

class Controller
{
    public function run()
    {
        if ($this->checkSubmission()) {
            $this->getValues();
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
        $fieldNames = ['email', 'username', 'password'];

        if (!empty($_POST['submit'])) {
            $formValues = [];
            foreach ($fieldNames as $fieldName) {
                if (isset($_POST[$fieldName]) && trim($_POST[$fieldName]) !== '') {
                    $formValues[$fieldName] = $_POST[$fieldName];
                }
            }
        }

        return $formValues;
    }
}
