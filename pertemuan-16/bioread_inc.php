<?php
require 'koneksi.php';

// Konfigurasi label dan suffix untuk tiap field
$fieldConfig = [
    "kodedosen"     => ["label" => "Kode Dosen:", "suffix" => ""],
    "namadosen"     => ["label" => "Nama Dosen:", "suffix" => " &#128526;"],
    "alamarumah"   => ["label" => "Alamat Rumah:", "suffix" => ""],
    "tanggaljadi"   => ["label" => "Tanggal Jadi Dosen:", "suffix" => ""],
    "jja"           => ["label" => "JJA Dosen:", "suffix" => " &#127926;"],
    "homebaseprodi" => ["label" => "Homebase Prodi:", "suffix" => " &hearts;"],
    "nomorhp"       => ["label" => "Nomor HP:", "suffix" => " &copy; 2025"],
    "namapasangan"  => ["label" => "Nama Pasangan:", "suffix" => ""],
    "namaanak"      => ["label" => "Nama Anak:", "suffix" => ""],
    "bidangilmu"    => ["label" => "Bidang Ilmu Dosen:", "suffix" => ""],
];

// Ambil data dari database
$sql = "SELECT * FROM tbl_biodata ORDER BY eid DESC";
$q = mysqli_query($conn, $sql);

if (!$q) {
    echo "<p>Gagal membaca data tamu: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
} elseif (mysqli_num_rows($q) === 0) {
    echo "<p>Belum ada data tamu yang tersimpan.</p>";
} else {
    while ($row = mysqli_fetch_assoc($q)) {
        // Buat array data dosen
        $arrBiodata = [
    "kodedosen"     => $row["ekodedosen"] ?? "",
    "namadosen"     => $row["enamadosen"] ?? "",
    "alamarumah"    => $row["ealamatrumah"] ?? "",
    "tanggaljadi"   => $row["etanggaljadidosen"] ?? "",
    "jja"           => $row["ejjadosen"] ?? "",
    "homebaseprodi" => $row["ehomebaseprodi"] ?? "",
    "nomorhp"       => $row["enomorhp"] ?? "",
    "namapasangan"  => $row["enamapasangan"] ?? "",
    "namaanak"      => $row["enamaanak"] ?? "",
    "bidangilmu"    => $row["ebidangilmudosen"] ?? ""
];


        // Tampilkan data menggunakan fungsi tampilkanBiodata
        echo tampilkanBiodata($fieldConfig, $arrBiodata);
    }
}
?>
