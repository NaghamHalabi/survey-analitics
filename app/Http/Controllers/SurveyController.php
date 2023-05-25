<?php

namespace App\Http\Controllers;

use App\Services\SurveyService;


class SurveyController extends Controller
{
    protected $surveyService;

    public function __construct(SurveyService $surveyService)
    {
        $this->surveyService = $surveyService;
    }

    public function find($code)
    {
        $surveys = $this->surveyService->find($code);
        return response()->json($surveys);
    }

    public function show()
    {
        $surveys = $this->surveyService->show();
        return response()->json($surveys);
    }

    public function getAnswers()
    {
        $surveys = $this->surveyService->getAnswers();
        return response()->json($surveys);
    }

    public function getAggregatedData($code)
    {
        return $this->surveyService->getAggregatedData($code);
    }
}
