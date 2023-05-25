<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Services\SearchService;

class SearchController extends Controller
{
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function search(SearchRequest $request)
    {
        $name = $request->input('name');
        $code = $request->input('code');
        $surveys = $this->searchService->searchSurveys($name, $code);

        return response()->json($surveys);
    }
}
