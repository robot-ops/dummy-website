<?php

use App\Http\Controllers\DataloggerController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes - Datalogger Dashboard
|--------------------------------------------------------------------------
*/

// Main Dashboard
Route::get('/', [DataloggerController::class, 'index'])->name('dashboard.main');

// API Routes untuk Ajax
Route::prefix('api/datalogger')->group(function () {

    // Get history data with pagination and sorting
    Route::get('/history', [DataloggerController::class, 'getHistory'])->name('api.datalogger.history');

    // Get realtime data
    Route::get('/realtime', [DataloggerController::class, 'getRealtimeData'])->name('api.datalogger.realtime');

    // Get chart data
    Route::get('/chart', [DataloggerController::class, 'getChartData'])->name('api.datalogger.chart');

    // Get statistics
    Route::get('/statistics', [DataloggerController::class, 'getStatistics'])->name('api.datalogger.statistics');

    // Download routes
    Route::get('/download/csv', [DataloggerController::class, 'downloadCSV'])->name('api.datalogger.download.csv');
    Route::get('/download/excel', [DataloggerController::class, 'downloadExcel'])->name('api.datalogger.download.excel');

    // Store new data (for testing)
    Route::post('/store', [DataloggerController::class, 'store'])->name('api.datalogger.store');

    // Generate sample data
    Route::post('/generate-sample', [DataloggerController::class, 'generateSampleData'])->name('api.datalogger.generate');
});
