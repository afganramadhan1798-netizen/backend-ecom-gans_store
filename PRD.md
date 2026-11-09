<p align="center">
  <img
    src="public/images/Logo.png"
    alt="Gan's Store Logo"
    width="160"
  />
</p>

<h1 align="center">PRODUCT REQUIREMENTS DOCUMENT</h1>
<h2 align="center">GAN'S STORE</h2>

<p align="center">
  E-Commerce Website
</p>

# PRODUCT REQUIREMENTS DOCUMENT (PRD)
# GAN'S STORE — E-Commerce Website

**Project Name:** Gan's Store  
**Product Type:** Web-Based E-Commerce Application  
**Version:** 1.0.0  
**Status:** Development  
**Frontend:** Vue.js  
**Backend:** Laravel 13  
**Database:** MySQL  

---

## 1. Project Overview

### 1.1 Background

Perkembangan teknologi digital telah mengubah cara masyarakat melakukan aktivitas jual beli. E-commerce menjadi salah satu solusi yang memudahkan pelanggan dalam mencari produk, memperoleh informasi, serta melakukan pemesanan secara online.

Gan's Store merupakan aplikasi e-commerce berbasis website yang dikembangkan untuk menyediakan pengalaman berbelanja secara online dengan antarmuka yang sederhana, modern, dan mudah digunakan.

Aplikasi ini memiliki dua jenis pengguna utama, yaitu Customer dan Admin. Customer dapat menjelajahi produk, mengelola keranjang belanja, menyimpan produk favorit, serta melakukan pemesanan. Sementara itu, Admin memiliki akses untuk mengelola produk, kategori, pengguna, dan pesanan melalui dashboard admin.

### 1.2 Product Vision

Membangun platform e-commerce yang praktis, responsif, dan mudah digunakan untuk mendukung proses penjualan serta pengelolaan toko secara digital.

### 1.3 Product Goals

- Menyediakan platform belanja online yang mudah diakses.
- Mempermudah pelanggan dalam mencari dan memilih produk.
- Menyediakan fitur pengelolaan keranjang dan wishlist.
- Mempermudah proses pemesanan dan pemantauan pesanan.
- Menyediakan dashboard admin untuk pengelolaan toko.
- Mengintegrasikan frontend dan backend melalui REST API.

---

## 2. Target Users

### 2.1 Customer

Customer merupakan pengguna yang menggunakan aplikasi untuk melakukan aktivitas belanja online.

Kebutuhan:
- Melihat daftar produk dan kategori.
- Melihat detail produk.
- Menambahkan produk ke keranjang.
- Menyimpan produk ke wishlist.
- Mengelola alamat pengguna.
- Melakukan checkout dan membuat pesanan.
- Melihat riwayat serta status pesanan.
- Membatalkan pesanan sesuai ketentuan sistem.

### 2.2 Admin

Admin merupakan pengguna yang bertanggung jawab terhadap pengelolaan toko.

Kebutuhan:
- Mengakses dashboard admin.
- Melihat dan mengelola produk.
- Mengelola kategori produk.
- Melihat data pengguna.
- Mengubah role dan status akun pengguna.
- Melihat seluruh pesanan.
- Memperbarui status pesanan.

---

## 3. Functional Requirements

### 3.1 Authentication & Authorization

| ID | Requirement | Description |
|---|---|---|
| FR-01 | Register | Pengguna dapat membuat akun baru. |
| FR-02 | Login | Pengguna dapat masuk menggunakan akun terdaftar. |
| FR-03 | Logout | Pengguna dapat keluar dari akun. |
| FR-04 | Authentication | Sistem menggunakan Laravel Sanctum untuk autentikasi API berbasis token. |
| FR-05 | Role Management | Sistem membedakan akses Customer dan Admin. |
| FR-06 | Account Status | Sistem membatasi akses akun yang tidak aktif. |

### 3.2 Product Management

| ID | Requirement | Description |
|---|---|---|
| FR-07 | Product Listing | Customer dapat melihat daftar produk aktif. |
| FR-08 | Product Detail | Customer dapat melihat detail produk. |
| FR-09 | Product Creation | Admin dapat menambahkan produk. |
| FR-10 | Product Update | Admin dapat memperbarui informasi produk. |
| FR-11 | Product Deletion | Admin dapat menghapus produk. |
| FR-12 | Product Image | Admin dapat mengunggah gambar produk. |
| FR-13 | Product Stock | Sistem menyimpan informasi stok produk. |
| FR-14 | Bestseller | Produk dapat ditandai sebagai bestseller. |

### 3.3 Category Management

| ID | Requirement | Description |
|---|---|---|
| FR-15 | Category Listing | Customer dapat melihat kategori produk. |
| FR-16 | Category Creation | Admin dapat menambahkan kategori. |
| FR-17 | Category Update | Admin dapat memperbarui kategori. |
| FR-18 | Category Deletion | Admin dapat menghapus kategori. |

### 3.4 Shopping Cart

| ID | Requirement | Description |
|---|---|---|
| FR-19 | View Cart | Customer dapat melihat isi keranjang. |
| FR-20 | Add to Cart | Customer dapat menambahkan produk ke keranjang. |
| FR-21 | Update Cart | Customer dapat mengubah jumlah produk. |
| FR-22 | Remove Cart Item | Customer dapat menghapus produk dari keranjang. |
| FR-23 | Clear Cart | Customer dapat mengosongkan keranjang. |

### 3.5 Wishlist

| ID | Requirement | Description |
|---|---|---|
| FR-24 | View Wishlist | Customer dapat melihat produk favorit. |
| FR-25 | Add Wishlist | Customer dapat menyimpan produk ke wishlist. |
| FR-26 | Remove Wishlist | Customer dapat menghapus produk dari wishlist. |

### 3.6 Address Management

| ID | Requirement | Description |
|---|---|---|
| FR-27 | View Address | Customer dapat melihat alamat yang tersimpan. |
| FR-28 | Update Address | Customer dapat menambahkan atau memperbarui informasi alamat. |

### 3.7 Order Management

| ID | Requirement | Description |
|---|---|---|
| FR-29 | Checkout | Customer dapat melanjutkan proses checkout. |
| FR-30 | Create Order | Sistem dapat membuat pesanan berdasarkan data checkout. |
| FR-31 | Order History | Customer dapat melihat riwayat pesanan. |
| FR-32 | Order Detail | Customer dapat melihat detail pesanan. |
| FR-33 | Cancel Order | Customer dapat mengajukan pembatalan pesanan sesuai aturan sistem. |
| FR-34 | Admin Order List | Admin dapat melihat seluruh pesanan. |
| FR-35 | Update Order Status | Admin dapat memperbarui status pesanan. |

### 3.8 User Management

| ID | Requirement | Description |
|---|---|---|
| FR-36 | User List | Admin dapat melihat daftar pengguna. |
| FR-37 | Update User Role | Admin dapat mengubah role pengguna. |
| FR-38 | Update User Status | Admin dapat mengaktifkan atau menonaktifkan akun pengguna. |
| FR-39 | Self-Protection | Admin tidak dapat mengubah role atau status akunnya sendiri melalui endpoint pengelolaan pengguna. |

---

## 4. Non-Functional Requirements

| Category | Requirement |
|---|---|
| Performance | Aplikasi harus memberikan respons yang baik untuk aktivitas pengguna. |
| Security | Endpoint privat harus dilindungi autentikasi dan otorisasi. |
| Authentication | Menggunakan Laravel Sanctum dengan Bearer Token. |
| Data Integrity | Data produk, pengguna, keranjang, dan pesanan harus tersimpan secara konsisten. |
| Usability | Antarmuka harus mudah dipahami dan digunakan. |
| Maintainability | Kode frontend dan backend dipisahkan agar lebih mudah dikembangkan. |
| Compatibility | Website dapat digunakan melalui browser modern. |
| Responsiveness | Tampilan menyesuaikan ukuran layar perangkat. |

---

## 5. System Architecture

Gan's Store menggunakan arsitektur frontend dan backend yang terpisah.

### 5.1 Frontend

Teknologi:
- Vue.js
- Vite
- Axios
- JavaScript
- CSS

Tanggung jawab:
- Menampilkan antarmuka pengguna.
- Mengelola interaksi pengguna.
- Menampilkan produk dan kategori.
- Mengelola tampilan keranjang dan wishlist.
- Menampilkan halaman checkout dan pesanan.
- Menyediakan dashboard admin.

### 5.2 Backend

Teknologi:
- Laravel 13
- PHP 8.3+
- Laravel Sanctum
- REST API

Tanggung jawab:
- Menangani request dari frontend.
- Melakukan autentikasi dan otorisasi.
- Mengelola data produk dan kategori.
- Mengelola keranjang dan wishlist.
- Memproses pesanan.
- Mengelola pengguna dan status pesanan.

### 5.3 Database

Database menggunakan MySQL untuk menyimpan data aplikasi.

Entitas utama:
- Users
- User Addresses
- Categories
- Products
- Carts
- Cart Items
- Wishlists
- Orders
- Order Items
- Personal Access Tokens

Tabel pendukung Laravel:
- Migrations
- Sessions
- Cache
- Cache Locks
- Jobs
- Job Batches
- Failed Jobs
- Password Reset Tokens

---

## 6. Main User Flows

### 6.1 Customer Flow

1. Pengguna membuka website.
2. Pengguna melihat produk dan kategori.
3. Pengguna melakukan registrasi atau login.
4. Pengguna memilih produk.
5. Pengguna menambahkan produk ke keranjang atau wishlist.
6. Pengguna mengelola alamat.
7. Pengguna melakukan checkout.
8. Sistem membuat pesanan.
9. Pengguna melihat riwayat dan status pesanan.

### 6.2 Admin Flow

1. Admin membuka halaman login.
2. Admin masuk menggunakan akun admin.
3. Sistem memverifikasi autentikasi dan role.
4. Admin masuk ke dashboard.
5. Admin mengelola produk dan kategori.
6. Admin mengelola data pengguna.
7. Admin melihat pesanan masuk.
8. Admin memperbarui status pesanan.

---

## 7. API Requirements

API menggunakan prefix `/api` dan format respons JSON.

### Public Endpoints

| Method | Endpoint | Description |
|---|---|---|
| POST | `/register` | Registrasi pengguna |
| POST | `/login` | Login pengguna |
| GET | `/products` | Daftar produk aktif |
| GET | `/products/{product}` | Detail produk |
| GET | `/categories` | Daftar kategori |

### Authenticated Endpoints

| Method | Endpoint | Description |
|---|---|---|
| GET | `/user` | Informasi pengguna login |
| POST | `/logout` | Logout |
| GET | `/orders` | Riwayat pesanan |
| POST | `/orders` | Membuat pesanan |
| GET | `/orders/{order}` | Detail pesanan |
| PATCH | `/orders/{order}/cancel` | Membatalkan pesanan |
| GET | `/cart` | Melihat keranjang |
| POST | `/cart/items` | Menambahkan item |
| PATCH | `/cart/items/{cartItem}` | Memperbarui item |
| DELETE | `/cart/items/{cartItem}` | Menghapus item |
| DELETE | `/cart` | Mengosongkan keranjang |
| GET | `/wishlist` | Melihat wishlist |
| POST | `/wishlist` | Menambahkan wishlist |
| DELETE | `/wishlist/{wishlist}` | Menghapus wishlist |
| GET | `/address` | Melihat alamat |
| PUT | `/address` | Memperbarui alamat |

### Admin Endpoints

| Method | Endpoint | Description |
|---|---|---|
| GET | `/admin/users` | Daftar pengguna |
| PATCH | `/admin/users/{id}/role` | Mengubah role pengguna |
| PATCH | `/admin/users/{id}/status` | Mengubah status pengguna |
| GET | `/admin/products` | Daftar produk admin |
| POST | `/admin/products` | Menambahkan produk |
| PUT | `/admin/products/{product}` | Memperbarui produk |
| DELETE | `/admin/products/{product}` | Menghapus produk |
| GET | `/admin/categories` | Daftar kategori admin |
| POST | `/admin/categories` | Menambahkan kategori |
| PUT | `/admin/categories/{category}` | Memperbarui kategori |
| DELETE | `/admin/categories/{category}` | Menghapus kategori |
| GET | `/admin/orders` | Daftar seluruh pesanan |
| PATCH | `/admin/orders/{order}/status` | Memperbarui status pesanan |

---

## 8. Database Requirements

| Table | Purpose |
|---|---|
| users | Menyimpan informasi akun pengguna |
| user_addresses | Menyimpan alamat pengguna |
| categories | Menyimpan kategori produk |
| products | Menyimpan informasi produk |
| carts | Menyimpan keranjang pengguna |
| cart_items | Menyimpan item dalam keranjang |
| wishlists | Menyimpan produk favorit pengguna |
| orders | Menyimpan data transaksi pesanan |
| order_items | Menyimpan detail produk dalam pesanan |
| personal_access_tokens | Menyimpan token autentikasi Sanctum |

---

## 9. Scope & Limitations

### In Scope

- Authentication dan authorization.
- Pengelolaan produk dan kategori.
- Pengelolaan keranjang belanja.
- Wishlist.
- Pengelolaan alamat.
- Checkout dan pembuatan pesanan.
- Riwayat serta detail pesanan.
- Pengelolaan status pesanan.
- Pengelolaan pengguna oleh admin.

### Out of Scope

Fitur berikut tidak termasuk dalam cakupan yang telah dikonfirmasi pada versi dokumentasi ini:
- Payment gateway dan pembayaran otomatis.
- Integrasi jasa pengiriman.
- Pelacakan pengiriman secara real-time.
- Sistem ulasan dan rating produk.
- Notifikasi otomatis melalui email atau WhatsApp.

Fitur di luar cakupan dapat dipertimbangkan untuk pengembangan selanjutnya.

---

## 10. Success Criteria

Gan's Store dinyatakan memenuhi kebutuhan utama apabila:

1. Customer dapat melakukan registrasi dan login.
2. Customer dapat melihat produk dan kategori.
3. Customer dapat mengelola keranjang dan wishlist.
4. Customer dapat mengelola alamat.
5. Customer dapat melakukan checkout dan melihat pesanan.
6. Admin dapat mengelola produk dan kategori.
7. Admin dapat mengelola pengguna.
8. Admin dapat melihat dan memperbarui status pesanan.
9. Frontend dapat berkomunikasi dengan backend melalui REST API.
10. Data aplikasi dapat disimpan dan diakses melalui database MySQL.

---

## 11. Future Development

Pengembangan selanjutnya dapat mencakup:
- Integrasi payment gateway.
- Integrasi layanan pengiriman.
- Notifikasi status pesanan.
- Fitur ulasan dan rating produk.
- Dashboard analitik penjualan.
- Pengembangan pengalaman pengguna pada perangkat mobile.

---

**Document End — Gan's Store PRD v1.0.0**
