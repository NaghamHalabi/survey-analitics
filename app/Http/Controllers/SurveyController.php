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
        return $this->surveyService->find($code);
    }

    public function show()
    {
        $surveys = $this->surveyService->show();
        return $surveys;
        //return response()->json($surveys);
    }
}
