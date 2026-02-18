# Dashboard Monitoring System (Datalogger + MQTT)

🚀 **Panduan Setup dan Penggunaan**

Sistem monitoring datalogger berbasis Laravel dengan integrasi MQTT untuk pemantauan data sensor secara real-time.

---

## 🛠️ Instalasi & Setup (Local Development)

Ikuti langkah-langkah berikut untuk menjalankan project di mesin lokal Anda:

### 1. Clone Repository
```bash
git clone https://github.com/username/dummy-website.git
cd dummy-website
```

### 2. Install Dependencies
Project ini menggunakan Composer untuk manajemen library PHP.
```bash
composer install
```
> **Catatan:** Project ini menggunakan CDN untuk Tailwind CSS, Chart.js, dan Alpine.js, sehingga Anda tidak perlu menjalankan `npm install` kecuali ingin menambahkan build process kustom.

### 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env` dan generate application key:
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database
1. Buat database baru di MySQL/MariaDB (misal: `demo_application`).
2. Update konfigurasi database di file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=demo_application
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Jalankan migration:
```bash
php artisan migrate
```

### 5. Setup MQTT
Sesuaikan detail broker MQTT di `.env`. Untuk testing, Anda bisa menggunakan broker publik:
```env
MQTT_HOST=broker.emqx.io
MQTT_PORT=1883
MQTT_AUTH_USERNAME=    # Kosongkan jika tanpa auth
MQTT_AUTH_PASSWORD=    # Kosongkan jika tanpa auth
MQTT_CLIENT_ID=        # Kosongkan untuk auto-id
MQTT_SUBSCRIBE_TOPIC=data/Haiwell/percobaan1/+
```

---

## 📡 Cara Menjalankan Aplikasi

### 1. Jalankan Web Server
```bash
php artisan serve
```
Akses dashboard di Browser: [http://localhost:8000](http://127.0.0.1:8000)

### 2. Jalankan MQTT Subscriber (Penting!)
Agar data yang dikirim sensor tersimpan ke database, Anda harus menjalankan worker di terminal terpisah:
```bash
php artisan app:mqtt-subscribe
```

---

## 🚀 Deployment (Production)

Untuk menjalankan aplikasi di server produksi (Linux/Ubuntu), perhatikan poin berikut:

### 1. Optimasi Laravel
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Management Process (MQTT Worker)
Di produksi, jangan menjalankan `php artisan app:mqtt-subscribe` secara manual. Gunakan **Supervisor** agar worker otomatis restart jika mati.

Contoh konfigurasi Supervisor (`/etc/supervisor/conf.d/mqtt-worker.conf`):
```ini
[program:mqtt-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/artisan app:mqtt-subscribe
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/www/html/storage/logs/mqtt-worker.log
```

---

## 📊 Panduan Dashboard

- **Tab Live (Live Dashboard):** Monitoring real-time dari MQTT. Grafik hanya akan terisi saat ada data masuk setelah halaman dibuka.
- **Tab Riwayat (History):** Melihat data masa lalu yang tersimpan di database. Mendukung filter tanggal dan ekspor data ke Excel/CSV.
- **Generate Data:** Gunakan tombol "Generate 50 Sample Data" di bagian bawah dashboard untuk melakukan pengujian tanpa perangkat MQTT.

---

Happy Monitoring! 📊🚀
