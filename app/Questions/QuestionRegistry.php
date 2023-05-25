<?php

namespace App\Questions;
use App\Exceptions\QuestionTypeNotFound;

class QuestionRegistry
{
    private $questionImplementations = [];

    public function register($questionType, $questionImplementation)
    {
        $this->questionImplementations[$questionType] = $questionImplementation;
    }

    public function getImplementation($questionType)
    {
        if (isset($this->questionImplementations[$questionType])) {
            return $this->questionImplementations[$questionType];
        }
        throw new QuestionTypeNotFound("No implementation found for question type: $questionType");
    }
}
