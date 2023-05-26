<?php

namespace App\Services;

use App\Repositories\SurveyRepository;
use App\Http\Formatters\SurveyFormatter;
use Illuminate\Support\Facades\Config;
class SearchService
{
    private $surveyRepository;
    protected $surveyFormatter;

    public function __construct(SurveyRepository $surveyRepository, SurveyFormatter $surveyFormatter)
    {
        $this->surveyRepository = $surveyRepository;
        $this->surveyFormatter = $surveyFormatter;
    }

    public function searchSurveys($term)
    {
        $searchableFields = Config::get('search.searchableFields');

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

                if ($fieldValue === $termLowercase) {
                    return true;
                }
            }
        }

        return false;
    }
}
