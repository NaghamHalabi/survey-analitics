<?php

namespace App\Questions;

class QcmQuestion implements QuestionInterface
{
    public function aggregate($surveyAnswers)
    {
        foreach($surveyAnswers as $question)
        {
            $options = $question['options'];
            foreach ($options as $index => $option) {
                if (!isset($questionResults[$option])) {
                    $questionResults[$option] = 0;
                }
                $questionResults[$option] += $question['answer'][$index] ? 1 : 0;
            }
        }
        return $questionResults;
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
