<?php
require 'koneksi.php';

$fieldContact = [
    "nim"          => ["label" => "NIM:", "suffix" => ""],
    "namalengkap"  => ["label" => "Nama Lengkap:", "suffix" => " &#128526;"],
    "tempatlahir"  => ["label" => "Tempat Lahir:", "suffix" => ""],
    "tanggallahir" => ["label" => "Tanggal Lahir:", "suffix" => ""],
    "hobi"         => ["label" => "Hobi:", "suffix" => " &#127926;"],
    "pasangan"     => ["label" => "Pasangan:", "suffix" => " &hearts;"],
    "pekerjaan"    => ["label" => "Pekerjaan:", "suffix" => " &copy; 2025"],
    "namaorangtua" => ["label" => "Nama Orang Tua:", "suffix" => ""],
    "namakakak"    => ["label" => "Nama Kakak:", "suffix" => ""],
    "namaadik"     => ["label" => "Nama Adik:", "suffix" => ""],
    ];

$sql = "SELECT * FROM tbl_biodata ORDER BY eid DESC";
$q = mysqli_query($conn, $sql);
if (!$q) {
  echo "<p>Gagal membaca data tamu: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
} elseif (mysqli_num_rows($q) === 0) {
  echo "<p>Belum ada data tamu yang tersimpan.</p>";
} else {
  while ($row = mysqli_fetch_assoc($q)) {
    $arrContact = [
    "nim"          => $row["enim"]   ?? "",
    "namalengkap"  => $row["enamalengkap"]   ?? "",
    "tempatlahir"  => $row["etempatlahir"]  ?? "",
    "tanggallahir" => $row["etanggallahir"] ?? "",
    "hobi"         => $row["ehobi"]         ?? "",
    "pasangan"     => $row["epasangan"]     ?? "",
    "pekerjaan"    => $row["epekerjaan"]    ?? "",
    "namaorangtua" => $row["enamaorangtua"] ?? "",
    "namakakak"    => $row["enamakakak"]    ?? "",
    "namaadik"     => $row["enamaadik"]     ?? "",
    "createdat"    => $row["ecreatedat"]    ?? ""
    ];
    echo tampilkanBiodata($fieldContact, $arrContact);
  }
}
?>
