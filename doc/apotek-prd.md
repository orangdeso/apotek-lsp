# Product Requirements Document (PRD)
## Sistem Aplikasi Penjualan Obat

### 1. Overview Proyek
Aplikasi web berbasis Laravel untuk sistem penjualan obat dengan fitur CRUD lengkap, autentikasi multi-role, dan manajemen data obat, supplier, pelanggan, dan transaksi penjualan.

### 2. Tech Stack
- **Backend**: Laravel (PHP Framework)
- **Frontend**: HTML, CSS, JavaScript, Bootstrap
- **Database**: MySQL
- **Template**: Bootstrap 5
- ****Authentication**: Laravel Breeze


### 3. User Roles & Authentication

#### 3.1 Role: Pelanggan
**Hak Akses:**
- Dapat mengakses halaman login dan sign up
- Dapat mengakses halaman home untuk melihat daftar obat
- Dapat melihat halaman detail obat
- Dapat melakukan transaksi pembelian obat
- Dapat melihat riwayat transaksi pribadi
- Dapat mencari obat berdasarkan nama atau kategori

#### 3.2 Role: Apoteker
**Hak Akses:**
- Login terlebih dahulu untuk masuk ke halaman dashboard
- Dapat mengakses halaman utama yang menampilkan data obat
- Dapat menambahkan data obat dan detail obat
- Dapat menambahkan data penjualan obat
- Dapat mencari obat

#### 3.3 Role: Admin
**Hak Akses:**
- Penulis harus login terlebih dahulu untuk masuk ke halaman dashboard
- Dapat mendaftarkan Apoteker
- Dapat mendaftarkan Obat
- Dapat mendaftarkan Supplier
- Dapat mendaftarkan Pelanggan
- Dapat menambahkan, mengedit atau menghapus data obat
- Dapat mencari obat yang akan kadaluarsa
- Dapat melihat report penjualan obat
- Dapat melihat daftar obat
- Dapat melihat daftar supplier
- Dapat melihat daftar pembelian obat
- Dapat mengubah status obat

### 4. Fitur Utama Aplikasi

#### 4.1 Halaman Utama & Navigation
- Halaman utama menampilkan daftar obat yang terjual dan jumlah obat
- Navigation menu yang responsif dengan Bootstrap

#### 4.2 Fitur Obat Management
- **Tampil obat**: Bila nama obat diklik akan menuju ke halaman baru yang menampilkan detail dari obat
- **Penjualan**: Ketika penjualan diklik akan menuju ke halaman baru yang menampilkan detail dari penjualan
- **Lihat daftar obat**: Untuk melihat daftar obat yang dijual [user pelanggan]
- **Detail obat**: Halaman detail lengkap obat dengan informasi harga, stok, deskripsi [user pelanggan]
- **Tambah obat baru**: [user apoteker]
- **Hapus obat lama**: [user apoteker]
- **Lihat histori penjualan obat**: [user apoteker]
- **Hapus data obat kadaluarsa**: [user apoteker]

#### 4.3 Fitur Pelanggan
- **Halaman Home**: Menampilkan daftar obat yang tersedia dengan search dan filter
- **Detail Obat**: Informasi lengkap obat, harga, stok, dan opsi beli
- **Transaksi Obat**: Pelanggan dapat melakukan pembelian obat
- **Riwayat Transaksi**: Melihat histori pembelian pribadi
- **Profile Management**: Edit informasi pribadi pelanggan

#### 4.4 Fitur Admin Management
- **Lihat daftar apoteker**: [user admin]
- **Lihat daftar pembelian obat**: [user admin]
- **Daftar supplier**: [user admin]
- **Daftar pelanggan**: Manage data pelanggan [user admin]
- **Daftar, mengedit apoteker baru maupun mengedit apoteker yang sudah ada sebelumnya**: [user admin]

#### 4.5 User Authentication
- **Halaman Sign Up**: Untuk user yang ingin mendaftar sebagai pelanggan
- **Halaman Login**: Untuk user yang sudah menjadi pelanggan aktif, user admin dan apoteker
- **Multi-role Login**: Redirect sesuai role setelah login
- **Session Management**: Maintain login state untuk setiap role

### 5. Database Schema & Relationships

#### 5.1 Tabel Utama:

**Tabel Users** (Untuk Authentication)
- id_user (Primary Key)
- name
- email
- password
- alamat
- kota
- telpon
- role (enum: 'admin', 'apoteker', 'pelanggan')
- remember_token
- created_at
- updated_at

**Tabel Obat**
- id_obat (Primary Key)
- name_obat
- type
- unit
- purchase_price
- sale_price
- stok
- description
- image
- expdate
- id_supplier (Foreign Key)
- created_at
- updated_at

**Tabel Supplier**
- id_supplier (Primary Key)
- name_supplier
- alamat
- kota
- telpon

**Penjualan**
- id_penjualan (Primary Key)
- user_id (Foreign Key - untuk tracking pelanggan yang login)
- total
- status ('pending', 'confirmed', 'completed', 'cancelled')
- created_at
- updated_at

**Penjualan_Detail**
- id_penjualan (Foreign Key)
- id_obat (Foreign Key)
- quantity
- unit_price
- subtotal

**Pembelian**
- id_pembelian (Primary Key)
- id_supplier (Foreign Key)
- total
- status ('pending', 'confirmed', 'completed', 'cancelled')
- created_at
- updated_at

**Pembelian_Detail**
- id_pembelian (Foreign Key)
- id_obat (Foreign Key)
- quantity
- unit_price
- subtotal

<!-- **Tabel Keranjang** (Cart untuk Pelanggan)
- id (Primary Key)
- user_id (Foreign Key)
- KdObat (Foreign Key)
- Jumlah
- created_at
- updated_at -->

#### 5.2 Database Relations:
- **Users** has one **Pelanggan** (One-to-One)
- **Users** has one **Apoteker** (One-to-One)
- **Obat** belongs to **Supplier** (Many-to-One)
- **Penjualan** belongs to **Pelanggan** (Many-to-One)
- **Penjualan** belongs to **Users** (Many-to-One)
- **Penjualan** has many **Penjualan_Detail** (One-to-Many)
- **Penjualan_Detail** belongs to **Obat** (Many-to-One)
- **Pembelian** belongs to **Supplier** (Many-to-One)
- **Pembelian** has many **Pembelian_Detail** (One-to-Many)
- **Pembelian_Detail** belongs to **Obat** (Many-to-One)
<!-- - **Keranjang** belongs to **Users** (Many-to-One)
- **Keranjang** belongs to **Obat** (Many-to-One) -->

### 6. Fitur CRUD yang Dibutuhkan

#### 6.1 Management Obat
- Create: Tambah obat baru (Admin/Apoteker)
- Read: Lihat daftar obat, detail obat (Semua role)
- Update: Edit informasi obat, update stok (Admin/Apoteker)
- Delete: Hapus obat (khususnya yang kadaluarsa) (Admin/Apoteker)

#### 6.2 Management Supplier
- Create: Daftar supplier baru (Admin)
- Read: Lihat daftar supplier (Admin/Apoteker)
- Update: Edit informasi supplier (Admin)
- Delete: Hapus supplier (Admin)

#### 6.3 Management Pelanggan
- Create: Registrasi pelanggan baru (Public/Admin)
- Read: Lihat daftar pelanggan (Admin), Profile sendiri (Pelanggan)
- Update: Edit informasi pelanggan (Admin/Pelanggan untuk profile sendiri)
- Delete: Hapus pelanggan (Admin)

#### 6.4 Management Apoteker
- Create: Daftar apoteker baru (Admin only)
- Read: Lihat daftar apoteker (Admin)
- Update: Edit informasi apoteker (Admin)
- Delete: Hapus apoteker (Admin)

#### 6.5 Management Transaksi Penjualan
- Create: Buat transaksi penjualan baru (Pelanggan/Apoteker)
- Read: Lihat histori transaksi (Admin: semua, Apoteker: semua, Pelanggan: milik sendiri)
- Update: Edit status transaksi (Admin/Apoteker)
- Delete: Cancel transaksi (Pelanggan untuk transaksi pending)

#### 6.6 Management Keranjang Belanja
<!-- - Create: Tambah item ke keranjang (Pelanggan)
- Read: Lihat isi keranjang (Pelanggan)
- Update: Update quantity item (Pelanggan)
- Delete: Hapus item dari keranjang (Pelanggan) -->

### 7. Halaman & Interface untuk Setiap Role

#### 7.1 Halaman Umum (Public)
- **Landing Page**: Informasi umum apotek
- **Login Page**: Form login dengan role selection
- **Register Page**: Form registrasi untuk pelanggan baru

#### 7.2 Halaman Pelanggan
- **Home/Dashboard**: Daftar obat dengan search & filter
- **Detail Obat**: Informasi lengkap obat + tombol tambah ke keranjang
<!-- - **Keranjang**: Manajemen cart sebelum checkout -->
- **Checkout**: Form pemesanan dan pembayaran
- **Riwayat Transaksi**: History pembelian pelanggan
- **Profile**: Edit informasi pribadi

#### 7.3 Halaman Apoteker
- **Dashboard**: Summary data obat, penjualan hari ini
- **Management Obat**: CRUD obat
- **Penjualan**: Proses transaksi offline/manual
- **Laporan**: Report penjualan dan stok
- **Profile**: Edit informasi pribadi

#### 7.4 Halaman Admin
- **Dashboard**: Summary lengkap sistem
- **Management User**: CRUD apoteker dan pelanggan
- **Management Obat**: CRUD obat
- **Management Supplier**: CRUD supplier
- **Management Transaksi**: Monitor semua transaksi
- **Laporan**: Report comprehensive
- **Settings**: Konfigurasi sistem

### 8. Fitur Khusus
- **Search**: Pencarian obat berdasarkan nama atau kategori
- **Filter**: Filter obat berdasarkan tanggal kadaluarsa
- **Report**: Laporan penjualan obat
- **Dashboard**: Summary data untuk admin dan apoteker
- **Responsive Design**: Menggunakan Bootstrap untuk tampilan mobile-friendly

### 8. Fitur Khusus
- **Multi-role Authentication**: Login system untuk 3 role berbeda
- **Search & Filter**: Pencarian obat berdasarkan nama, kategori, harga
<!-- - **Shopping Cart**: Sistem keranjang belanja untuk pelanggan -->
- **Transaction Status**: Tracking status pesanan (pending, confirmed, completed)
- **Stock Management**: Alert untuk stok rendah dan obat kadaluarsa
- **Report System**: Laporan penjualan, pembelian, dan inventory
- **Dashboard**: Summary data untuk setiap role
- **Responsive Design**: Bootstrap untuk tampilan mobile-friendly
- **Image Upload**: Upload gambar obat

### 9. Security Requirements
- Authentication middleware untuk setiap role
- Password hashing
- CSRF protection
- Input validation dan sanitization
- Session management

### 9. Security Requirements
- **Multi-role Authentication**: Middleware untuk setiap role dengan redirect yang tepat
- **Password Hashing**: Bcrypt untuk enkripsi password
- **CSRF Protection**: Laravel CSRF token untuk semua form
- **Input Validation**: Validation rules untuk semua input
- **Session Management**: Secure session handling
- **Route Protection**: Middleware auth untuk halaman yang memerlukan login
- **Role-based Access Control**: Pembatasan akses berdasarkan role user

### 10. Deliverables
- Sistem CRUD Laravel yang lengkap dan fungsional
- Database dengan relasi yang benar
- UI/UX yang user-friendly dengan Bootstrap
- Authentication system dengan multi-role
- Fitur pencarian dan filtering
- System testing dan dokumentasi

### 10. Deliverables
- **Full Stack Laravel App**: Sistem CRUD lengkap dengan 3 role user
- **Database Schema**: MySQL dengan relasi yang benar dan seeded data
- **Authentication System**: Multi-role login dengan proper authorization  
- **Frontend Interface**: Bootstrap responsive design untuk semua halaman
<!-- - **Shopping Cart System**: Fitur e-commerce untuk pelanggan -->
- **Transaction Management**: Sistem pemesanan dan tracking status
- **Report System**: Dashboard dan laporan untuk setiap role
- **Testing**: Unit test dan feature test untuk fungsi utama
- **Documentation**: API documentation dan user manual

### 11. Success Criteria
- **Authentication**: Login/register berfungsi untuk semua role dengan redirect yang tepat
- **CRUD Operations**: Semua fitur CRUD berfungsi sesuai permission role
- **E-commerce Flow**: Pelanggan dapat browse → add to cart → checkout → track order
- **Admin Panel**: Admin dapat manage semua data dan melihat laporan lengkap
- **Apoteker Interface**: Apoteker dapat manage obat dan proses transaksi
- **Database Relations**: Semua foreign key dan relasi berfungsi dengan benar
- **Responsive UI**: Tampilan mobile-friendly di semua halaman
- **Security**: Proper authentication dan authorization untuk setiap fitur
- **Performance**: Load time optimal dan handling concurrent users
- **Ready for Demo**: Aplikasi siap digunakan untuk ujian kompetensi kampus