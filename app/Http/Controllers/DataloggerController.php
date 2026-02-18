<?php

namespace App\Http\Controllers;

use App\Exports\DataloggerExport;
use App\Models\Datalogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class DataloggerController extends Controller
{
    /**
     * Display the main dashboard
     */
    public function index()
    {
        return view('dashboard.main');
    }

    /**
     * Get datalogger history with pagination and sorting
     */
    public function getHistory(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $sortBy = $request->get('sort_by', 'logged_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Datalogger::query();

        // Filter by date range if provided
        if ($startDate && $endDate) {
            $query->filterByDateRange($startDate, $endDate);
        }

        // Apply sorting
        $query->orderBy($sortBy, $sortOrder);

        $data = $query->paginate($perPage);

        return response()->json($data);
    }

    /**
     * Get latest data for realtime monitoring
     */
    public function getRealtimeData(Request $request)
    {
        $limit = $request->get('limit', 1);

        $latestData = Datalogger::orderBy('logged_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json($latestData);
    }

    /**
     * Get data for chart visualization
     */
    public function getChartData(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $limit = $request->get('limit', 100);

        $query = Datalogger::query();

        if ($startDate && $endDate) {
            $query->filterByDateRange($startDate, $endDate);
        }

        $data = $query->orderBy('logged_at', 'desc')
            ->limit($limit)
            ->get(['logged_at', 'data1', 'data2'])
            ->reverse()
            ->values();

        return response()->json($data);
    }

    /**
     * Download data as CSV
     */
    public function downloadCSV(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Datalogger::query();

        if ($startDate && $endDate) {
            $query->filterByDateRange($startDate, $endDate);
        }

        $data = $query->orderBy('logged_at', 'asc')->get();

        $filename = 'datalogger_export_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, ['ID', 'Data 1', 'Data 2', 'Logged At', 'Created At', 'Updated At']);

            // Add data rows
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->id,
                    $row->data1,
                    $row->data2,
                    $row->logged_at,
                    $row->created_at,
                    $row->updated_at,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Download data as Excel
     */
    public function downloadExcel(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Datalogger::query();

        if ($startDate && $endDate) {
            $query->filterByDateRange($startDate, $endDate);
        }

        $data = $query->orderBy('logged_at', 'asc')->get();

        // Note: This requires maatwebsite/excel package
        // Install with: composer require maatwebsite/excel
        return Excel::download(new DataloggerExport($data), 'datalogger_export_' . date('Y-m-d_His') . '.xlsx');
    }

    /**
     * Store new datalogger entry (for simulation/testing)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'data1' => 'required|numeric',
            'data2' => 'required|numeric',
            'logged_at' => 'nullable|date',
        ]);

        $validated['logged_at'] = $validated['logged_at'] ?? now();

        $datalogger = Datalogger::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $datalogger
        ], 201);
    }

    /**
     * Generate sample data for testing
     */
    public function generateSampleData(Request $request)
    {
        $count = $request->get('count', 50);

        for ($i = 0; $i < $count; $i++) {
            Datalogger::create([
                'data1' => rand(200, 500) / 10, // Random float between 20.0 - 50.0
                'data2' => rand(150, 800) / 10, // Random float between 15.0 - 80.0
                'logged_at' => now()->subMinutes($count - $i),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "{$count} data sample berhasil dibuat"
        ]);
    }

    /**
     * Get statistics summary
     */
    public function getStatistics(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = Datalogger::query();

        if ($startDate && $endDate) {
            $query->filterByDateRange($startDate, $endDate);
        }

        $statistics = [
            'total_records' => $query->count(),
            'data1_avg' => round($query->avg('data1'), 2),
            'data1_min' => round($query->min('data1'), 2),
            'data1_max' => round($query->max('data1'), 2),
            'data2_avg' => round($query->avg('data2'), 2),
            'data2_min' => round($query->min('data2'), 2),
            'data2_max' => round($query->max('data2'), 2),
        ];

        return response()->json($statistics);
    }
}
