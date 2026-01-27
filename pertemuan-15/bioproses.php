<?php
session_start();
require __DIR__ . './koneksi.php';
require_once __DIR__ . '/fungsi.php';

#cek method form, hanya izinkan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['flash_error_biodata'] = 'Akses tidak valid.';
  redirect_ke('index.php#biodata');
}

#ambil dan bersihkan nilai dari form
$nim            = bersihkan($_POST['txtNim'] ?? '');
$namalengkap    = bersihkan($_POST['txtNamaLengkap'] ?? '');
$tempatlahir    = bersihkan($_POST['txtTempatlahir'] ?? '');
$tanggallahir   = bersihkan($_POST['txtTanggallahir'] ?? '');
$hobi           = bersihkan($_POST['txtHobi'] ?? '');
$pasangan       = bersihkan($_POST['txtPasangan'] ?? '');
$pekerjaan      = bersihkan($_POST['txtpekerjaan'] ?? '');
$namaorangtua   = bersihkan($_POST['txtnamaorangtua'] ?? '');
$namakakak      = bersihkan($_POST['txtnamakakak'] ?? '');
$namaadik       = bersihkan($_POST['txtnamaadik'] ?? '');
$captcha        = bersihkan($_POST['txtCaptcha'] ?? '');

#Validasi sederhana
$errors = []; // array untuk menampung semua error

if ($nim === '') {
    $errors[] = 'NIM wajib diisi.';
}

if ($namalengkap === '') {
    $errors[] = 'Nama lengkap wajib diisi.';
} elseif (mb_strlen($namalengkap) < 3) {
    $errors[] = 'Nama lengkap minimal 3 karakter.';
}

if ($tempatlahir === '') {
    $errors[] = 'Tempat lahir wajib diisi.';
}

if ($tanggallahir === '') {
    $errors[] = 'Tanggal lahir wajib diisi.';
}

if ($hobi === '') {
    $errors[] = 'Hobi wajib diisi.';
}

if ($pasangan === '') {
    $errors[] = 'Pasangan wajib diisi.';
}

if ($pekerjaan === '') {
    $errors[] = 'Pekerjaan wajib diisi.';
}

if ($namaorangtua === '') {
    $errors[] = 'Nama orang tua wajib diisi.';
}

if ($namakakak === '') {
    $errors[] = 'Nama kakak wajib diisi.';
}

if ($namaadik === '') {
    $errors[] = 'Nama adik wajib diisi.';
}


/*
kondisi di bawah ini hanya dikerjakan jika ada error, 
simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
*/
if (!empty($errors)) {
  $_SESSION['oldata'] = [
    'nim'            => $nim,
    'namalengkap'    => $namalengkap,
    'tempatlahir'    => $tempatlahir,
    'tanggallahir'   => $tanggallahir,
    'hobi'           => $hobi,
    'pasangan'       => $pasangan,
    'pekerjaan'      => $pekerjaan,
    'namaorangtua'   => $namaorangtua,
    'namakakak'      => $namakakak,
    'namaadik'       => $namaadik
  ];

  $_SESSION['flash_error_biodata'] = implode('<br>', $errors);
  redirect_ke('index.php#biodata');
}

#menyiapkan query INSERT dengan prepared statement
$sql = "INSERT INTO tbl_biodata (enim, enamalengkap, etempatlahir, etanggallahir, ehobi, epasangan, epekerjaan, enamaorangtua, enamakakak, enamaadik) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
  #jika gagal prepare, kirim pesan error ke pengguna (tanpa detail sensitif)
  $_SESSION['flash_error_biodata'] = 'Terjadi kesalahan sistem (prepare gagal).';
  redirect_ke('index.php#biodata');
}
#bind parameter dan eksekusi (s = string)
mysqli_stmt_bind_param($stmt, "ssssssssss", 
    $nim,
    $namalengkap,
    $tempatlahir,
    $tanggallahir,
    $hobi,
    $pasangan,
    $pekerjaan,
    $namaorangtua,
    $namakakak,
    $namaadik);

if (mysqli_stmt_execute($stmt)) { #jika berhasil, kosongkan old value, beri pesan sukses
  unset($_SESSION['oldata']);
  $_SESSION['flash_sukses_biodata'] = 'Terima kasih, data Anda sudah tersimpan.';
  redirect_ke('index.php#biodata'); #pola PRG: kembali ke form / halaman home
} else { #jika gagal, simpan kembali old value dan tampilkan error umum
  $_SESSION['old'] = [
    'nim'            => $nim,
    'namalengkap'    => $namalengkap,
    'tempatlahir'    => $tempatlahir,
    'tanggallahir'   => $tanggallahir,
    'hobi'           => $hobi,
    'pasangan'       => $pasangan,
    'pekerjaan'      => $pekerjaan,
    'namaorangtua'   => $namaorangtua,
    'namakakak'      => $namakakak,
    'namaadik'       => $namaadik
  ];
  $_SESSION['flash_error_biodata'] = 'Data gagal disimpan. Silakan coba lagi.';
  redirect_ke('index.php#biodata');
}
#tutup statement
mysqli_stmt_close($stmt);

$arrBiodata = [
    "nim"         => $_POST["txtNim"] ?? "",
    "namalengkap" => $_POST["txtNamaLengkap"] ?? "",
    "tempatlahir" => $_POST["txtTempatlahir"] ?? "",
    "tanggallahir"=> $_POST["txtTanggallahir"] ?? "",
    "hobi"        => $_POST["txtHobi"] ?? "",
    "pasangan"    => $_POST["txtPasangan"] ?? "",
    "pekerjaan"   => $_POST["txtpekerjaan"] ?? "",
    "namaorangtua"=> $_POST["txtnamaorangtua"] ?? "",
    "namakakak"   => $_POST["txtnamakakak"] ?? "",
    "namaadik"    => $_POST["txtnamaadik"] ?? ""
];
$_SESSION["biodata"] = $arrBiodata;

header("location: index.php#about");
