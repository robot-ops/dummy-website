@extends('layouts.app')

@section('title', 'Dashboard Monitoring - Datalogger')

@section('content')
<div x-data="dashboardData()" x-init="init()" class="space-y-6">

    @include('components.statistics-cards')

    @include('components.realtime-display')

    @include('components.realtime-chart')

    @include('components.history-table')

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
    // Simpan instance chart & MQTT di luar objek Alpine untuk menghindari 'Maximum call stack size exceeded'
    let realtimeChartInstance = null;
    let historyChartInstance = null;
    let mqttClient = null;

    function dashboardData() {
        return {
            activeTab: 'realtime',
            historyData: [],
            realtimeData: {},
            statistics: {},
            chartData: [],
            historyChartData: [],
            pagination: {
                current_page: 1,
                last_page: 1,
                total: 0
            },

            // Filters
            chartLimit: 100,
            dateRange: {
                start: '',
                end: ''
            },
            historyChartDateRange: {
                start: '',
                end: ''
            },
            loading: false,

            // Getter untuk Pagination
            get paginationPages() {
                const pages = [];
                const current = this.pagination.current_page;
                const last = this.pagination.last_page;
                let start = Math.max(1, current - 2);
                let end = Math.min(last, current + 2);
                for (let i = start; i <= end; i++) pages.push(i);
                return pages;
            },

            init() {
                this.$nextTick(() => {
                    this.initChart();
                    this.initHistoryChart();

                    // Initial Data Load
                    this.loadStatistics();
                    this.loadHistory();
                    this.loadRealtimeData(); // Fetch terakhir dari DB
                    this.loadChartData();
                    this.loadHistoryChartData();

                    // Jalankan Koneksi MQTT
                    this.connectMQTT();
                });

                // Sinkronisasi statistik secara berkala (data table/stats tetap dari API)
                setInterval(() => {
                    this.loadStatistics();
                }, 30000);
            },

            // --- LOGIKA MQTT ---
            connectMQTT() {
                // Konfigurasi Broker (Ganti dengan broker Anda)
                const brokerUrl = 'wss://broker.emqx.io:8084/mqtt';
                const options = {
                    clientId: 'web_dashboard_' + Math.random().toString(16).substr(2, 8),
                };

                mqttClient = mqtt.connect(brokerUrl, options);

                mqttClient.on('connect', () => {
                    console.log('MQTT Connected');
                    // Subscribe ke topik Haiwell
                    mqttClient.subscribe('data/Haiwell/percobaan1/+', (err) => {
                        if (!err) console.log('Subscribed to: data/Haiwell/percobaan1/+');
                    });
                });

                mqttClient.on('message', (topic, message) => {
                    try {
                        const payload = JSON.parse(message.toString());

                        // 1. Update Display Card Realtime
                        this.realtimeData = {
                            ...payload,
                            logged_at: new Date().toISOString()
                        };

                        // 2. Update Grafik Realtime secara instan jika tab aktif
                        if (this.activeTab === 'realtime') {
                            this.pushToRealtimeChart(payload);
                        }
                    } catch (e) {
                        console.error('MQTT Parse Error:', e);
                    }
                });
            },

            // Push data baru ke grafik tanpa re-fetch API
            pushToRealtimeChart(data) {
                if (!realtimeChartInstance) return;

                const time = new Date().toLocaleTimeString('id-ID', {
                    hour12: false
                });

                realtimeChartInstance.data.labels.push(time);
                realtimeChartInstance.data.datasets[0].data.push(data.data1);
                realtimeChartInstance.data.datasets[1].data.push(data.data2);

                // Jaga limit data pada grafik
                if (realtimeChartInstance.data.labels.length > this.chartLimit) {
                    realtimeChartInstance.data.labels.shift();
                    realtimeChartInstance.data.datasets[0].data.shift();
                    realtimeChartInstance.data.datasets[1].data.shift();
                }

                realtimeChartInstance.update('none');
            },

            // --- TAB LOGIC ---
            switchTab(tab) {
                this.activeTab = tab;
                this.$nextTick(() => {
                    if (tab === 'realtime' && realtimeChartInstance) {
                        realtimeChartInstance.resize();
                    } else if (tab === 'history' && historyChartInstance) {
                        historyChartInstance.resize();
                    }
                });
            },

            // --- CHART INITIALIZATION ---
            initChart() {
                const ctx = document.getElementById('realtimeChart').getContext('2d');
                if (realtimeChartInstance) realtimeChartInstance.destroy();

                realtimeChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [{
                                label: 'Data 1',
                                data: [],
                                borderColor: '#4f46e5',
                                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Data 2',
                                data: [],
                                borderColor: '#9333ea',
                                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                                fill: true,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            },

            initHistoryChart() {
                const ctx = document.getElementById('historyChart').getContext('2d');
                if (historyChartInstance) historyChartInstance.destroy();

                historyChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [],
                        datasets: [{
                                label: 'Data 1',
                                data: [],
                                borderColor: '#10b981',
                                tension: 0.1
                            },
                            {
                                label: 'Data 2',
                                data: [],
                                borderColor: '#ef4444',
                                tension: 0.1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            },

            // --- API LOADERS (FOR INITIAL & HISTORY) ---
            async loadChartData() {
                const res = await fetch(`/api/datalogger/chart?limit=${this.chartLimit}`);
                const data = await res.json();
                this.chartData = data;

                realtimeChartInstance.data.labels = data.map(d => new Date(d.logged_at).toLocaleTimeString());
                realtimeChartInstance.data.datasets[0].data = data.map(d => d.data1);
                realtimeChartInstance.data.datasets[1].data = data.map(d => d.data2);
                realtimeChartInstance.update();
            },

            async loadHistoryChartData() {
                const params = new URLSearchParams({
                    limit: 500
                });
                if (this.historyChartDateRange.start) params.append('start_date', this.historyChartDateRange.start);
                if (this.historyChartDateRange.end) params.append('end_date', this.historyChartDateRange.end);

                const res = await fetch(`/api/datalogger/chart?${params}`);
                const data = await res.json();

                historyChartInstance.data.labels = data.map(d => new Date(d.logged_at).toLocaleDateString());
                historyChartInstance.data.datasets[0].data = data.map(d => d.data1);
                historyChartInstance.data.datasets[1].data = data.map(d => d.data2);
                historyChartInstance.update();
            },

            // API Loaders lainnya (loadStatistics, loadHistory, dll) tetap sama...
            async loadStatistics() {
                const res = await fetch('/api/datalogger/statistics');
                this.statistics = await res.json();
            },

            async loadHistory(page = 1) {
                this.loading = true;
                const res = await fetch(`/api/datalogger/history?page=${page}`);
                const data = await res.json();
                this.historyData = data.data;
                this.pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    total: data.total
                };
                this.loading = false;
            },

            async loadRealtimeData() {
                const res = await fetch('/api/datalogger/realtime?limit=1');
                const data = await res.json();
                if (data.length > 0) this.realtimeData = data[0];
            }
        }
    }
</script>
@endpush
@endsection
