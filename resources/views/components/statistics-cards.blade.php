<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2 data-value" x-text="statistics.data1_avg + '°' || '0°'"></h3>
                <p class="text-xs text-gray-400 mt-1">Min: <span class="data-value" x-text="statistics.data1_min"></span>° | Max: <span class="data-value" x-text="statistics.data1_max"></span>°</p>
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
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2 data-value" x-text="statistics.data2_avg + '%' || '0%'"></h3>
                <p class="text-xs text-gray-400 mt-1">Min: <span class="data-value" x-text="statistics.data2_min"></span>% | Max: <span class="data-value" x-text="statistics.data2_max"></span>%</p>
            </div>
            <div class="bg-purple-100 dark:bg-purple-900 rounded-full p-3">
                <i class="fas fa-chart-area text-purple-600 dark:text-purple-300 text-2xl"></i>
            </div>
        </div>
    </div>
</div>
