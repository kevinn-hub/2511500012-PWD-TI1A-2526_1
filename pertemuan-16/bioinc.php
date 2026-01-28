<?php
require 'koneksi.php';
   $fieldConfig = [
      "kodedos" => ["label" => "Kode Dosen:", "suffix" => ""],
      "nama" => ["label" => "Nama Dosen:", "suffix" => " &#128526;"],
      "alamat" => ["label" => "Alamat Rumah:", "suffix" => ""],
      "tanggal" => ["label" => "Tanggal Jadi Dosen:", "suffix" => ""],
      "jja" => ["label" => "JJA Dosen:", "suffix" => " &#127926;"],
      "prodi" => ["label" => "Homebase Prodi:", "suffix" => " &hearts;"],
      "nohp" => ["label" => "Nomor HP:", "suffix" => " &copy; 2025"],
      "pasangan" => ["label" => "Nama Pasangan:", "suffix" => ""],
      "anak" => ["label" => "Nama Anak:", "suffix" => ""],
      "ilmu" => ["label" => "Bidang Ilmu Dosen:", "suffix" => ""],
    ];


$sql = "SELECT * FROM tbl_biodata ORDER BY eid DESC";
$q = mysqli_query($conn, $sql);
if (!$q) {
  echo "<p>Gagal membaca data tamu: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
} elseif (mysqli_num_rows($q) === 0) {
  echo "<p>Belum ada data tamu yang tersimpan.</p>";
} else {
  while ($row = mysqli_fetch_assoc($q)) {
$arrbiodata = [
    "kodedos" => $row["ekodedosen"] ?? "",
    "nama"    => $row["enamadosen"] ?? "",
    "alamat"  => $row["ealamatrumah"] ?? "",
    "tanggal" => $row["etanggaljadidosen"] ?? "",
    "jja"     => $row["ejjadosen"] ?? "",
    "prodi"   => $row["ehomebaseprodi"] ?? "",
    "nohp"    => $row["enomorhp"] ?? "",
    "pasangan"=> $row["enamapasangan"] ?? "",
    "anak"    => $row["enamaanak"] ?? "",
    "ilmu"    => $row["ebidangilmudosen"] ?? ""
];



    echo tampilkanBiodata($fieldConfig, $arrbiodata);
  }
}
?>
