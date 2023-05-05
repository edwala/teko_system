<?php

use Spatie\Health\ResultStores\EloquentHealthResultStore;

return [

	/*
    |--------------------------------------------------------------------------
    | Pages
    |--------------------------------------------------------------------------
    |
    | This is the configuration for the general appearance of the page
    | in admin panel.
    |
    */

	'pages' => [
		'health' => \ShuvroRoy\FilamentSpatieLaravelHealth\Pages\HealthCheckResults::class
    ],

    'result_stores' => [
        Spatie\Health\ResultStores\EloquentHealthResultStore::class => [
            'model' => Spatie\Health\Models\HealthCheckResultHistoryItem::class,
            'keep_history_for_days' => 5,
        ],
    ],

];
