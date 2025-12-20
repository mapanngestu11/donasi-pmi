# Integrasi Midtrans - Donasi PMI

## Setup Konfigurasi

1. **Daftar di Midtrans**
   - Daftar akun di https://dashboard.midtrans.com/
   - Dapatkan Server Key dan Client Key dari dashboard

2. **Update file .env**
   Tambahkan konfigurasi berikut:
   ```env
   MIDTRANS_SERVER_KEY=your_server_key_here
   MIDTRANS_CLIENT_KEY=your_client_key_here
   MIDTRANS_IS_PRODUCTION=false
   MIDTRANS_IS_SANITIZED=true
   MIDTRANS_IS_3DS=true
   ```

3. **Jalankan Migration**
   ```bash
   php artisan migrate
   ```

## Cara Menggunakan

1. **Akses Halaman Donasi**
   - Klik tombol "Donasi Sekarang" di halaman beranda
   - Atau akses langsung: `/donasi/create`

2. **Isi Form Donasi**
   - Isi data lengkap (nama, email, program, jumlah)
   - Klik "Lanjutkan ke Pembayaran"

3. **Pembayaran Midtrans**
   - Popup Midtrans akan muncul
   - Pilih metode pembayaran yang diinginkan
   - Selesaikan pembayaran

4. **Status Donasi**
   - Setelah pembayaran, akan diarahkan ke halaman status
   - Status akan otomatis update via webhook

## Webhook Configuration

Untuk production, setup webhook URL di Midtrans Dashboard:
```
https://yourdomain.com/donasi/notification
```

## Testing

Gunakan kartu test berikut untuk testing di sandbox:
- **Credit Card**: 4811 1111 1111 1114
- **CVV**: 123
- **Expiry**: 12/25

## Routes

- `GET /donasi/create` - Form donasi
- `POST /donasi/store` - Proses donasi dan create payment
- `GET /donasi/status/{orderId}` - Status donasi
- `POST /donasi/notification` - Webhook dari Midtrans
- `GET /donasi/finish` - Redirect setelah pembayaran berhasil
- `GET /donasi/unfinish` - Redirect jika pembayaran pending
- `GET /donasi/error` - Redirect jika terjadi error

