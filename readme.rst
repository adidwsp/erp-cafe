===============================
SISTEM INFORMASI ERP (ADMIN ERP)
===============================

Identitas Proyek
================
Nama Aplikasi
  Admin ERP

Jenis Aplikasi
  Web-based Enterprise Resource Planning (ERP)

Framework
  CodeIgniter 3 (Modular / HMVC)

Template Antarmuka
  AdminLTE

Bahasa Pemrograman
  PHP

Database
  MySQL

Tujuan Pengembangan
  Tugas Kuliah Program Studi Sistem Informasi


Akun Demo
=========
Gunakan akun berikut untuk melakukan pengujian sistem:

::

  Email    : admin@gmail.com
  Password : admin123

  Database : erp_cafe.sql

Catatan:
  Akun ini disediakan khusus untuk keperluan demo dan evaluasi tugas kuliah.


Deskripsi Umum Sistem
=====================
Admin ERP adalah aplikasi sistem informasi terintegrasi yang dirancang untuk
mendukung proses bisnis perusahaan, meliputi pengelolaan sumber daya manusia,
penjualan, pembelian, dan persediaan barang.

Sistem ini dikembangkan menggunakan arsitektur Modular HMVC sehingga setiap
modul dapat berdiri sendiri, mudah dipelihara, dan mudah dikembangkan.


Struktur Menu dan Modul
======================

1. Dashboard
------------
Dashboard merupakan halaman utama setelah pengguna berhasil login.

Fungsi:
- Menampilkan halaman utama sistem
- Akses cepat ke modul utama
- Placeholder informasi penjualan dan ringkasan sistem


2. Manajemen Pengguna
---------------------
Modul ini digunakan untuk mengelola akun pengguna sistem.

Fitur:
- Menampilkan daftar pengguna
- Menambah data pengguna
- Mengedit data pengguna
- Menghapus data pengguna
- Pengelolaan role pengguna


3. Human Resources (HR)
----------------------

3.1 Data Karyawan
~~~~~~~~~~~~~~~~~
Digunakan sebagai master data karyawan.

Fitur:
- Menambah data karyawan
- Mengedit data karyawan
- Menghapus data karyawan
- Pencarian data karyawan

Data yang dikelola:
- NIK
- Nama karyawan
- Jabatan
- Tanggal bergabung
- Status karyawan
- Gaji pokok


3.2 Absensi
~~~~~~~~~~~
Modul absensi digunakan untuk mencatat kehadiran karyawan.

Fitur:
- Menambah data absensi
- Mengedit data absensi
- Menghapus data absensi
- Relasi langsung dengan data karyawan
- Default tanggal dan jam otomatis (waktu saat ini)


3.3 Penggajian
~~~~~~~~~~~~~~
Modul ini digunakan untuk pengelolaan gaji karyawan.

Fitur:
- Pengolahan data penggajian
- Rekap gaji karyawan
- Integrasi data absensi

Catatan:
  Modul penggajian masih dalam tahap pengembangan.


4. Sales
--------
Modul sales digunakan untuk pengelolaan penjualan perusahaan.

Fitur:
- Data penjualan
- Data customer
- Pengelolaan piutang

Catatan:
  Modul sales masih dalam tahap pengembangan.


5. Purchasing
-------------
Modul purchasing digunakan untuk pengelolaan pembelian.

Fitur:
- Data pembelian
- Data supplier
- Rekap pembelian

Catatan:
  Modul purchasing masih dalam tahap pengembangan.


6. Inventory
------------
Modul inventory digunakan untuk pengelolaan persediaan barang.

Fitur:
- Data barang
- Mutasi barang
- Monitoring stok

Catatan:
  Modul inventory masih dalam tahap pengembangan.


Arsitektur Sistem
=================
Aplikasi ini menggunakan arsitektur MVC (Model-View-Controller) dengan pendekatan
Modular HMVC, di mana:

- Setiap modul memiliki controller, model, dan view masing-masing
- Pengembangan dan pemeliharaan sistem menjadi lebih terstruktur
- Sistem mudah dikembangkan untuk skala ERP yang lebih besar


Manajemen Database
==================
Struktur database dirancang secara relasional, dengan tabel utama sebagai berikut:

- employees   : Master data karyawan
- attendances : Data transaksi absensi

Relasi antar tabel menggunakan foreign key untuk menjaga integritas data.


Keamanan Sistem
===============
Beberapa aspek keamanan yang diterapkan pada sistem ini antara lain:

- Autentikasi login berbasis session
- Logout menggunakan metode POST
- Validasi input menggunakan form_validation
- Proteksi akses halaman menggunakan Admin_Controller


Tujuan Akademik
===============
Aplikasi ini dikembangkan untuk memenuhi tugas perkuliahan dengan tujuan:

- Menerapkan konsep Enterprise Resource Planning (ERP)
- Mengimplementasikan arsitektur MVC dan HMVC
- Mengintegrasikan beberapa modul bisnis dalam satu sistem
- Melatih analisis dan perancangan sistem informasi berbasis web


Catatan Pengembangan
===================
- Sistem masih dapat dikembangkan lebih lanjut
- Beberapa modul bersifat placeholder
- Fitur dapat disesuaikan dengan kebutuhan akademik


Penutup
=======
Dokumentasi ini disusun sebagai penjelasan sistem Admin ERP yang dikembangkan
untuk tugas kuliah. Aplikasi ini diharapkan dapat menunjukkan pemahaman konsep
ERP, pengembangan sistem informasi, dan penerapan teknologi web berbasis PHP.
