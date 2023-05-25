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
        $term = $request->input('term');
        $surveys = $this->searchService->searchSurveys($term);

        return response()->json($surveys);
    }
}
