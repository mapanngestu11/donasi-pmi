# Informasi Login Admin

## Kredensial Login
- **Email:** admin@pmi.com
- **Password:** password123

## Cara Setup User Admin

### Opsi 1: Menggunakan Seeder (Recommended)
Jalankan command berikut di terminal:
```bash
php artisan db:seed --class=AdminSeeder
```

Atau jika ingin menjalankan semua seeder:
```bash
php artisan db:seed
```

### Opsi 2: Menggunakan Tinker
Jalankan command berikut:
```bash
php artisan tinker
```

Kemudian ketik:
```php
App\Models\User::create([
    'name' => 'Administrator',
    'email' => 'admin@pmi.com',
    'password' => Hash::make('password123'),
    'email_verified_at' => now(),
]);
```

### Opsi 3: Langsung via Database
Masukkan langsung ke database tabel `users`:
- name: Administrator
- email: admin@pmi.com
- password: (gunakan Hash::make('password123') atau gunakan bcrypt('password123'))
- email_verified_at: (timestamp sekarang)

## Akses Admin Panel
Setelah user dibuat, akses halaman login di:
- URL: `/admin/login`
- Email: admin@pmi.com
- Password: password123

