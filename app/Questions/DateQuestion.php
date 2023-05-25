<?php

namespace App\Questions;

class DateQuestion implements QuestionInterface
{
    public function aggregate($answers)
    {

    }

    public function buildAggregatedData($surveyAnswers)
    {
        $aggregatedData = [
            'type' => "date",
            'label' => "What is the visit date?",
            'result' => [ "2017-06-09T00:00:00.000Z",
            "2016-04-29T11:04:50.000Z",
            "2018-09-14T09:45:00.000Z",
            "2015-03-29T11:04:50.000Z",
            "2019-02-28T11:04:50.000Z"]
        ];

        return $aggregatedData;
    }
}
