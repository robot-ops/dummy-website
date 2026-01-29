@extends('layouts.app')

@section('title', 'Dashboard Monitoring - Datalogger')

@section('content')
<div x-data="dashboardData()" x-init="init()" class="space-y-6">

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Records Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg card-shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Records</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2" x-text="statistics.total_records || '0'"></h3>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 rounded-full p-3">
                    <i class="fas fa-database text-blue-600 dark:text-blue-300 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Data 1 Average Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg card-shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Data 1 Avg</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2 data-value" x-text="statistics.data1_avg || '0'"></h3>
                    <p class="text-xs text-gray-400 mt-1">Min: <span class="data-value" x-text="statistics.data1_min"></span> | Max: <span class="data-value" x-text="statistics.data1_max"></span></p>
                </div>
                <div class="bg-green-100 dark:bg-green-900 rounded-full p-3">
                    <i class="fas fa-chart-line text-green-600 dark:text-green-300 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Data 2 Average Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg card-shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Data 2 Avg</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2 data-value" x-text="statistics.data2_avg || '0'"></h3>
                    <p class="text-xs text-gray-400 mt-1">Min: <span class="data-value" x-text="statistics.data2_min"></span> | Max: <span class="data-value" x-text="statistics.data2_max"></span></p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900 rounded-full p-3">
                    <i class="fas fa-chart-area text-purple-600 dark:text-purple-300 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Latest Update Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg card-shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Latest Data</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-2 data-value" x-text="formatNumber(realtimeData.data1)"></h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" x-text="formatDateTime(realtimeData.logged_at) || '-'"></p>
                </div>
                <div class="bg-orange-100 dark:bg-orange-900 rounded-full p-3">
                    <i class="fas fa-clock text-orange-600 dark:text-orange-300 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Realtime Chart Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg card-shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-chart-line mr-3 text-indigo-600"></i>
                Grafik Realtime
            </h2>
            <div class="flex space-x-2">
                <!-- Chart Controls -->
                <select x-model="chartLimit" @change="loadChartData()" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value="50">50 Data</option>
                    <option value="100">100 Data</option>
                    <option value="200">200 Data</option>
                    <option value="500">500 Data</option>
                </select>

                <button @click="loadChartData()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>

        <!-- Date Range Filter for Chart -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Date</label>
                <input type="datetime-local" x-model="chartDateRange.start" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date</label>
                <input type="datetime-local" x-model="chartDateRange.end" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex items-end">
                <button @click="loadChartData()" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition">
                    <i class="fas fa-filter mr-2"></i>Apply Filter
                </button>
            </div>
        </div>

        <div class="relative" style="height: 400px;">
            <canvas id="realtimeChart"></canvas>
        </div>
    </div>

    <!-- Realtime Data Display -->
    <div class="bg-white dark:bg-gray-800 rounded-lg card-shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            <i class="fas fa-satellite-dish mr-3 text-green-600"></i>
            Data Realtime
            <span class="ml-3 text-sm font-normal text-gray-500">(Auto-refresh setiap 5 detik)</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-semibold text-blue-800 dark:text-blue-200">Data 1 (Temperature)</p>
                    <i class="fas fa-thermometer-half text-blue-600 dark:text-blue-300 text-xl"></i>
                </div>
                <h3 class="text-5xl font-bold text-blue-900 dark:text-blue-100 mb-2 data-value" x-text="formatNumber(realtimeData.data1)"></h3>
                <p class="text-sm text-blue-700 dark:text-blue-300 font-medium">Unit: °C</p>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-semibold text-purple-800 dark:text-purple-200">Data 2 (Humidity)</p>
                    <i class="fas fa-tint text-purple-600 dark:text-purple-300 text-xl"></i>
                </div>
                <h3 class="text-5xl font-bold text-purple-900 dark:text-purple-100 mb-2 data-value" x-text="formatNumber(realtimeData.data2)"></h3>
                <p class="text-sm text-purple-700 dark:text-purple-300 font-medium">Unit: %</p>
            </div>

            <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm font-semibold text-orange-800 dark:text-orange-200">Timestamp</p>
                    <i class="fas fa-clock text-orange-600 dark:text-orange-300 text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-orange-900 dark:text-orange-100 mb-2" x-text="formatDateTime(realtimeData.logged_at) || '-'"></h3>
                <p class="text-sm text-orange-700 dark:text-orange-300 font-medium">Logged At</p>
            </div>
        </div>
    </div>

    <!-- History Data Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg card-shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-history mr-3 text-yellow-600"></i>
                History Datalogger
            </h2>

            <!-- Download Buttons -->
            <div class="flex space-x-2">
                <button @click="downloadData('csv')" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                    <i class="fas fa-file-csv mr-2"></i>Download CSV
                </button>
                <button @click="downloadData('excel')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                    <i class="fas fa-file-excel mr-2"></i>Download Excel
                </button>
            </div>
        </div>

        <!-- Filters and Controls -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort By</label>
                <select x-model="sortBy" @change="loadHistory()" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value="logged_at">Logged At</option>
                    <option value="data1">Data 1</option>
                    <option value="data2">Data 2</option>
                    <option value="id">ID</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Order</label>
                <select x-model="sortOrder" @change="loadHistory()" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value="desc">Descending</option>
                    <option value="asc">Ascending</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Per Page</label>
                <select x-model="perPage" @change="loadHistory()" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div class="flex items-end">
                <button @click="loadHistory()" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>

        <!-- Date Range Filter -->
        <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Date</label>
                <input type="datetime-local" x-model="dateRange.start" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date</label>
                <input type="datetime-local" x-model="dateRange.end" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="flex items-end space-x-2">
                <button @click="loadHistory()" class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <button @click="clearFilters()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Loading State -->
        <div x-show="loading" class="text-center py-8">
            <i class="fas fa-spinner fa-spin text-4xl text-indigo-600"></i>
            <p class="text-gray-600 dark:text-gray-400 mt-4">Loading data...</p>
        </div>

        <!-- Table -->
        <div x-show="!loading" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Data 1</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Data 2</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Logged At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created At</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <template x-for="item in historyData" :key="item.id">
                        <tr class="table-row">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white" x-text="item.id"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded data-value" x-text="formatNumber(item.data1)"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded data-value" x-text="formatNumber(item.data2)"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" x-text="formatDateTime(item.logged_at)"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" x-text="formatDateTime(item.created_at)"></td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <!-- Empty State -->
            <div x-show="historyData.length === 0" class="text-center py-12">
                <i class="fas fa-inbox text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400">Tidak ada data tersedia</p>
            </div>
        </div>

        <!-- Pagination -->
        <div x-show="pagination.last_page > 1" class="mt-6 flex justify-between items-center">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                Showing <span x-text="pagination.from"></span> to <span x-text="pagination.to"></span> of <span x-text="pagination.total"></span> results
            </div>
            <div class="flex space-x-2">
                <button @click="goToPage(pagination.current_page - 1)" :disabled="pagination.current_page === 1" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 disabled:bg-gray-200 disabled:cursor-not-allowed text-gray-700 rounded-lg text-sm font-medium transition">
                    <i class="fas fa-chevron-left"></i> Previous
                </button>

                <div class="flex space-x-1">
                    <template x-for="page in paginationPages" :key="page">
                        <button @click="goToPage(page)" :class="page === pagination.current_page ? 'bg-indigo-600 text-white' : 'bg-gray-300 hover:bg-gray-400 text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-medium transition" x-text="page"></button>
                    </template>
                </div>

                <button @click="goToPage(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 disabled:bg-gray-200 disabled:cursor-not-allowed text-gray-700 rounded-lg text-sm font-medium transition">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Testing Tools (Optional - for demo purposes) -->
    <div class="bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-400 p-4 rounded-lg">
        <div class="flex items-center mb-3">
            <i class="fas fa-tools text-yellow-600 dark:text-yellow-300 mr-3"></i>
            <h3 class="text-lg font-bold text-yellow-800 dark:text-yellow-200">Testing Tools (Demo Only)</h3>
        </div>
        <div class="flex space-x-3">
            <button @click="generateSampleData()" class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm font-medium transition">
                <i class="fas fa-plus-circle mr-2"></i>Generate 50 Sample Data
            </button>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function dashboardData() {
        return {
            // Data properties
            historyData: [],
            realtimeData: {},
            statistics: {},
            chartData: [],

            // Chart instance
            chart: null,

            // Pagination
            pagination: {
                current_page: 1,
                last_page: 1,
                from: 0,
                to: 0,
                total: 0
            },

            // Filters and sorting
            sortBy: 'logged_at',
            sortOrder: 'desc',
            perPage: 20,
            dateRange: {
                start: '',
                end: ''
            },
            chartDateRange: {
                start: '',
                end: ''
            },
            chartLimit: 100,

            // Loading state
            loading: false,

            // Helper function to format datetime
            formatDateTime(dateString) {
                if (!dateString) return '-';
                try {
                    const date = new Date(dateString);
                    return date.toLocaleString('id-ID', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false
                    });
                } catch (e) {
                    return dateString;
                }
            },

            // Helper function to format numbers
            formatNumber(value) {
                if (value === null || value === undefined) return '-';
                return parseFloat(value).toFixed(1);
            },

            // Initialization
            init() {
                this.loadStatistics();
                this.loadHistory();
                this.loadRealtimeData();
                this.loadChartData();
                this.initChart();

                // Auto-refresh realtime data every 5 seconds
                setInterval(() => {
                    this.loadRealtimeData();
                    this.loadStatistics();
                }, 5000);

                // Auto-refresh chart every 10 seconds
                setInterval(() => {
                    this.loadChartData();
                }, 10000);
            },

            // Load statistics
            async loadStatistics() {
                try {
                    const params = new URLSearchParams();
                    if (this.dateRange.start) params.append('start_date', this.dateRange.start);
                    if (this.dateRange.end) params.append('end_date', this.dateRange.end);

                    const response = await fetch(`/api/datalogger/statistics?${params}`);
                    this.statistics = await response.json();
                } catch (error) {
                    console.error('Error loading statistics:', error);
                }
            },

            // Load history data
            async loadHistory(page = 1) {
                this.loading = true;
                try {
                    const params = new URLSearchParams({
                        page: page,
                        per_page: this.perPage,
                        sort_by: this.sortBy,
                        sort_order: this.sortOrder
                    });

                    if (this.dateRange.start) params.append('start_date', this.dateRange.start);
                    if (this.dateRange.end) params.append('end_date', this.dateRange.end);

                    const response = await fetch(`/api/datalogger/history?${params}`);
                    const data = await response.json();

                    this.historyData = data.data;
                    this.pagination = {
                        current_page: data.current_page,
                        last_page: data.last_page,
                        from: data.from,
                        to: data.to,
                        total: data.total
                    };
                } catch (error) {
                    console.error('Error loading history:', error);
                } finally {
                    this.loading = false;
                }
            },

            // Load realtime data
            async loadRealtimeData() {
                try {
                    const response = await fetch('/api/datalogger/realtime?limit=1');
                    const data = await response.json();
                    if (data.length > 0) {
                        this.realtimeData = data[0];
                    }
                } catch (error) {
                    console.error('Error loading realtime data:', error);
                }
            },

            // Load chart data
            async loadChartData() {
                try {
                    const params = new URLSearchParams({
                        limit: this.chartLimit
                    });

                    if (this.chartDateRange.start) params.append('start_date', this.chartDateRange.start);
                    if (this.chartDateRange.end) params.append('end_date', this.chartDateRange.end);

                    const response = await fetch(`/api/datalogger/chart?${params}`);
                    this.chartData = await response.json();
                    this.updateChart();
                } catch (error) {
                    console.error('Error loading chart data:', error);
                }
            },

            // Initialize Chart
            initChart() {
                const ctx = document.getElementById('realtimeChart').getContext('2d');
                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [{
                                label: 'Data 1',
                                data: [],
                                borderColor: 'rgb(59, 130, 246)',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.4,
                                fill: true
                            },
                            {
                                label: 'Data 2',
                                data: [],
                                borderColor: 'rgb(168, 85, 247)',
                                backgroundColor: 'rgba(168, 85, 247, 0.1)',
                                tension: 0.4,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: false
                            }
                        }
                    }
                });
            },

            // Update Chart
            updateChart() {
                if (!this.chart) return;

                const labels = this.chartData.map(item => {
                    const date = new Date(item.logged_at);
                    return date.toLocaleString('id-ID', {
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                });

                const data1Values = this.chartData.map(item => item.data1);
                const data2Values = this.chartData.map(item => item.data2);

                this.chart.data.labels = labels;
                this.chart.data.datasets[0].data = data1Values;
                this.chart.data.datasets[1].data = data2Values;
                this.chart.update();
            },

            // Pagination
            goToPage(page) {
                if (page >= 1 && page <= this.pagination.last_page) {
                    this.loadHistory(page);
                }
            },

            get paginationPages() {
                const pages = [];
                const current = this.pagination.current_page;
                const last = this.pagination.last_page;

                // Show max 5 pages
                let start = Math.max(1, current - 2);
                let end = Math.min(last, current + 2);

                for (let i = start; i <= end; i++) {
                    pages.push(i);
                }

                return pages;
            },

            // Clear filters
            clearFilters() {
                this.dateRange.start = '';
                this.dateRange.end = '';
                this.chartDateRange.start = '';
                this.chartDateRange.end = '';
                this.sortBy = 'logged_at';
                this.sortOrder = 'desc';
                this.loadHistory();
                this.loadChartData();
                this.loadStatistics();
            },

            // Download data
            downloadData(format) {
                const params = new URLSearchParams();
                if (this.dateRange.start) params.append('start_date', this.dateRange.start);
                if (this.dateRange.end) params.append('end_date', this.dateRange.end);

                const url = `/api/datalogger/download/${format}?${params}`;
                window.location.href = url;
            },

            // Generate sample data (for testing)
            async generateSampleData() {
                try {
                    const response = await fetch('/api/datalogger/generate-sample', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            count: 50
                        })
                    });

                    const result = await response.json();
                    alert(result.message);

                    // Reload all data
                    this.loadHistory();
                    this.loadRealtimeData();
                    this.loadChartData();
                    this.loadStatistics();
                } catch (error) {
                    console.error('Error generating sample data:', error);
                    alert('Error generating sample data');
                }
            }
        }
    }
</script>
@endpush

@endsection
