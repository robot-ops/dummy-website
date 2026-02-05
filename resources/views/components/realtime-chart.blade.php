<div class="bg-white dark:bg-gray-800 rounded-lg card-shadow overflow-hidden">

    <div class="border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between px-6 py-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                <span x-show="activeTab === 'realtime'">
                    <i class="fas fa-bolt mr-3 text-yellow-500"></i>Grafik Realtime
                </span>
                <span x-show="activeTab === 'history'" style="display: none;">
                    <i class="fas fa-history mr-3 text-indigo-600"></i>Grafik Riwayat
                </span>
            </h2>

            <div class="flex space-x-1 bg-gray-100 dark:bg-gray-900 p-1 rounded-lg">
                <button
                    @click="switchTab('realtime')"
                    :class="activeTab === 'realtime' ? 'bg-white dark:bg-gray-700 text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                    class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 flex items-center">
                    <i class="fas fa-bolt mr-2" :class="activeTab === 'realtime' ? 'text-yellow-500' : ''"></i> Live
                </button>
                <button
                    @click="switchTab('history')"
                    :class="activeTab === 'history' ? 'bg-white dark:bg-gray-700 text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                    class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 flex items-center">
                    <i class="fas fa-history mr-2"></i> Riwayat
                </button>
            </div>
        </div>
    </div>

    <div class="p-6">
        <div x-show="activeTab === 'realtime'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="flex justify-end mb-4">
                <div class="flex space-x-2">
                    <span class="flex items-center text-xs text-green-500 font-bold mr-3 animate-pulse">
                        ● LIVE MONITORING
                    </span>
                    <select x-model="chartLimit" @change="loadChartData()" class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                        <option value="50">Last 50</option>
                        <option value="100">Last 100</option>
                        <option value="200">Last 200</option>
                    </select>
                    <button @click="loadChartData()" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg text-sm font-medium transition">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>

            <div class="relative w-full" style="height: 400px;">
                <canvas id="realtimeChart"></canvas>
            </div>
        </div>

        <div x-show="activeTab === 'history'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="mb-6 bg-gray-50 dark:bg-gray-700/30 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1">Dari Tanggal</label>
                        <input type="datetime-local" x-model="historyChartDateRange.start" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-indigo-500 dark:bg-gray-800 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-1">Sampai Tanggal</label>
                        <input type="datetime-local" x-model="historyChartDateRange.end" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm focus:ring-indigo-500 dark:bg-gray-800 dark:text-white">
                    </div>
                    <div class="flex items-end">
                        <button @click="loadHistoryChartData()" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition shadow-sm">
                            <i class="fas fa-search mr-2"></i>Tampilkan Data
                        </button>
                    </div>
                </div>
            </div>

            <div class="relative w-full" style="height: 400px;">
                <canvas id="historyChart"></canvas>
            </div>
        </div>
    </div>
</div>
