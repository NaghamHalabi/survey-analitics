<?php

namespace App\Services;

use App\Repositories\SurveyRepository;

class SearchService
{
    private $surveyRepository;

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function searchSurveys($name, $code)
    {
        $surveys = $this->surveyRepository->all();
        if ($name) {
            $surveys = $surveys->where('survey.name', $name);
        }

        if ($code) {
            $surveys = $surveys->where('survey.code', $code);
        }

        return $surveys;
    }
}
