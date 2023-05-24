<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\{
    FileReader,
    JsonParser,
    RepositoryInterface,
    SurveyRepository
};


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $dataPath = storage_path('app/data');
        $jsonParser = new JsonParser();
        $fileReader = new FileReader($dataPath, $jsonParser);

        $surveyRepository = new SurveyRepository($fileReader, $jsonParser);

        $this->app->bind(SurveyRepository::class, function ($app) use ($surveyRepository) {
            return $surveyRepository;
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
