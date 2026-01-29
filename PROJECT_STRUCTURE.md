# Struktur Folder Project

```
project-root/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── DataloggerController.php          # Controller utama untuk API
│   │
│   ├── Models/
│   │   └── Datalogger.php                        # Model Eloquent
│   │
│   └── Exports/
│       └── DataloggerExport.php                  # Export class untuk Excel
│
├── database/
│   └── migrations/
│       └── 2026_01_29_061614_create_datalogger_table.php  # Migration file
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php                     # Layout template utama
│       │
│       └── dashboard/
│           └── main.blade.php                    # Halaman dashboard utama
│
├── routes/
│   └── web.php                                   # Route definitions
│
├── public/
│   ├── css/
│   ├── js/
│   └── index.php
│
├── storage/
│   └── app/
│
├── vendor/
│
├── .env                                          # Environment configuration
├── composer.json                                 # PHP dependencies
├── package.json                                  # Node dependencies (if any)
├── artisan                                       # Laravel CLI
├── README.md                                     # Dokumentasi utama
├── API_DOCUMENTATION.md                          # Dokumentasi API
└── install.sh                                    # Script instalasi
```

## Detail Files

### Backend (PHP/Laravel)

#### 1. `app/Models/Datalogger.php`
- Model Eloquent untuk tabel datalogger
- Defines fillable attributes
- Contains relationship & scope methods
- Accessor untuk formatting data

#### 2. `app/Http/Controllers/DataloggerController.php`
- Handle semua request API
- Methods:
  - `index()` - Display dashboard
  - `getHistory()` - Get paginated history
  - `getRealtimeData()` - Get latest data
  - `getChartData()` - Get data for chart
  - `getStatistics()` - Get statistical summary
  - `downloadCSV()` - Export to CSV
  - `downloadExcel()` - Export to Excel
  - `store()` - Store new data
  - `generateSampleData()` - Generate sample data

#### 3. `app/Exports/DataloggerExport.php`
- Export class untuk maatwebsite/excel
- Define headings, mappings, styles
- Used for Excel export

### Frontend (Blade/JavaScript)

#### 4. `resources/views/layouts/app.blade.php`
- Master layout template
- Include CDN untuk:
  - Tailwind CSS
  - Chart.js
  - Alpine.js
  - Font Awesome
- Navigation bar
- Footer
- Real-time clock

#### 5. `resources/views/dashboard/main.blade.php`
- Main dashboard page
- Contains:
  - Statistics cards
  - Realtime chart
  - Realtime data display
  - History table with pagination
  - Filters and sorting
  - Download buttons
  - Testing tools
- Alpine.js untuk state management
- Chart.js untuk visualisasi

### Database

#### 6. `database/migrations/2026_01_29_061614_create_datalogger_table.php`
- Create table datalogger
- Columns:
  - `id` - Primary key
  - `data1` - Float
  - `data2` - Float
  - `logged_at` - Timestamp
  - `timestamps` - created_at, updated_at

### Routes

#### 7. `routes/web.php`
- Define all routes
- Main dashboard route
- API routes group:
  - GET history
  - GET realtime
  - GET chart
  - GET statistics
  - GET download/csv
  - GET download/excel
  - POST store
  - POST generate-sample

### Documentation

#### 8. `README.md`
- Dokumentasi lengkap project
- Fitur-fitur
- Instalasi
- API endpoints
- Customization
- Troubleshooting

#### 9. `API_DOCUMENTATION.md`
- Dokumentasi detail API
- Semua endpoints
- Request/Response examples
- Query parameters
- Error responses

### Scripts

#### 10. `install.sh`
- Bash script untuk instalasi
- Check dependencies
- Install packages
- Run migrations
- Generate sample data

## File Size Estimation

```
DataloggerController.php     : ~8 KB
Datalogger.php                : ~2 KB
DataloggerExport.php          : ~2 KB
app.blade.php                 : ~5 KB
main.blade.php                : ~25 KB
web.php                       : ~2 KB
README.md                     : ~8 KB
API_DOCUMENTATION.md          : ~10 KB
install.sh                    : ~2 KB
migration file                : ~1 KB
──────────────────────────────────────
Total                         : ~65 KB
```

## Dependencies

### Composer (PHP)
```json
{
    "require": {
        "php": "^8.0",
        "laravel/framework": "^9.0|^10.0",
        "maatwebsite/excel": "^3.1" 
    }
}
```

### CDN (JavaScript/CSS)
- Tailwind CSS v3.x
- Chart.js v4.4.0
- Alpine.js v3.13.3
- Font Awesome v6.4.2

## Database Requirements

### MySQL
```sql
Database: laravel
Table: datalogger
Estimated size: 
- Per record: ~100 bytes
- 1000 records: ~100 KB
- 10000 records: ~1 MB
```

### Indexes
- Primary key on `id`
- Index on `logged_at` (untuk sorting & filtering)

## Performance Considerations

### Pagination
- Default: 20 records per page
- Customizable: 10, 20, 50, 100

### Auto-refresh Intervals
- Realtime data: 5 seconds
- Chart data: 10 seconds
- Statistics: 5 seconds

### Chart Data Limit
- Default: 100 records
- Options: 50, 100, 200, 500

## Browser Compatibility

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Server Requirements

### Minimum
- PHP 8.0
- MySQL 5.7 / PostgreSQL 9.6
- 512 MB RAM
- 1 GB Storage

### Recommended
- PHP 8.1+
- MySQL 8.0 / PostgreSQL 12+
- 1 GB RAM
- 5 GB Storage

---

**Note:** Struktur ini dapat disesuaikan dengan kebutuhan project Laravel Anda.
