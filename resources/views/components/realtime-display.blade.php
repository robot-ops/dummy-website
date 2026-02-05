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
            <h3 class="text-5xl font-bold text-blue-900 dark:text-blue-100 mb-2 data-value" x-text="formatNumber(realtimeData.data1) + '°'"></h3>
            <p class="text-sm text-blue-700 dark:text-blue-300 font-medium">Unit: °C</p>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-semibold text-purple-800 dark:text-purple-200">Data 2 (Humidity)</p>
                <i class="fas fa-tint text-purple-600 dark:text-purple-300 text-xl"></i>
            </div>
            <h3 class="text-5xl font-bold text-purple-900 dark:text-purple-100 mb-2 data-value" x-text="formatNumber(realtimeData.data2) + '%'"></h3>
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
