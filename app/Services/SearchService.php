<?php

namespace App\Services;

use App\Repositories\SurveyRepository;

class SearchService
{
    private $surveyRepository;
    private $searchableFields = [
        'name' => 'name',
        'code' => 'code',
    ];

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function searchSurveys($term)
    {
        $searchableFields = $this->searchableFields;
        $surveys = $this->surveyRepository->all();
        $surveys = $surveys->filter(function ($survey) use ($term, $searchableFields) {
            return $this->isSearchTermMatching($survey, $term, $searchableFields);
        });

        return $surveys;
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
