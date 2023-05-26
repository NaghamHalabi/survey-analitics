<?php
namespace App\Questions;

interface QuestionInterface
{
    public function aggregate(array $answers);
    public function buildAggregatedData($data);
}
