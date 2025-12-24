# Solid Solihin Logger SDK

SDK PHP untuk mengirim log aplikasi ke Supabase secara **plug & play**, mendukung **CodeIgniter 4** dan **Laravel**.  
Menangani **manual logging** maupun **global unhandled exception logging**.

---

## Fitur

- Kirim log info / error manual ke Supabase
- Tangkap **semua unhandled exception** secara otomatis
- Compatible dengan **CodeIgniter 4** dan **Laravel**
- Async-like menggunakan cURL timeout pendek (tidak blok eksekusi)
- Debug mode untuk melihat log cURL

---

## Instalasi

1. Tambahkan SDK ke project via composer (private repo atau path lokal):

```bash
composer require monarch/solid-solihin

## CI4 .env 
SOLID_SOLIHIN_ENDPOINT=https://<API_ENDPOINT>/functions/v1/log-ingest
SOLID_SOLIHIN_PROJECT_CODE=prj_xxxxxxxx
SOLID_SOLIHIN_PROJECT_KEY=pk_xxxxxxxx
CI_ENVIRONMENT=development
APP_ENV=local
