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
        $databaseStatus = null;

        try {
            $db = Database::connect();

            $db->testConnection();

            $databaseStatus = $db->getSimulationResponse();
        } catch (\PDOException | \Exception $e) {
            $databaseError = $e->getMessage();
        }

        $report = [
            'app_name' => \getenv('APP_NAME', 'APP_NAME'),
            'app_url' => \getenv('APP_URL', 'APP_URL'),

            'dependencies' => [
                [
                    'name' => 'database',
                    'status' => $databaseStatus !== null ? $databaseStatus
                        : ($databaseError === null ? 'success'
                            : 'failed'),
                    'error' => $databaseStatus === 'failed' ? 'Simulated status only'
                        : $databaseError,
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

    /**
     * Simulates the database success
     */
    public function simulateSuccess()
    {
        $db = Database::connect();

        $db->setSimulationResponse('success');

        header('Content-Type: application/json');

        echo \json_encode([
            'message' => 'Set database simulated status to success.',
        ]);
    }

    /**
     * Simulates the database success
     */
    public function simulateFailed()
    {
        $db = Database::connect();

        $db->setSimulationResponse('failed');

        header('Content-Type: application/json');

        echo \json_encode([
            'message' => 'Set database simulated status to failed.',
        ]);
    }
}
