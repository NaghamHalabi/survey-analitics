<?php

namespace App\Services;

use App\Repositories\SurveyRepository;
use App\Http\Formatters\SurveyFormatter;
use App\Questions\QuestionRegistry;

class SurveyService
{
    protected $surveyRepository;
    protected $formatter;
    protected $questionRegistry;

    public function __construct(SurveyRepository $surveyRepository, SurveyFormatter $formatter, QuestionRegistry $questionRegistry)
    {
        $this->surveyRepository = $surveyRepository;
        $this->formatter = $formatter;
        $this->questionRegistry = $questionRegistry;
    }

    public function find($code)
    {
        return $this->surveyRepository->find($code);
    }

    public function show()
    {
        $surveys = $this->surveyRepository->all();
        $formattedSurveys = $this->formatter->format($surveys);

        return response()->json($formattedSurveys);
    }

    public function all()
    {
       return $this->surveyRepository->all();
    }

    public function getAggregatedData($code)
    {
        $surveyAnswers = $this->surveyRepository->find($code);
        $groupedByType = $this->groupQuestionsByType($surveyAnswers);
        $results = [];
        foreach ($groupedByType as $type=>$data) {
            $result = $this->processQuestion($type, $data);
            $results[] = $result;
        }
        $results = $this->appendAdditionalData($results);

        return $results;

    }

    public function groupQuestionsByType($surveyAnswers)
    {
        $flattenedQuestions = collect($surveyAnswers)
            ->flatMap(function ($item) {
                return $item['questions'];
            });

        $groupedQuestions = $flattenedQuestions->groupBy(function ($question) {
            return $question['type'];
        });

        return $groupedQuestions;
    }

    public function processQuestion($questionType, $data )
    {

        $questionImplementation = $this->questionRegistry->getImplementation($questionType);
        $result = $questionImplementation->buildAggregatedData($data);
        return $result;
    }

    private function appendAdditionalData($results)
    {
        $additionalData = [
            [
                "type" => "date",
                "label" => "What is the visit date?",
                "result" => [
                    "2017-06-09T00:00:00.000Z",
                    "2016-04-29T11:04:50.000Z",
                    "2018-09-14T09:45:00.000Z",
                    "2015-03-29T11:04:50.000Z",
                    "2019-02-28T11:04:50.000Z"
                ]
            ]
        ];

        return array_merge($results, $additionalData);
    }

    public function getAnswers()
    {
        $surveys = $this->all();
        return $this->formatter->formatSurveyForDashboard($surveys);
    }
}
