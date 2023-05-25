<?php

namespace App\Services;

use App\Repositories\SurveyRepository;
use App\Http\Formatters\SurveyFormatter;

class SurveyService
{
    protected $surveyRepository;
    protected $formatter;
    protected $surveyService;

    public function __construct(SurveyRepository $surveyRepository, SurveyFormatter $formatter)
    {
        $this->surveyRepository = $surveyRepository;
        $this->formatter = $formatter;
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
}
