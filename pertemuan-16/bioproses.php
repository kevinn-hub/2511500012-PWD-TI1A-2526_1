<?php
session_start();
require __DIR__ . './koneksi.php';
require_once __DIR__ . '/fungsi.php';

#cek method form, hanya izinkan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['flash_error'] = 'Akses tidak valid.';
  redirect_ke('index.php#biodata');
}

#ambil dan bersihkan nilai dari form
  $kodeDosen = bersihkan($_POST['txtkodedosen'] ?? '');
  $namaDosen     = bersihkan($_POST['txtnamadosen'] ?? '');
  $alamatRumah   = bersihkan($_POST['txtalamatrumah'] ?? '');
  $tanggalJadi   = bersihkan($_POST['txttanggaldosen'] ?? '');
  $jja           = bersihkan($_POST['txtjja'] ?? '');
  $homebaseProdi = bersihkan($_POST['txtprodi'] ?? '');
  $nomorHp       = bersihkan($_POST['txtnomorhp'] ?? '');
  $namaPasangan  = bersihkan($_POST['txtnamapasangan'] ?? '');
  $namaAnak      = bersihkan($_POST['txtnamaanak'] ?? '');
  $bidangIlmu    = bersihkan($_POST['txtbidangilmu'] ?? '');
  $captcha       = bersihkan($_POST['txtCaptcha'] ?? '');

#Validasi sederhana
$errors = []; // array untuk menampung semua error

// Validasi masing-masing field
if ($kodeDosen === '') {
    $errors[] = 'Nama Dosen wajib diisi.';
}
if ($namaDosen === '') {
    $errors[] = 'Nama Dosen wajib diisi.';
}

if ($alamatRumah === '') {
    $errors[] = 'Alamat Rumah wajib diisi.';
}

if ($tanggalJadi === '') {
    $errors[] = 'Tanggal Jadi Dosen wajib diisi.';
}

if ($jja === '') {
    $errors[] = 'JJA Dosen wajib diisi.';
}

if ($homebaseProdi === '') {
    $errors[] = 'Homebase Prodi wajib diisi.';
}

if ($nomorHp === '') {
    $errors[] = 'Nomor HP wajib diisi.';
}

if ($namaPasangan === '') {
    $errors[] = 'Nama Pasangan wajib diisi.';
}

if ($namaAnak === '') {
    $errors[] = 'Nama Anak wajib diisi.';
}

if ($bidangIlmu === '') {
    $errors[] = 'Bidang Ilmu Dosen wajib diisi.';
}

if ($captcha === '') {
    $errors[] = 'Captcha wajib diisi.';
} elseif ($captcha !== "5") {
    $errors[] = 'Jawaban captcha salah.';
}



/*
kondisi di bawah ini hanya dikerjakan jika ada error, 
simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
*/
if (!empty($errors)) {
 $_SESSION['old'] = [
  'txtkodedosen'   => $kodeDosen,
  'txtnamadosen'   => $namaDosen,
  'txtalamatrumah' => $alamatRumah,
  'txttanggaldosen'=> $tanggalJadi,
  'txtjja'         => $jja,
  'txtprodi'       => $homebaseProdi,
  'txtnomorhp'     => $nomorHp,
  'txtnamapasangan' => $namaPasangan,
  'txtnamaanak'    => $namaAnak,
  'txtbidangilmu'  => $bidangIlmu,
  'txtCaptcha'     => $captcha
];

  $_SESSION['flash_error'] = implode('<br>', $errors);
  redirect_ke('index.php#biodata');
}

#menyiapkan query INSERT dengan prepared statement
$sql = "INSERT INTO tbl_biodata (
    ekodedosen, enamadosen, ealamatrumah, etanggaljadidosen, ejjadosen,
    ehomebaseprodi, enomorhp, enamapasangan, enamaanak, ebidangilmudosen
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
  #jika gagal prepare, kirim pesan error ke pengguna (tanpa detail sensitif)
  $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
  redirect_ke('index.php#biodata');
}
#bind parameter dan eksekusi (s = string)
mysqli_stmt_bind_param($stmt, 
        "ssssssssss", 
        $kodeDosen, $namaDosen, $alamatRumah, $tanggalJadi, $jja, 
        $homebaseProdi, $nomorHp, $namaPasangan, $namaAnak, $bidangIlmu);


if (mysqli_stmt_execute($stmt)) { #jika berhasil, kosongkan old value, beri pesan sukses
  unset($_SESSION['old']);
  $_SESSION['flash_sukses'] = 'Terima kasih, data Anda sudah tersimpan.';
  redirect_ke('index.php#biodata'); #pola PRG: kembali ke form / halaman home
} else { #jika gagal, simpan kembali old value dan tampilkan error umum
$_SESSION['old'] = [
  'txtkodedosen'   => $kodeDosen,
  'txtnamadosen'   => $namaDosen,
  'txtalamatrumah' => $alamatRumah,
  'txttanggaldosen'=> $tanggalJadi,
  'txtjja'         => $jja,
  'txtprodi'       => $homebaseProdi,
  'txtnomorhp'     => $nomorHp,
  'txtnamapasangan' => $namaPasangan,
  'txtnamaanak'    => $namaAnak,
  'txtbidangilmu'  => $bidangIlmu,
  'txtCaptcha'     => $captcha
];

  $_SESSION['flash_error'] = 'Data gagal disimpan. Silakan coba lagi.';
  redirect_ke('index.php#biodata');
}
#tutup statement
mysqli_stmt_close($stmt);

$arrBiodata = [
    "kodedos" => $_POST["txtkodedosen"] ?? "",
    "nama"    => $_POST["txtnamadosen"] ?? "",
    "alamat"  => $_POST["txtalamatrumah"] ?? "",
    "tanggal" => $_POST["txttanggaldosen"] ?? "",
    "jja"     => $_POST["txtjja"] ?? "",
    "prodi"   => $_POST["txtprodi"] ?? "",
    "nohp"    => $_POST["txtnomorhp"] ?? "",
    "pasangan"=> $_POST["txnamapasangan"] ?? "",
    "anak"    => $_POST["txtnamaanak"] ?? "",
    "ilmu"    => $_POST["txtbidangilmu"] ?? ""
];

$_SESSION["biodata"] = $arrBiodata;

header("location: index.php#about");
?>