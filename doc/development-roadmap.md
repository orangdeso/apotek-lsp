# Development Roadmap
## Sistem Penjualan Obat Laravel - Ujian Kompetensi

### 📅 Timeline Overview
**Total Duration**: 6 Hari Intensif (25 Juli - 30 Juli 2025)  
**Target**: Aplikasi CRUD Laravel siap untuk ujian kompetensi kampus

---

## 🏗️ Day 1-2 (25-26 Juli): Foundation & Setup

## 🏗️ Day 1-2 (25-26 Juli): Foundation & Setup

### 🎯 **Goal**: Membangun fondasi aplikasi yang solid dalam 2 hari

#### **Day 1 (25 Juli): Project Setup & Database**
**📋 Morning Tasks (08:00-12:00):**
- [ ] Install Laravel project baru
- [ ] Setup database MySQL
- [ ] Konfigurasi `.env` file
- [ ] Install dependencies (Laravel Breeze, Bootstrap)

**📊 Afternoon Tasks (13:00-18:00) - Database Migrations:**
- [ ] Migration `users` table dengan role field
- [ ] Migration `obat` table 
- [ ] Migration `pelanggan` table
- [ ] Migration `supplier` table
- [ ] Migration `apoteker` table
- [ ] Migration `penjualan` table
- [ ] Migration `penjualan_detail` table
- [ ] Migration `pembelian` table
- [ ] Migration `pembelian_detail` table
- [ ] Migration `keranjang` table

#### **Day 2 (26 Juli): Models & Authentication**
**📋 Morning Tasks (08:00-12:00) - Models & Relationships:**
- [ ] Buat Model User dengan role enum
- [ ] Buat Model Obat dengan relationship ke Supplier
- [ ] Buat Model Pelanggan dengan relationship ke User
- [ ] Buat Model Supplier
- [ ] Buat Model Apoteker dengan relationship ke User
- [ ] Buat Model Penjualan dengan relationships
- [ ] Buat Model PenjualanDetail
- [ ] Buat Model Pembelian dengan relationships
- [ ] Buat Model PembelianDetail
- [ ] Buat Model Keranjang

**📋 Afternoon Tasks (13:00-18:00) - Authentication & Seeder:**
- [ ] Install Laravel Breeze
- [ ] Customize register form untuk role pelanggan
- [ ] Buat middleware RoleMiddleware
- [ ] Setup route protection berdasarkan role
- [ ] Seeder untuk Users (admin, apoteker, pelanggan sample)
- [ ] Seeder untuk Supplier (5-10 supplier dummy)
- [ ] Seeder untuk Obat (20-50 obat dummy)
- [ ] Test semua relationship dengan Tinker

**📈 Day 1-2 Success Metrics:**
- ✅ Database schema lengkap dan migrations berjalan
- ✅ Semua models dan relationships berfungsi
- ✅ Authentication multi-role working
- ✅ Seeder data dummy ready

---

## ⚙️ Day 3-4 (27-28 Juli): Core Features Development

## ⚙️ Day 3-4 (27-28 Juli): Core Features Development

### 🎯 **Goal**: Implementasi fitur CRUD utama dan frontend

#### **Day 3 (27 Juli): CRUD Backend Development**
**📋 Morning Tasks (08:00-12:00) - CRUD Controllers:**
- [ ] ObatController dengan CRUD methods
- [ ] SupplierController dengan CRUD methods
- [ ] UserController untuk admin (manage apoteker & pelanggan)
- [ ] Form validation rules untuk semua form

**📋 Afternoon Tasks (13:00-18:00) - Advanced Features:**
- [ ] Image upload handling untuk obat
- [ ] Stock management logic
- [ ] Search & filter functionality
- [ ] Route definitions untuk semua CRUD operations

#### **Day 4 (28 Juli): Frontend Integration**
**📋 Morning Tasks (08:00-12:00) - Layout & Templates:**
- [ ] Setup master layout untuk setiap role
- [ ] Admin dashboard layout dengan sidebar
- [ ] Apoteker dashboard layout
- [ ] Pelanggan/customer layout dengan navbar
- [ ] Navigation menu berdasarkan role

**📋 Afternoon Tasks (13:00-18:00) - Views Development:**
- [ ] Halaman login & register yang responsive
- [ ] Dashboard untuk admin dengan statistics
- [ ] Dashboard untuk apoteker
- [ ] Home page untuk pelanggan (katalog obat)
- [ ] CRUD views untuk Obat (create, read, update, delete)
- [ ] CRUD views untuk Supplier
- [ ] CRUD views untuk User management

**📈 Day 3-4 Success Metrics:**
- ✅ Semua CRUD operations berfungsi
- ✅ Frontend terintegrasi dengan backend
- ✅ Role-based views working
- ✅ Responsive design implemented

---

## 🛒 Day 5-6 (29-30 Juli): E-commerce & Finalization

## 🛒 Day 5-6 (29-30 Juli): E-commerce & Finalization

### 🎯 **Goal**: Fitur e-commerce lengkap dan aplikasi siap demo

#### **Day 5 (29 Juli): Shopping Cart & Checkout**
**📋 Morning Tasks (08:00-12:00) - E-commerce Core:**
- [ ] KeranjangController untuk cart management
- [ ] Add to cart functionality
- [ ] Update cart quantity & remove items
- [ ] Cart session/database handling
- [ ] Cart view dengan total calculation

**📋 Afternoon Tasks (13:00-18:00) - Transaction System:**
- [ ] Checkout form dengan validation
- [ ] PenjualanController dengan status tracking
- [ ] Order creation logic
- [ ] Stock reduction saat checkout
- [ ] Order confirmation page
- [ ] Transaction history untuk pelanggan

#### **Day 6 (30 Juli): Dashboard, Reports & Final Polish**
**📋 Morning Tasks (08:00-12:00) - Dashboard & Reports:**
- [ ] Admin dashboard dengan statistics (total obat, penjualan hari ini, dll)
- [ ] Apoteker dashboard dengan daily summary
- [ ] Pelanggan dashboard dengan order history
- [ ] Laporan penjualan sederhana
- [ ] Search obat dengan filter price/category

**📋 Afternoon Tasks (13:00-18:00) - Testing & Final Touch:**
- [ ] Testing complete user flow untuk semua role
- [ ] Testing e-commerce flow (browse → cart → checkout)
- [ ] Bug fixes dan optimization
- [ ] UI/UX improvements
- [ ] Success/error messages
- [ ] Final code cleanup
- [ ] Persiapan demo dan dokumentasi

**📈 Day 5-6 Success Metrics:**
- ✅ Shopping cart fully functional
- ✅ Complete checkout process
- ✅ Dashboard working untuk semua role
- ✅ All major bugs fixed
- ✅ Application ready for demo

---

## 📋 Daily Schedule Template (Intensif)

## 📋 Daily Schedule Template (Intensif)

### **⏰ Jadwal Harian (25-30 Juli):**
- **08:00-09:00**: Planning & review previous day
- **09:00-12:00**: Core development tasks
- **12:00-13:00**: Break & lunch
- **13:00-17:00**: Continued development
- **17:00-18:00**: Testing & bug fixes
- **18:00-19:00**: Code review & commit
- **19:00-20:00**: Documentation & preparation untuk hari berikutnya

### **Daily Standup Questions:**
1. ✅ Apa yang sudah diselesaikan kemarin?
2. 🎯 Apa yang akan dikerjakan hari ini?
3. ⚠️ Ada blocker atau kendala?
4. 📊 Progress terhadap target harian?

### **End of Day Review:**
- [ ] Commit & push code ke repository
- [ ] Update progress checklist
- [ ] Test fitur yang sudah dibuat
- [ ] Dokumentasi perubahan penting
- [ ] Prepare tasks untuk besok

---

## 🎯 Critical Success Factors (6 Hari Intensif)

## 🎯 Critical Success Factors (6 Hari Intensif)

### **Technical Requirements:**
- ✅ Laravel 10+ dengan PHP 8.1+
- ✅ MySQL 8.0+ untuk database
- ✅ Bootstrap 5 untuk frontend
- ✅ Git untuk version control

### **Development Strategy (Intensif Mode):**
- 🚀 **Focus on MVP**: Prioritas fitur core dulu
- ⚡ **Quick Prototyping**: Build fast, iterate later
- 🎯 **Time Boxing**: Maksimal 4 jam per major feature
- 🧪 **Test as You Go**: Jangan tunggu akhir untuk testing
- 📱 **Mobile First**: Bootstrap responsive dari awal

### **Quality Standards:**
- ✅ Clean, readable code (tapi jangan perfectionist)
- ✅ Basic error handling (focus on user experience)
- ✅ Input validation untuk security
- ✅ Responsive design yang functional
- ✅ Working demo untuk semua user role

---

## 🚨 Risk Mitigation (Timeline Ketat)

### **Potential Risks & Quick Solutions:**
1. **Waktu Habis untuk Feature Complex** 
   → Simplify: Basic cart tanpa advanced features
2. **Bug Sulit di Fix** 
   → Workaround: Disable feature, focus on working ones
3. **UI Tidak Perfect** 
   → Use Bootstrap templates, jangan custom CSS berlebihan
4. **Database Issues** 
   → Siapkan backup SQL dump
5. **Integration Problems** 
   → Test small pieces frequently

### **Backup Plans (Jika Tertinggal):**
- **Day 3-4**: Skip advanced search, focus basic CRUD
- **Day 5**: Simplified cart (session only, no database)
- **Day 6**: Basic dashboard, skip complex reports

### **Success Priorities (Must Have vs Nice to Have):**

**🔴 MUST HAVE (Core untuk ujian):**
- Login multi-role working
- CRUD Obat, Supplier, User working
- Basic shopping cart
- Transaction creation
- Simple dashboard

**🟡 NICE TO HAVE (Jika ada waktu):**
- Advanced search & filter
- Complex reports
- Email notifications
- Image uploads
- Advanced UI animations

---

## 📝 Quick Start Commands (Day 1)

```bash
# Setup Project (15 menit)
composer create-project laravel/laravel apotek-app
cd apotek-app
composer require laravel/breeze
php artisan breeze:install
npm install && npm run build

# Database Setup (10 menit)
php artisan migrate
cp .env.example .env
# Edit .env untuk database config
php artisan key:generate
```

---

## 🏆 Final Deliverables (30 Juli Evening)

### **Demo Ready Application:**
- ✅ Working login untuk admin, apoteker, pelanggan
- ✅ CRUD management yang functional
- ✅ Shopping cart dan checkout process
- ✅ Basic dashboard untuk setiap role
- ✅ Responsive design

### **Demo Script:**
1. **Login sebagai Admin** → Show user management
2. **Login sebagai Apoteker** → Show obat management  
3. **Login sebagai Pelanggan** → Show shopping flow
4. **Showcase** → Dashboard dan reports

### **Backup Demo:**
- ✅ Seeded database dengan data realistic
- ✅ Test accounts untuk setiap role
- ✅ Error handling yang graceful
- ✅ Fallback untuk fitur yang mungkin belum sempurna

---

**🔥 LET'S BUILD THIS IN 6 DAYS! FOCUS, SPEED, DELIVER! 🚀**

*Timeline ketat = Prioritas jelas. Core features first, polish later. You got this! 💪*