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
}
