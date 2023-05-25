<?php

namespace App\Http\Formatters;
use  App\Http\Formatters\FormatterInterface;

class SurveyFormatter implements FormatterInterface
{
    public function format($surveys)
    {
        $processedCodes = [];
        $list = [];

        foreach ($surveys as $survey) {
            $code = $survey['survey']['code'];

            if (!in_array($code, $processedCodes)) {
                $processedCodes[] = $code;
                $list[] = [
                    'name' => $survey['survey']['name'],
                    'code' => $code
                ];
            }
        }
        return $list;
    }

    public function formatSurveyForDashboard($surveys)
    {
        $formattedSurveys = [];

        foreach ($surveys as $survey) {
            $formattedSurvey = $this->formatData($survey);
            $formattedSurveys[] = $formattedSurvey;
        }

        return $formattedSurveys;
    }

    public function formatData($data) {
        $formattedData = [
            'survey' => $data['survey'],
            'questions' => []
        ];

        foreach ($data['questions'] as $question) {
          $formattedQuestion = [
            'label' => $question['label'],
            'answer' => $this->getFormattedAnswer($question)
          ];

          $formattedData['questions'][] = $formattedQuestion;
        }

        return $formattedData;
      }

    private function getFormattedAnswer($question) {
        if ($question['type'] === 'qcm') {
            $selectedOptions = [];

            foreach ($question['options'] as $key => $option) {
                if (isset($question['answer'][$key]) && $question['answer'][$key]) {
                    $selectedOptions[] = $option;
                }
            }

            return $selectedOptions;
        } else if ($question['type'] === 'numeric') {
            return $question['answer'];
        }
    }
}



