<?php
session_start();
require_once 'koneksi.php';
require_once 'fungsi.php'; 
$nim          = bersihkan($_POST['txtNim'] ?? '');
$namaLengkap  = bersihkan($_POST['txtNmLengkap'] ?? '');
$tempatLahir  = bersihkan($_POST['txtT4Lhr'] ?? '');
$tanggalLahir = bersihkan($_POST['txtTglLhr'] ?? '');
$hobi         = bersihkan($_POST['txtHobi'] ?? '');
$pasangan     = bersihkan($_POST['txtPasangan'] ?? '');
$pekerjaan    = bersihkan($_POST['txtKerja'] ?? '');
$namaOrtu     = bersihkan($_POST['txtNmOrtu'] ?? '');
$namaKakak    = bersihkan($_POST['txtNmKakak'] ?? '');
$namaAdik     = bersihkan($_POST['txtNmAdik'] ?? '');

$errors = [];

if ($nim === '') { $errors[] = 'NIM wajib diisi.'; }
elseif (mb_strlen($nim) < 3) { $errors[] = 'NIM minimal 3 karakter.'; }

if ($namaLengkap === '') { $errors[] = 'Nama Lengkap wajib diisi.'; }
elseif (mb_strlen($namaLengkap) < 3) { $errors[] = 'Nama Lengkap minimal 3 karakter.'; }

if ($tempatLahir === '') { $errors[] = 'Tempat Lahir wajib diisi.'; }

if ($tanggalLahir === '') { $errors[] = 'Tanggal Lahir wajib diisi.'; }
elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggalLahir)) { $errors[] = 'Format Tanggal Lahir harus YYYY-MM-DD.'; }

if ($hobi === '') { $errors[] = 'Hobi wajib diisi.'; }
elseif (mb_strlen($hobi) < 3) { $errors[] = 'Hobi minimal 3 karakter.'; }

if ($pasangan === '') { $errors[] = 'Pasangan wajib diisi.'; }

if ($pekerjaan === '') { $errors[] = 'Pekerjaan wajib diisi.'; }

if ($namaOrtu === '') { $errors[] = 'Nama Orang Tua wajib diisi.'; }

if ($namaKakak === '') { $errors[] = 'Nama Kakak wajib diisi.'; }

if ($namaAdik === '') { $errors[] = 'Nama Adik wajib diisi.'; }

if (!empty($errors)) {
    $_SESSION['old'] = [
        'txtNim' => $nim,
        'txtNmLengkap' => $namaLengkap,
        'txtT4Lhr' => $tempatLahir,
        'txtTglLhr' => $tanggalLahir,
        'txtHobi' => $hobi,
        'txtPasangan' => $pasangan,
        'txtKerja' => $pekerjaan,
        'txtNmOrtu' => $namaOrtu,
        'txtNmKakak' => $namaKakak,
        'txtNmAdik' => $namaAdik,
    ];
    $_SESSION['flash_error'] = implode('<br>', $errors);
        redirect_ke('index.php#biodata');
}

$sql = "INSERT INTO tbl_biodata 
        (enim, enamlengkap, etempatlahir, etanggallahir, ehobi, epasangan, epekerjaan, enamaortu, enamakakak, enamadik) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem.';
       redirect_ke('index.php#biodata');
}

mysqli_stmt_bind_param($stmt, "ssssssssss", $nim, $namaLengkap, $tempatLahir, $tanggalLahir, $hobi, $pasangan, $pekerjaan, $namaOrtu, $namaKakak, $namaAdik);

if (mysqli_stmt_execute($stmt)) {
    unset($_SESSION['old']);
    $_SESSION['flash_sukses'] = 'Data biodata berhasil disimpan.';
       redirect_ke('index.php');
} else {
    $_SESSION['old'] = [
        'txtNim' => $nim,
        'txtNmLengkap' => $namaLengkap,
        'txtT4Lhr' => $tempatLahir,
        'txtTglLhr' => $tanggalLahir,
        'txtHobi' => $hobi,
        'txtPasangan' => $pasangan,
        'txtKerja' => $pekerjaan,
        'txtNmOrtu' => $namaOrtu,
        'txtNmKakak' => $namaKakak,
        'txtNmAdik' => $namaAdik,
    ];
    $_SESSION['flash_error'] = 'Data gagal disimpan.';
    redirect_ke('editbio.php?eid=' . $eid);
}

mysqli_stmt_close($stmt);


