# Installation Checklist ✅

## Pre-Installation
- [ ] PHP >= 8.0 terinstall
- [ ] Composer terinstall
- [ ] Laravel project sudah ada
- [ ] Database (MySQL/PostgreSQL) sudah running
- [ ] Web server (Apache/Nginx) atau `php artisan serve`

---

## Step-by-Step Installation

### 1. Backend Files
- [ ] Copy `Datalogger.php` ke `app/Models/Datalogger.php`
- [ ] Copy `DataloggerController.php` ke `app/Http/Controllers/DataloggerController.php`
- [ ] Copy `DataloggerExport.php` ke `app/Exports/DataloggerExport.php`
- [ ] Tambahkan routes dari `web.php` ke `routes/web.php`

### 2. Frontend Files
- [ ] Buat folder `resources/views/layouts/` (jika belum ada)
- [ ] Buat folder `resources/views/dashboard/` (jika belum ada)
- [ ] Copy `layouts_app.blade.php` ke `resources/views/layouts/app.blade.php`
- [ ] Copy `dashboard_main.blade.php` ke `resources/views/dashboard/main.blade.php`

### 3. Database Setup
- [ ] File migration `2026_01_29_061614_create_datalogger_table.php` sudah ada
- [ ] Jalankan `php artisan migrate`
- [ ] Cek tabel `datalogger` sudah dibuat
- [ ] Generate sample data (opsional)

### 4. Dependencies (Opsional)
- [ ] Install `maatwebsite/excel`: `composer require maatwebsite/excel`
- [ ] Publish config (jika perlu): `php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"`

### 5. Configuration
- [ ] Set `APP_NAME` di `.env`
- [ ] Set database credentials di `.env`
- [ ] Set `APP_URL` di `.env`
- [ ] Clear cache: `php artisan config:clear`

### 6. Testing
- [ ] Start server: `php artisan serve`
- [ ] Buka browser: `http://localhost:8000`
- [ ] Cek dashboard tampil dengan benar
- [ ] Test generate sample data
- [ ] Test sorting & filtering
- [ ] Test download CSV
- [ ] Test download Excel (jika sudah install package)
- [ ] Test auto-refresh realtime data

---

## File Checklist

### PHP Files (Backend)
```
✓ Datalogger.php           → app/Models/
✓ DataloggerController.php → app/Http/Controllers/
✓ DataloggerExport.php     → app/Exports/
✓ web.php (routes)         → routes/web.php (append)
```

### Blade Files (Frontend)
```
✓ layouts_app.blade.php    → resources/views/layouts/app.blade.php
✓ dashboard_main.blade.php → resources/views/dashboard/main.blade.php
```

### Database
```
✓ 2026_01_29_061614_create_datalogger_table.php (already uploaded)
```

### Documentation
```
✓ README.md
✓ API_DOCUMENTATION.md
✓ PROJECT_STRUCTURE.md
✓ QUICK_START_GUIDE.md
✓ INSTALLATION_CHECKLIST.md (this file)
```

---

## Verification Commands

### Check Files Exist
```bash
# Check Model
ls -la app/Models/Datalogger.php

# Check Controller
ls -la app/Http/Controllers/DataloggerController.php

# Check Views
ls -la resources/views/layouts/app.blade.php
ls -la resources/views/dashboard/main.blade.php

# Check Migration
ls -la database/migrations/*create_datalogger_table.php
```

### Check Database
```bash
# Enter MySQL/PostgreSQL
mysql -u root -p

# Check database
SHOW DATABASES;
USE your_database_name;

# Check table
SHOW TABLES;
DESCRIBE datalogger;

# Check data
SELECT COUNT(*) FROM datalogger;
```

### Check Routes
```bash
php artisan route:list | grep datalogger
```

Expected output:
```
GET|HEAD  /                              → dashboard.main
GET|HEAD  api/datalogger/history         → api.datalogger.history
GET|HEAD  api/datalogger/realtime        → api.datalogger.realtime
GET|HEAD  api/datalogger/chart           → api.datalogger.chart
GET|HEAD  api/datalogger/statistics      → api.datalogger.statistics
GET|HEAD  api/datalogger/download/csv    → api.datalogger.download.csv
GET|HEAD  api/datalogger/download/excel  → api.datalogger.download.excel
POST      api/datalogger/store           → api.datalogger.store
POST      api/datalogger/generate-sample → api.datalogger.generate
```

---

## Common Installation Issues

### Issue 1: Class not found
```bash
# Solution: Clear cache dan autoload
composer dump-autoload
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Issue 2: Migration failed
```bash
# Solution: Check database connection
php artisan config:cache

# Re-run migration
php artisan migrate:fresh
```

### Issue 3: Views not found
```bash
# Solution: Check file paths
ls -la resources/views/layouts/
ls -la resources/views/dashboard/

# Clear view cache
php artisan view:clear
```

### Issue 4: Routes not working
```bash
# Solution: Clear route cache
php artisan route:clear
php artisan route:cache
```

### Issue 5: Excel export error
```bash
# Solution: Install package
composer require maatwebsite/excel

# If still error, check config
php artisan config:publish
```

---

## Post-Installation

### Generate Sample Data
```bash
php artisan tinker
```

```php
// Generate 100 sample records
for ($i = 0; $i < 100; $i++) {
    \App\Models\Datalogger::create([
        'data1' => rand(200, 500) / 10,
        'data2' => rand(150, 800) / 10,
        'logged_at' => now()->subMinutes(100 - $i),
    ]);
}
exit
```

### Or use the web interface:
1. Buka dashboard
2. Scroll ke bagian "Testing Tools"
3. Klik "Generate 50 Sample Data"

---

## Testing API Endpoints

### Using cURL:

**Get History:**
```bash
curl -X GET "http://localhost:8000/api/datalogger/history?page=1&per_page=10"
```

**Get Realtime:**
```bash
curl -X GET "http://localhost:8000/api/datalogger/realtime"
```

**Get Statistics:**
```bash
curl -X GET "http://localhost:8000/api/datalogger/statistics"
```

**Generate Sample Data:**
```bash
curl -X POST "http://localhost:8000/api/datalogger/generate-sample" \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: your-token" \
  -d '{"count": 50}'
```

---

## Performance Check

### Check Response Time
```bash
# Install apache bench
apt-get install apache2-utils

# Test endpoint
ab -n 100 -c 10 http://localhost:8000/api/datalogger/history
```

### Check Memory Usage
```bash
# Monitor while testing
php artisan serve &
top -p $(pgrep -f "artisan serve")
```

---

## Security Checklist (For Production)

- [ ] Enable HTTPS
- [ ] Add authentication middleware
- [ ] Add rate limiting
- [ ] Validate all inputs
- [ ] Sanitize outputs
- [ ] Enable CORS properly
- [ ] Use environment variables
- [ ] Enable error logging
- [ ] Set proper file permissions
- [ ] Disable debug mode in production

---

## Final Verification

### Frontend Checklist
- [ ] Dashboard loads successfully
- [ ] Statistics cards show data
- [ ] Chart displays correctly
- [ ] Realtime data updates every 5 seconds
- [ ] History table shows data with pagination
- [ ] Sorting works (ID, Data1, Data2, Logged At)
- [ ] Filtering by date range works
- [ ] Download CSV works
- [ ] Download Excel works
- [ ] Responsive design works on mobile
- [ ] Dark mode works (if enabled)
- [ ] No JavaScript errors in console

### Backend Checklist
- [ ] All routes accessible
- [ ] API returns correct JSON
- [ ] Database queries optimized
- [ ] No PHP errors in log
- [ ] Pagination working
- [ ] Sorting working
- [ ] Filtering working
- [ ] File downloads working

---

## Completion

✅ Installation Complete!

Your dashboard is now ready to use. Access it at:
```
http://localhost:8000
```

For production deployment, follow the security checklist above.

---

## Next Steps

1. **Customize the design** to match your brand
2. **Add authentication** for user management
3. **Implement WebSocket** for true real-time updates
4. **Add more charts** (pie, bar, area)
5. **Create mobile app** using Flutter/React Native
6. **Add email notifications** for alerts
7. **Implement data backup** system
8. **Add export to PDF** feature
9. **Create API documentation** page
10. **Add unit tests** and integration tests

---

**Need Help?**
- Check `README.md` for general information
- Check `API_DOCUMENTATION.md` for API details
- Check `QUICK_START_GUIDE.md` for quick setup
- Check `PROJECT_STRUCTURE.md` for file structure

---

**Installation Date:** _________________

**Installed By:** _________________

**Notes:** 
_________________________________________________________________
_________________________________________________________________
_________________________________________________________________

---

✨ **Happy Coding!** ✨
