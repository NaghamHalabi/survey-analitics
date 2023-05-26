<?php

namespace App\Questions;

class NumberQuestion implements QuestionInterface
{
    public function aggregate($answers)
    {
        $sum = 0;
        $count = 0;
        foreach ($answers as $answer) {
            $sum += $answer['answer'];
            $count++;
        }
        return floor($count > 0 ? $sum / $count : 0);
    }

    public function buildAggregatedData($surveyAnswers)
    {
        $aggregatedData = [
            'type' => $surveyAnswers->first()['type'],
            'label' => $surveyAnswers->first()['label'],
            'result' => $this->aggregate($surveyAnswers)
        ];

        return $aggregatedData;
    }
}
