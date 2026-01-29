# API Documentation - Dashboard Monitoring Datalogger

## Base URL
```
http://localhost:8000/api/datalogger
```

---

## Endpoints

### 1. Get History Data (Paginated)

**Endpoint:** `GET /api/datalogger/history`

**Description:** Mengambil data history dengan pagination, sorting, dan filtering.

**Query Parameters:**

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| page | integer | No | 1 | Nomor halaman |
| per_page | integer | No | 20 | Jumlah data per halaman |
| sort_by | string | No | logged_at | Kolom untuk sorting (id, data1, data2, logged_at) |
| sort_order | string | No | desc | Urutan sorting (asc, desc) |
| start_date | datetime | No | - | Filter tanggal mulai (format: Y-m-d H:i:s) |
| end_date | datetime | No | - | Filter tanggal akhir (format: Y-m-d H:i:s) |

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/datalogger/history?page=1&per_page=20&sort_by=logged_at&sort_order=desc"
```

**Example Response:**
```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "data1": 35.5,
            "data2": 67.3,
            "logged_at": "2026-01-29 10:30:00",
            "created_at": "2026-01-29T10:30:00.000000Z",
            "updated_at": "2026-01-29T10:30:00.000000Z"
        }
    ],
    "first_page_url": "http://localhost:8000/api/datalogger/history?page=1",
    "from": 1,
    "last_page": 5,
    "last_page_url": "http://localhost:8000/api/datalogger/history?page=5",
    "next_page_url": "http://localhost:8000/api/datalogger/history?page=2",
    "path": "http://localhost:8000/api/datalogger/history",
    "per_page": 20,
    "prev_page_url": null,
    "to": 20,
    "total": 100
}
```

---

### 2. Get Realtime Data

**Endpoint:** `GET /api/datalogger/realtime`

**Description:** Mengambil data terbaru untuk monitoring realtime.

**Query Parameters:**

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| limit | integer | No | 1 | Jumlah data terbaru yang diambil |

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/datalogger/realtime?limit=1"
```

**Example Response:**
```json
[
    {
        "id": 100,
        "data1": 42.8,
        "data2": 75.2,
        "logged_at": "2026-01-29 15:45:30",
        "created_at": "2026-01-29T15:45:30.000000Z",
        "updated_at": "2026-01-29T15:45:30.000000Z"
    }
]
```

---

### 3. Get Chart Data

**Endpoint:** `GET /api/datalogger/chart`

**Description:** Mengambil data untuk visualisasi grafik.

**Query Parameters:**

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| limit | integer | No | 100 | Jumlah data untuk grafik |
| start_date | datetime | No | - | Filter tanggal mulai |
| end_date | datetime | No | - | Filter tanggal akhir |

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/datalogger/chart?limit=100"
```

**Example Response:**
```json
[
    {
        "logged_at": "2026-01-29 10:00:00",
        "data1": 35.5,
        "data2": 67.3
    },
    {
        "logged_at": "2026-01-29 10:05:00",
        "data1": 36.2,
        "data2": 68.1
    }
]
```

---

### 4. Get Statistics

**Endpoint:** `GET /api/datalogger/statistics`

**Description:** Mengambil statistik ringkasan data.

**Query Parameters:**

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| start_date | datetime | No | - | Filter tanggal mulai |
| end_date | datetime | No | - | Filter tanggal akhir |

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/datalogger/statistics"
```

**Example Response:**
```json
{
    "total_records": 100,
    "data1_avg": 37.45,
    "data1_min": 20.0,
    "data1_max": 50.0,
    "data2_avg": 54.32,
    "data2_min": 15.0,
    "data2_max": 80.0
}
```

---

### 5. Download CSV

**Endpoint:** `GET /api/datalogger/download/csv`

**Description:** Download data dalam format CSV.

**Query Parameters:**

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| start_date | datetime | No | - | Filter tanggal mulai |
| end_date | datetime | No | - | Filter tanggal akhir |

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/datalogger/download/csv?start_date=2026-01-01&end_date=2026-01-31" --output datalogger.csv
```

**Response:** File CSV akan didownload.

---

### 6. Download Excel

**Endpoint:** `GET /api/datalogger/download/excel`

**Description:** Download data dalam format Excel (XLSX).

**Query Parameters:**

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| start_date | datetime | No | - | Filter tanggal mulai |
| end_date | datetime | No | - | Filter tanggal akhir |

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/datalogger/download/excel?start_date=2026-01-01&end_date=2026-01-31" --output datalogger.xlsx
```

**Response:** File Excel akan didownload.

**Note:** Memerlukan package `maatwebsite/excel`.

---

### 7. Store New Data

**Endpoint:** `POST /api/datalogger/store`

**Description:** Menyimpan data baru ke database.

**Headers:**
```
Content-Type: application/json
X-CSRF-TOKEN: {csrf_token}
```

**Request Body:**

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| data1 | float | Yes | Nilai data 1 |
| data2 | float | Yes | Nilai data 2 |
| logged_at | datetime | No | Timestamp data (default: sekarang) |

**Example Request:**
```bash
curl -X POST "http://localhost:8000/api/datalogger/store" \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -d '{
    "data1": 35.5,
    "data2": 67.3,
    "logged_at": "2026-01-29 10:30:00"
  }'
```

**Example Response:**
```json
{
    "success": true,
    "message": "Data berhasil disimpan",
    "data": {
        "id": 101,
        "data1": 35.5,
        "data2": 67.3,
        "logged_at": "2026-01-29 10:30:00",
        "created_at": "2026-01-29T10:30:00.000000Z",
        "updated_at": "2026-01-29T10:30:00.000000Z"
    }
}
```

**Validation Errors:**
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "data1": ["The data1 field is required."],
        "data2": ["The data2 field must be a number."]
    }
}
```

---

### 8. Generate Sample Data

**Endpoint:** `POST /api/datalogger/generate-sample`

**Description:** Generate data sample untuk testing (demo purposes only).

**Headers:**
```
Content-Type: application/json
X-CSRF-TOKEN: {csrf_token}
```

**Request Body:**

| Field | Type | Required | Default | Description |
|-------|------|----------|---------|-------------|
| count | integer | No | 50 | Jumlah data yang akan digenerate |

**Example Request:**
```bash
curl -X POST "http://localhost:8000/api/datalogger/generate-sample" \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -d '{
    "count": 100
  }'
```

**Example Response:**
```json
{
    "success": true,
    "message": "100 data sample berhasil dibuat"
}
```

---

## Error Responses

### 404 Not Found
```json
{
    "message": "Resource not found"
}
```

### 422 Unprocessable Entity (Validation Error)
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "data1": ["The data1 field is required."]
    }
}
```

### 500 Internal Server Error
```json
{
    "message": "Server Error",
    "error": "Error description"
}
```

---

## Rate Limiting

API tidak memiliki rate limiting untuk demo/pelatihan. Dalam production, disarankan untuk menambahkan rate limiting.

---

## Authentication

Untuk demo/pelatihan, API tidak menggunakan authentication. Dalam production, disarankan untuk menambahkan authentication (Bearer Token, API Key, dll).

---

## CORS

CORS belum dikonfigurasi. Jika diperlukan akses dari domain lain, configure CORS di `config/cors.php`.

---

## Testing dengan Postman

Import collection berikut ke Postman untuk testing:

1. Create new Collection: "Datalogger API"
2. Add requests sesuai endpoints di atas
3. Set base URL sebagai variable: `{{base_url}}`
4. Set CSRF token sebagai variable: `{{csrf_token}}`

---

## Websocket (Future Enhancement)

Untuk monitoring realtime yang lebih baik, bisa menggunakan:
- Laravel Echo + Pusher
- Laravel Websockets
- Socket.io

---

## Notes

- Semua datetime menggunakan format: `Y-m-d H:i:s`
- Timezone default: UTC (dapat dikonfigurasi di `config/app.php`)
- Database timestamps otomatis dikelola oleh Laravel

---

**Last Updated:** 2026-01-29
