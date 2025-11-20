# Lab8Web

Nama : Sayyid Sulthan Abyan

NIM : 312410496

Kelas : TI.24.A.5

# Langkah-langkah Praktikum

## membbuat Database 

```sql
CREATE DATABASE latihan1;
```
**membuat tabel pada Database yang telah di buat**

```sql
CREATE TABLE data_barang (
id_barang int(10) auto_increment Primary Key,
kategori varchar(30),
nama varchar(30),
gambar varchar(100),
harga_beli decimal(10,0),
harga_jual decimal(10,0),
stok int(4)
);
```
**menambahkan data pada tabel**

```sql
INSERT INTO data_barang (kategori, nama, gambar, harga_beli, harga_jual, stok)
VALUES ('Elektronik', 'HP Samsung Android', 'hp_samsung.jpg', 2000000, 2400000, 5),
('Elektronik', 'HP Xiaomi Android', 'hp_xiaomi.jpg', 1000000, 1400000, 5),
('Elektronik', 'HP OPPO Android', 'hp_oppo.jpg', 1800000, 2300000, 5);
```
![](lab8_php_database/ss/0.png)

---

## Membuat Program CRUD
Buat folder `lab8_php_database pada` root directory web server (c:\xampp\htdocs)

![](lab8_php_database/ss/01.png)

Kemudian untuk mengakses direktory tersebut pada web server dengan mengakses URL:
http://localhost/lab8_php_database/

![](lab8_php_database/ss/02.png)

---

## Membuat file koneksi database
Buat file baru dengan nama `koneksi.php`
```php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "latihan1";
$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn == false)
{
echo "Koneksi ke server gagal.";
die();
} else echo "Koneksi berhasil";
?>
```
Buka melalui browser untuk menguji koneksi database (untuk menyampilkan pesan
koneksi berhasil, uncomment pada perintah echo “koneksi berhasil”;

![](lab8_php_database/ss/03.png)


---

## Membuat file index untuk menampilkan data (Read)
Buat file baru dengan nama `index.php`

<img width="1650" height="2382" alt="image" src="https://github.com/user-attachments/assets/acffd642-a197-485d-9c04-2da001d65583" />


![](lab8_php_database/ss/1.png)

---

## Menambah Data (Create)
Buat file baru dengan nama `tambah.php`
<img width="1926" height="3712" alt="image" src="https://github.com/user-attachments/assets/db815d94-886e-46f8-9698-61527ca2db97" />


![](lab8_php_database/ss/2.png)
![](lab8_php_database/ss/3.png)

---

## Mengubah Data (Update)
Buat file baru dengan nama `ubah.php`

<img width="2294" height="4320" alt="image" src="https://github.com/user-attachments/assets/5a54fe8a-f3d4-4ded-8647-0ab813d41645" />

![](lab8_php_database/ss/4.png)
![](lab8_php_database/ss/5.png)

---

## Menghapus Data (Delete)
Buat file baru dengan nama `hapus.php`
<img width="1434" height="1432" alt="image" src="https://github.com/user-attachments/assets/10cbdd8c-9845-411b-bb10-6d475af6e985" />


![](lab8_php_database/ss/6.png)
