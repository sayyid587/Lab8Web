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