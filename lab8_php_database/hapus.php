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