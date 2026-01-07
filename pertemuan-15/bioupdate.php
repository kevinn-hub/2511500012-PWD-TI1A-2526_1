<?php
session_start();
require 'koneksi.php';
require 'fungsi.php';

// Ambil POST
$eid         = (int)($_POST['eid'] ?? 0);
$nim         = trim($_POST['txtNim'] ?? '');
$namaLengkap = trim($_POST['txtNmLengkap'] ?? '');
$tempatLahir = trim($_POST['txtT4Lhr'] ?? '');
$tanggalLahir= trim($_POST['txtTglLhr'] ?? '');
$hobi        = trim($_POST['txtHobi'] ?? '');
$pasangan    = trim($_POST['txtPasangan'] ?? '');
$pekerjaan   = trim($_POST['txtKerja'] ?? '');
$namaOrtu    = trim($_POST['txtNmOrtu'] ?? '');
$namaKakak   = trim($_POST['txtNmKakak'] ?? '');
$namaAdik    = trim($_POST['txtNmAdik'] ?? '');

// Validasi sederhana
$errors = [];
if ($eid <= 0) $errors[] = "ID tidak valid";
if (strlen($nim) < 3) $errors[] = "NIM minimal 3 karakter";
if (strlen($namaLengkap) < 3) $errors[] = "Nama minimal 3 karakter";
// Tambahkan validasi lain sesuai kebutuhan

if (!empty($errors)) {
    $_SESSION['flash_error'] = implode('<br>', $errors);
    $_SESSION['old'] = $_POST;
    redirect_ke("editbio.php?eid={$eid}");
}

// Update data
$sql = "UPDATE tbl_biodata SET enim=?, enamlengkap=?, etempatlahir=?, etanggallahir=?, ehobi=?, epasangan=?, epekerjaan=?, enamaortu=?, enamakakak=?, enamadik=? WHERE eid=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssssssssssi", $nim, $namaLengkap, $tempatLahir, $tanggalLahir, $hobi, $pasangan, $pekerjaan, $namaOrtu, $namaKakak, $namaAdik, $eid);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['flash_sukses'] = "Data berhasil diperbarui.";
    redirect_ke("bioread.php"); // Kembali ke read
} else {
    $_SESSION['flash_error'] = "Gagal memperbarui data.";
    $_SESSION['old'] = $_POST;
    redirect_ke("editbio.php?eid={$eid}");
}


