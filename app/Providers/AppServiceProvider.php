<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\{
    FileReader,
    JsonParser,
    RepositoryInterface,
    SurveyRepository
};

use App\Questions\{
    QuestionRegistry,
    QcmQuestion,
    NumberQuestion,
    DateQuestion
};
use App\Services\{
    SearchService
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

        $this->app->bind(SearchService::class, function ($app) {
            return new SearchService($app->make(SurveyRepository::class));
        });

        app()->singleton(QcmQuestion::class);
        app()->singleton(NumericQuestion::class);

        app()->singleton(QuestionRegistry::class, function ($app) {
            $registry = new QuestionRegistry();
            $registry->register('qcm', app(QcmQuestion::class));
            $registry->register('numeric', app(NumberQuestion::class));
            $registry->register('date', app(DateQuestion::class));
            return $registry;
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
