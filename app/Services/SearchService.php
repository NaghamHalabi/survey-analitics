<?php

namespace App\Services;

use App\Repositories\SurveyRepository;
use App\Http\Formatters\SurveyFormatter;

class SearchService
{
    private $surveyRepository;
    protected $surveyFormatter;
    private $searchableFields = [
        'name' => 'name',
        'code' => 'code',
    ];

    public function __construct(SurveyRepository $surveyRepository, SurveyFormatter $surveyFormatter)
    {
        $this->surveyRepository = $surveyRepository;
        $this->surveyFormatter = $surveyFormatter;
    }

    public function searchSurveys($term)
    {
        $searchableFields = $this->searchableFields;
        $surveys = $this->surveyRepository->all();
        $surveys = $surveys->filter(function ($survey) use ($term, $searchableFields) {
            return $this->isSearchTermMatching($survey, $term, $searchableFields);
        });
        return $this->surveyFormatter->formatSurveyForDashboard($surveys);
    }

    private function isSearchTermMatching($survey, $term, $searchableFields)
    {
        $termLowercase = strtolower($term);

        foreach ($searchableFields as $field => $key) {
            if (isset($survey['survey'][$key])) {
                $fieldValue = strtolower($survey['survey'][$key]);

                return $fieldValue === $termLowercase;
            }
        }

        return false;
    }
}
