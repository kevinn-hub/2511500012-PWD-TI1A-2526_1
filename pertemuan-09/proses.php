<?php
session_start();
$arrBiodata = [
    "nim"       => $_POST["txtNim"]        ?? "",
    "nama"      => $_POST["txtNmLengkap"]  ?? "",
    "tempat"    => $_POST["txtT4Lhr"]      ?? "",
    "tanggal"   => $_POST["txtTglLhr"]     ?? "",
    "hobi"      => $_POST["txtHobi"]       ?? "",
    "pasangan"  => $_POST["txtPasangan"]   ?? "",
    "pekerjaan" => $_POST["txtKerja"]      ?? "",
    "ortu"     => $_POST["txtNmOrtu"]     ?? "", 
    "kakak"     => $_POST["txtNmKakak"]    ?? "",
    "adik"      => $_POST["txtNmAdik"]     ?? ""
];

$arrContact = [
    "nama"       => $_POST["txtNama"]   ?? "",
    "email"      => $_POST["txtEmail"]  ?? "",
    "pesan" => $_POST["txtPesan"]  ?? ""
];

$_SESSION["biodata"] = $arrBiodata;
$_SESSION["contact"] = $arrContact;
header("location: index.php#about");
?>