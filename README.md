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

```html
<?php
include("koneksi.php");

// query untuk menampilkan data
$sql = 'SELECT * FROM data_barang';
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Data Barang</title>
</head>
<body>
    <div class="container">
    <h1>Data Barang</h1>
        <p><a href="tambah.php">Tambah Barang</a></p>
        <div class="main">
        <table>
        <tr>
            <th>Gambar</th>
            <th>Nama Barang</th>
            <th>Katagori</th>
            <th>Harga Jual</th>
            <th>Harga Beli</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php if($result): ?>
        <?php while($row = mysqli_fetch_array($result)): ?>
        <tr>
            <td><img src="gambar/<?= $row['gambar'];?>" alt="<?= $row['nama'];?>"></td>
            <td><?= $row['nama'];?></td>
            <td><?= $row['kategori'];?></td>
            <td><?= $row['harga_jual'];?></td> 
            <td><?= $row['harga_beli'];?></td> 
            <td><?= $row['stok'];?></td>

            <td>
            <a href="ubah.php?id=<?= $row['id_barang'];?>">Ubah</a> 
            <a href="hapus.php?id=<?= $row['id_barang'];?>">Hapus</a>
            </td>
        </tr>
        <?php endwhile; else: ?>
        <tr>
            <td colspan="8">Belum ada data</td>     
        </tr>
        <?php endif; ?>
        </table>
        </div>
    </div>
</body>
</html>
```

![](lab8_php_database/ss/1.png)

---

## Menambah Data (Create)
Buat file baru dengan nama `tambah.php`

```php
<?php
error_reporting(E_ALL);
include_once 'koneksi.php';

if (isset($_POST['submit']))
{
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    
    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;

    // Cek apakah ada file yang diupload dan tidak ada error
    if ($file_gambar['error'] == 0)
    {
        // Ganti spasi di nama file dengan underscore untuk keamanan
        $filename = str_replace(' ', '_',$file_gambar['name']);
        
        // Tentukan lokasi penyimpanan fisik (di dalam folder 'gambar/')
        $destination = dirname(__FILE__) .'/gambar/' . $filename;
        
        // Pindahkan file temporer ke lokasi permanen
        if(move_uploaded_file($file_gambar['tmp_name'], $destination))
        {
            // Hanya simpan NAMA FILE ke database (perbaikan konsistensi)
            $gambar = $filename;
        }
    }
    
    // Query INSERT untuk menyimpan data ke database
    $sql = 'INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok, gambar) ';
    $sql .= "VALUE ('{$nama}', '{$kategori}', '{$harga_jual}', '{$harga_beli}', '{$stok}', '{$gambar}')";
    
    $result = mysqli_query($conn, $sql);
    
    // Redirect ke halaman utama setelah berhasil
    header('location: index.php');
}
?>
```
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Tambah Barang</title>
</head>
<body>
    <div class="container">
        <h1>Tambah Barang</h1>
        <div class="main">
            <form method="post" action="tambah.php" enctype="multipart/form-data">
                <div class="input">
                    <label>Nama Barang</label>
                    <input type="text" name="nama" required />
                </div>
                <div class="input">
                    <label>Kategori</label>
                    <select name="kategori" required>
                        <option value="Komputer">Komputer</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Hand Phone">Hand Phone</option>
                    </select>
                </div>
                <div class="input">
                    <label>Harga Jual</label>
                    <input type="text" name="harga_jual" required />
                </div>
                <div class="input">
                    <label>Harga Beli</label>
                    <input type="text" name="harga_beli" required />
                </div>
                <div class="input">
                    <label>Stok</label>
                    <input type="text" name="stok" required />
                </div>
                <div class="input">
                    <label>File Gambar</label>
                    <input type="file" name="file_gambar" />
                </div>
                <div class="submit">
                    <input type="submit" name="submit" value="Simpan" />
                </div>
            </form>
        </div>
    </div>
</body>
</html>
```
![](lab8_php_database/ss/2.png)
![](lab8_php_database/ss/3.png)

---

## Mengubah Data (Update)
Buat file baru dengan nama `ubah.php`
```php
<?php
error_reporting(E_ALL);
include_once 'koneksi.php';
if (isset($_POST['submit']))
{
$id = $_POST['id'];
$nama = $_POST['nama'];
$kategori = $_POST['kategori'];
$harga_jual = $_POST['harga_jual'];
$harga_beli = $_POST['harga_beli'];
$stok = $_POST['stok'];
$file_gambar = $_FILES['file_gambar'];
$gambar = null;
if ($file_gambar['error'] == 0)
{
$filename = str_replace(' ', '_', $file_gambar['name']);
$destination = dirname(__FILE__) . '/gambar/' . $filename;
if (move_uploaded_file($file_gambar['tmp_name'], $destination))
{
$gambar = $filename; // Simpan hanya nama file (tanpa 'gambar/')
}
}
$sql = 'UPDATE data_barang SET ';
$sql .= "nama = '{$nama}', kategori = '{$kategori}', ";
$sql .= "harga_jual = '{$harga_jual}', harga_beli = '{$harga_beli}', stok = '{$stok}' ";

// PERBAIKAN KECIL: Hapus 'gambar/' dari variabel $gambar di update query, 
// karena di tambah.php anda menyimpan 'gambar/' . $filename;
if (!empty($gambar))
    $sql .= ", gambar = '{$gambar}' "; 

$sql .= "WHERE id_barang = '{$id}'";
$result = mysqli_query($conn, $sql);
header('location: index.php');
}
$id = $_GET['id'];
$sql = "SELECT * FROM data_barang WHERE id_barang = '{$id}'";
$result = mysqli_query($conn, $sql);
if (!$result) die('Error: Data tidak tersedia');
$data = mysqli_fetch_array($result);
function is_select($var, $val) {
if ($var == $val) return 'selected="selected"';
return false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link href="style.css" rel="stylesheet" type="text/css" />
<title>Ubah Barang</title>
</head>
<body>
<div class="container">
<h1>Ubah Barang</h1>
<div class="main">
<form method="post" action="ubah.php"
enctype="multipart/form-data">
<div class="input">
<label>Nama Barang</label>
<input type="text" name="nama" value="<?php echo
$data['nama'];?>" />
</div>
<div class="input">
<label>Kategori</label>
<select name="kategori">
    <option <?php echo is_select
('Komputer', $data['kategori']);?> value="Komputer">Komputer</option>
    <option <?php echo is_select
('Elektronik', $data['kategori']);?> value="Elektronik">Elektronik</option>
    <option <?php echo is_select
('Hand Phone', $data['kategori']);?> value="Hand Phone">Hand Phone</option>
</select>
</div>
<div class="input">
<label>Harga Jual</label>
<input type="text" name="harga_jual" value="<?php echo
$data['harga_jual'];?>" />
</div>
<div class="input">
<label>Harga Beli</label>
<input type="text" name="harga_beli" value="<?php echo
$data['harga_beli'];?>" />
</div>
<div class="input">
<label>Stok</label>
<input type="text" name="stok" value="<?php echo
$data['stok'];?>" />
</div>
<div class="input">
<label>File Gambar</label>
<?php if ($data['gambar']): ?>
    <img src="gambar/<?php echo $data['gambar'];?>" alt="<?php echo $data['nama'];?>" style="height: 50px; margin-right: 10px;">
<?php endif; ?>
<input type="file" name="file_gambar" />
</div>
<div class="submit">
<input type="hidden" name="id" value="<?php echo
$data['id_barang'];?>" />
<input type="submit" name="submit" value="Simpan" />
</div>
</form>
</div>
</div>
</body>
</html>
```
![](lab8_php_database/ss/4.png)
![](lab8_php_database/ss/5.png)

---

## Menghapus Data (Delete)
Buat file baru dengan nama `hapus.php`
```php
<?php
include_once 'koneksi.php';

$id = $_GET['id'];

// 1. Ambil nama file gambar sebelum data dihapus
$sql_select = "SELECT gambar FROM data_barang WHERE id_barang = '{$id}'";
$result_select = mysqli_query($conn, $sql_select);
$data = mysqli_fetch_assoc($result_select);
$gambar_nama = $data['gambar'];

// 2. Jika ada nama gambar di database, hapus file fisiknya
if (!empty($gambar_nama)) {
    // Tentukan path lengkap ke file gambar
    $file_path = dirname(__FILE__) . '/gambar/' . $gambar_nama;
    
    // Cek apakah file benar-benar ada di server
    if (file_exists($file_path)) {
        // Hapus file
        unlink($file_path);
    }
}

// 3. Hapus data baris dari database
$sql_delete = "DELETE FROM data_barang WHERE id_barang = '{$id}'";
$result_delete = mysqli_query($conn, $sql_delete);

// 4. Redirect kembali ke halaman utama
header('location: index.php');
?>
```
![](lab8_php_database/ss/6.png)
