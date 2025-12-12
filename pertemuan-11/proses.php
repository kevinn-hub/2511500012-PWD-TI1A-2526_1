<?php
session_start();

  if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    $_SESSION['flash_eror'] = 'akses tidak valid.';
    redirect_ke("index.contact")
  }

  $nama = bersihkan ($_POST["txtNama"]) ?? "",
  $email = bersihkan ($_POST["txtEmail"]) ?? "",
  $pesan = bersihkan ($_POST["txtPesan"]) ?? "",

  #validasi 
  $errors =[]; #array untuk menampung semua eror

  if ($nama === ''){
    $errors[] ='Nama wajib diisi.';
  }

   if ($email === ''){
    $errors[] ='Email wajib diisi.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors[] ='Format e-mail tidak valid.';
  }

   if ($pesan=== ''){
    $errors[] ='Pesan wajib diisi.';
  }




  if (!empty($errors)){
    $_SESSION['old'] = [
       "nama" => $nama,
       "email" => $email,
       "pesan" => $pesan,
    ];
  }

  $_SESSION['flash_eror'] = implode('<br>', $errors);
  redirect_ke('index.php#contact');


$_SESSION["contact"] = $arrContact;

$arrBiodata = [
  "nim" => $_POST["txtNim"] ?? "",
  "nama" => $_POST["txtNmLengkap"] ?? "",
  "tempat" => $_POST["txtT4Lhr"] ?? "",
  "tanggal" => $_POST["txtTglLhr"] ?? "",
  "hobi" => $_POST["txtHobi"] ?? "",
  "pasangan" => $_POST["txtPasangan"] ?? "",
  "pekerjaan" => $_POST["txtKerja"] ?? "",
  "ortu" => $_POST["txtNmOrtu"] ?? "",
  "kakak" => $_POST["txtNmKakak"] ?? "",
  "adik" => $_POST["txtNmAdik"] ?? ""
];
$_SESSION["biodata"] = $arrBiodata;

header("location: index.php#contact");
