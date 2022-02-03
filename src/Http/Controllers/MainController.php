<?php

namespace ApperPH\SamplePHPApplication\Http\Controllers;

use Pecee\SimpleRouter\SimpleRouter as Router;
use ApperPH\SamplePHPApplication\Services\Database;

class MainController
{
    /**
     * Index controller
     */
    public function index()
    {
        header('Content-Type: application/json');

        echo \json_encode([
            'message' => 'Welcome to Sample PHP Application!',
        ]);
    }

    /**
     * Health check controller
     */
    public function healthCheck()
    {
        header('Content-Type: application/json');

        $databaseError = null;

        try {
            Database::try();
        } catch (\PDOException | \Exception $e) {
            $databaseError = $e->getMessage();
        }

        $report = [
            'app_name' => \getenv('APP_NAME', 'APP_NAME'),
            'app_url' => \getenv('APP_URL', 'APP_URL'),

            'dependencies' => [
                [
                    'name' => 'database',
                    'status' => $databaseError === null ? 'success' : 'failed',
                    'error' => $databaseError,
                ],
                [
                    'name' => 'sample',
                    'status' => 'success',
                    'error' => null,
                ],
            ],
        ];

        echo \json_encode($report);
    }

    protected function tryDatabase()
    {}
}
