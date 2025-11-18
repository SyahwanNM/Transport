# Panduan Admin Panel

## Akses Admin Panel

1. Buka URL: `/admin/login`
2. Masukkan password admin (default: `admin123` atau sesuai dengan `ADMIN_PASSWORD` di file `.env`)

## Fitur Admin Panel

### 1. Dashboard
- Menampilkan statistik total kota pembanding dan total history penggunaan
- Menampilkan 10 history terbaru

### 2. Kelola Kota Pembanding
- **Tambah Kota**: Tambahkan kota baru yang dapat digunakan sebagai pembanding
- **Edit Kota**: Edit data kota yang sudah ada
- **Hapus Kota**: Hapus kota (tidak bisa dihapus jika sudah digunakan dalam history)

### 3. History Penggunaan
- Melihat semua history penggunaan sistem perhitungan tarif
- Menampilkan detail:
  - Tanggal & waktu penggunaan
  - Nama kota user
  - Kota pembanding yang digunakan
  - Tarif aktual dan rekomendasi
  - Selisih tarif
  - Skor preferensi

## Mengatur Password Admin

Untuk mengubah password admin, tambahkan atau edit di file `.env`:

```env
ADMIN_PASSWORD=password_anda_disini
```

Jika tidak ada di `.env`, default password adalah `admin123`.

## Catatan Keamanan

⚠️ **Penting**: Untuk production, disarankan untuk:
1. Menggunakan authentication yang lebih aman (Laravel Auth)
2. Menggunakan hash password
3. Menambahkan rate limiting untuk login
4. Menggunakan HTTPS

## Routes Admin

- `GET /admin/login` - Halaman login
- `POST /admin/login` - Proses login
- `GET /admin/dashboard` - Dashboard (protected)
- `POST /admin/logout` - Logout (protected)
- `GET /admin/kota` - Daftar kota (protected)
- `GET /admin/kota/create` - Form tambah kota (protected)
- `POST /admin/kota/store` - Simpan kota baru (protected)
- `GET /admin/kota/{id}/edit` - Form edit kota (protected)
- `PUT /admin/kota/{id}` - Update kota (protected)
- `DELETE /admin/kota/{id}` - Hapus kota (protected)
- `GET /admin/history` - History penggunaan (protected)

