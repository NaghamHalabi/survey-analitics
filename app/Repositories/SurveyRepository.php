<?php

namespace App\Repositories;

use App\Repositories\FileReader;

class SurveyRepository implements RepositoryInterface
{
    protected $fileReader;

    public function __construct(FileReader $fileReader)
    {
        $this->fileReader = $fileReader;
    }

    public function find($code)
    {
        $surveys = $this->fileReader->readData();
        $surveyList = [];
        foreach ($surveys as $survey) {
            if ($survey['survey']['code'] === $code) {
                $surveyList[] = $survey;
            }
        }
        return collect($surveyList);
    }


    public function all()
    {
        $surveys = $this->fileReader->readData();
        return collect($surveys);
    }

    public function count()
    {

    }
}
