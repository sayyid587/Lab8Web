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