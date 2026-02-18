# Quick Start Guide - Dashboard Monitoring

## 🚀 Panduan Cepat (5 Menit)

### Step 1: Persiapan File

```bash
# Jalankan perintah ini
```

### Step 2: Install Dependencies (Opsional)

```bash
# Untuk fitur export Excelcomposer require maatwebsite/excel# Untuk fitur MQTT 
```

### Step 3: Database Setup

```bash
# Jalankan migrationphp artisan migrate# Generate sample data (100 records)php artisan tinker# Di tinker, jalankan:for ($i = 0; $i < 100; $i++) {    AppModelsDatalogger::create([        'data1' => rand(200, 500) / 10,        'data2' => rand(150, 800) / 10,        'logged_at' => now()->subMinutes(100 - $i),    ]);}exit
```

### Step 4: Jalankan Server

```bash
php artisan serve & npm run dev
```

### Step 5: Buka Browser

```
http://localhost:8000
```

---

## 📸 Preview Dashboard

### 1. **Navigation Bar**

```
┌─────────────────────────────────────────────────────────────┐│ 📊 Datalogger Monitoring        🟢 Live  ⏰ 2026-01-29 15:30│└─────────────────────────────────────────────────────────────┘
```

### 2. **Statistics Cards** (4 Cards dalam 1 Row)

```
┌──────────────┐ ┌──────────────┐ ┌──────────────┐ ┌──────────────┐│ Total Records│ │  Data 1 Avg  │ │  Data 2 Avg  │ │ Latest Data  ││              │ │              │ │              │ │              ││    100       │ │    37.45     │ │    54.32     │ │    42.8      ││              │ │ Min: 20.0    │ │ Min: 15.0    │ │ 15:30:00     ││  📁          │ │ Max: 50.0    │ │ Max: 80.0    │ │  🕐          │└──────────────┘ └──────────────┘ └──────────────┘ └──────────────┘
```

### 3. **Grafik Realtime**

```
┌─────────────────────────────────────────────────────────────┐│ 📈 Grafik Realtime               [100 Data ▼] [🔄 Refresh] │├─────────────────────────────────────────────────────────────┤│ Start Date: [____] End Date: [____] [Apply Filter]         │├─────────────────────────────────────────────────────────────┤│                                                             ││   50 │                    ╱╲                               ││   40 │        ╱╲         ╱  ╲      ╱╲                     ││   30 │   ╱╲  ╱  ╲   ╱╲  ╱    ╲    ╱  ╲                    ││   20 │  ╱  ╲╱    ╲ ╱  ╲╱      ╲  ╱    ╲                   ││   10 │ ╱           ╲            ╲╱      ╲                  ││    0 └─────────────────────────────────────────            ││        10:00  10:30  11:00  11:30  12:00  12:30           ││                                                             ││  Legend: ─ Data 1 (Blue)  ─ Data 2 (Purple)               │└─────────────────────────────────────────────────────────────┘
```

### 4. **Data Realtime** (Auto-refresh 5 detik)

```
┌─────────────────────────────────────────────────────────────┐│ 📡 Data Realtime (Auto-refresh setiap 5 detik)             │├─────────────────────────────────────────────────────────────┤│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────────┐││  │   Data 1    │  │   Data 2    │  │     Timestamp       │││  │             │  │             │  │                     │││  │    42.8     │  │    75.2     │  │ 2026-01-29 15:30:00 │││  │   Unit: °C  │  │   Unit: %   │  │    Logged At        │││  └─────────────┘  └─────────────┘  └─────────────────────┘│└─────────────────────────────────────────────────────────────┘
```

### 5. **History Datalogger Table**

```
┌─────────────────────────────────────────────────────────────┐│ 📜 History Datalogger    [📄 CSV] [📊 Excel]                │├─────────────────────────────────────────────────────────────┤│ Sort: [Logged At ▼] Order: [Desc ▼] Per Page: [20 ▼] [🔄] ││ Start: [____] End: [____] [🔍 Filter] [✖ Clear]            │├─────────────────────────────────────────────────────────────┤│ ID │ Data 1 │ Data 2 │ Logged At         │ Created At      │├────┼────────┼────────┼───────────────────┼─────────────────┤│ 100│  42.8  │  75.2  │ 2026-01-29 15:30  │ 2026-01-29 15:30││  99│  41.5  │  73.8  │ 2026-01-29 15:25  │ 2026-01-29 15:25││  98│  40.2  │  72.1  │ 2026-01-29 15:20  │ 2026-01-29 15:20││ ...│  ...   │  ...   │ ...               │ ...             │├────┴────────┴────────┴───────────────────┴─────────────────┤│ Showing 1 to 20 of 100    [← Prev] [1][2][3][4][5] [Next →]│└─────────────────────────────────────────────────────────────┘
```

### 6. **Testing Tools**

```
┌─────────────────────────────────────────────────────────────┐│ 🛠️ Testing Tools (Demo Only)                                ││ [➕ Generate 50 Sample Data]                                │└─────────────────────────────────────────────────────────────┘
```

---

## 🎨 Warna Theme

### Light Mode

-   Primary: Indigo (#667eea - #764ba2)
-   Data 1: Blue (#3b82f6)
-   Data 2: Purple (#a855f7)
-   Success: Green (#10b981)
-   Warning: Orange (#f59e0b)
-   Background: Gray-50 (#f9fafb)

### Dark Mode (Auto)

-   Background: Gray-900 (#111827)
-   Card: Gray-800 (#1f2937)
-   Text: White/Gray-100

---

## ⚙️ Fitur-Fitur

### ✅ Sudah Tersedia

-    Dashboard dengan statistik cards
-    Grafik realtime dengan Chart.js
-    Monitor data realtime (auto-refresh)
-    History table dengan pagination
-    Sorting multi-kolom (ID, Data1, Data2, Logged At)
-    Filter berdasarkan date range
-    Download CSV
-    Download Excel (XLSX)
-    Responsive design
-    Dark mode support
-    Real-time clock
-    Status indicator (Live)
-    API endpoints lengkap

### 🔮 Enhancement Ideas (Future)

-    WebSocket untuk real-time push
-    User authentication
-    Data visualization: Pie chart, Bar chart
-    Export PDF
-    Email alerts
-    Data comparison tools
-    Advanced filtering
-    Multi-language support
-    Data backup/restore
-    Mobile app

---

## 🐛 Common Issues & Solutions

### Issue 1: Chart tidak muncul

**Solution:**

```javascript
// Pastikan Chart.js loadedconsole.log(typeof Chart); // harus return "function"// Check elementconsole.log(document.getElementById('realtimeChart'));
```

### Issue 2: Data tidak auto-refresh

**Solution:**

```javascript
// Check di console browser// Pastikan tidak ada error JavaScript// Pastikan setInterval berjalan
```

### Issue 3: Download tidak berfungsi

**Solution:**

```bash
# Install package Excelcomposer require maatwebsite/excel# Clear cachephp artisan cache:clearphp artisan config:clear
```

### Issue 4: CSRF Token mismatch

**Solution:**

```blade
<!-- Pastikan ada di layout --><meta name="csrf-token" content="{{ csrf_token() }}">
```

---

## 📱 Mobile Responsive

Dashboard fully responsive untuk:

-   📱 Mobile (320px - 767px)
-   📱 Tablet (768px - 1023px)
-   💻 Desktop (1024px+)

---

## 🎯 Use Cases

### 1. **IoT Data Monitoring**

-   Temperature sensors
-   Humidity sensors
-   Environmental monitoring

### 2. **Industrial Monitoring**

-   Production line data
-   Quality control metrics
-   Machine performance

### 3. **Research & Development**

-   Experiment data logging
-   Lab equipment monitoring
-   Data analysis

### 4. **Training & Education**

-   Teaching web development
-   Laravel training
-   Real-time systems demo

---

## 📊 Performance Metrics

### Load Time

-   Initial load: < 2 seconds
-   Data refresh: < 500ms
-   Chart update: < 300ms

### Database Queries

-   History: 1 query (with pagination)
-   Realtime: 1 query
-   Chart: 1 query
-   Statistics: 1 query

### Optimization Tips

```php
// Use eager loading$data = Datalogger::with('relations')->get();// Use caching for statisticsCache::remember('statistics', 60, function() {    return Datalogger::getStatistics();});// Limit chart data$chartData = Datalogger::latest()->limit(100)->get();
```

---

## 🔒 Security Notes

**For Production:**

1.  Enable authentication
2.  Add rate limiting
3.  Validate all inputs
4.  Use HTTPS
5.  Sanitize outputs
6.  Add CSRF protection
7.  Implement authorization
8.  Log all activities

---

## 📞 Support & Feedback

Untuk pertanyaan, bug report, atau feature request, silakan:

1.  Check dokumentasi
2.  Review API documentation
3.  Contact development team

---

**Happy Monitoring! 📊🚀**