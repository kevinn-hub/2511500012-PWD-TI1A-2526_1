<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Judul Halaman</title>
  <link rel="stylesheet" href="style.css?=v2">
</head>
<body>

  <header>
    <h1>Ini Header</h1>
    <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">&#9776;</button>
    <nav>
      <ul>
        <li><a href="#home">Beranda</a></li>
        <li><a href="#about">Tentang Saya</a></li>
        <li><a href="#contact">Kontak</a></li>
        <li><a href="#ipk">IPK</a></li>
      </ul>
    </nav>
  </header>

  <main>

    <section id="home">
      <h2>Selamat Datang</h2>
      <p>Ini contoh paragraf HTML.</p>
    </section>

    
    <section id="about">
      <?php
        $nim = "2511500012";
        $nama_lengkap = "Leonard Kevin Fernando &#128512;";
        $tempat_lahir  = "Pangkalpinang &#128197;";
        $tanggal_lahir = "&#127874; 11 Juli 2007";
        $hobi_saya = "Main bola voli &#127952;, Main game &#127918;, Nonton &#127916;";
        $pasangan  = "Belum laku &#128542;";
        $saya_berstatus = "Mahasiswa &#127891;";
        $nama_ayah = "Yosef Maryoto &#128104;";
        $nama_ibu = "Deni &#128105;";
        $nama_kakak = "Tidak ada &#128102;";
        $nama_adik = "Anastasia Kezia Aurelia &#128103;";
        ?>
      <h2>Tentang Saya</h2>
      <p><strong>NIM:</strong> <?= $nim ?></p>
      <p><strong>Nama Lengkap:</strong> <?= $nama_lengkap ?></p>
      <p><strong>Tempat Lahir:</strong> <?= $tempat_lahir ?></p>
      <p><strong>Tanggal Lahir:</strong> <?= $tanggal_lahir ?></p>
      <p><strong>Hobi Saya:</strong> <?= $hobi_saya ?></p>
      <p><strong>Pasangan:</strong> <?= $pasangan ?></p>
      <p><strong>Status:</strong> <?= $saya_berstatus ?></p>
      <p><strong>Nama Ayah:</strong> <?= $nama_ayah ?></p>
      <p><strong>Nama Ibu:</strong> <?= $nama_ibu ?></p>
      <p><strong>Nama Kakak:</strong> <?= $nama_kakak ?></p>
      <p><strong>Nama Adik:</strong> <?= $nama_adik ?></p>
    </section>


    <section id="ipk">
      <h2>Perhitungan Nilai Akhir, Grade, dan IPK</h2>

      <?php
      $namaMatkul1 = "Pengantar Teknik Informatika";
      $namaMatkul2 = "Pemrograman Web Dasar";
      $namaMatkul3 = "Aplikasi Perkantoran";
      $namaMatkul4 = "Wawasan Budi Luhur";
      $namaMatkul5 = "Logika Informatika";

      $sksMatkul1 = 4;
      $sksMatkul2 = 6;
      $sksMatkul3 = 4;
      $sksMatkul4 = 4;
      $sksMatkul5 = 6;

      $nilaiHadir1 = 85;     
      $nilaiHadir2 = 77;     
      $nilaiHadir3 = 88;     
      $nilaiHadir4 = 94;     
      $nilaiHadir5 = 92;
      
      $nilaiTugas1 = 84;
      $nilaiTugas2 = 86;
      $nilaiTugas3 = 68;
      $nilaiTugas4 = 77;
      $nilaiTugas5 = 69;

      $nilaiUTS1 = 78;
      $nilaiUTS2 = 79;
      $nilaiUTS3 = 90;
      $nilaiUTS4 = 73;
      $nilaiUTS5 = 82;

      $nilaiUAS1 = 84;
      $nilaiUAS2 = 92;
      $nilaiUAS3 = 82;
      $nilaiUAS4 = 95;
      $nilaiUAS5 = 90;

      function hitungNilai($hadir, $tugas, $uts, $uas, $sks) {
        $nilaiAkhir = (0.1 * $hadir) + (0.2 * $tugas) + (0.3 * $uts) + (0.4 * $uas);

        if ($hadir < 70) {
          $grade = "E";
          $mutu = 0.0;
          $status = "Gagal";
        } else {
              if ($nilaiAkhir >= 91) { $grade = "A"; $mutu = 4.0; }
          elseif ($nilaiAkhir >= 86) { $grade = "A-"; $mutu = 3.7; }
          elseif ($nilaiAkhir >= 81) { $grade = "B+"; $mutu = 3.3; }
          elseif ($nilaiAkhir >= 76) { $grade = "B"; $mutu = 3.0; }
          elseif ($nilaiAkhir >= 71) { $grade = "B-"; $mutu = 2.7; }
          elseif ($nilaiAkhir >= 66) { $grade = "C+"; $mutu = 2.3; }
          elseif ($nilaiAkhir >= 61) { $grade = "C"; $mutu = 2.0; }
          elseif ($nilaiAkhir >= 56) { $grade = "C-"; $mutu = 1.7; }
          elseif ($nilaiAkhir >= 51) { $grade = "D"; $mutu = 1.0; }
            else {$grade = "E"; $mutu = 0.0; }
          $status = ($mutu > 0) ? "Lulus" : "Gagal";
        }

        $bobot = $sks * $mutu;
        return [$nilaiAkhir, $grade, $mutu, $bobot, $status];
      }

      
      list($nilaiAkhir1, $grade1, $mutu1, $bobot1, $status1) = hitungNilai($nilaiHadir1, $nilaiTugas1, $nilaiUTS1, $nilaiUAS1, $sksMatkul1);
      list($nilaiAkhir2, $grade2, $mutu2, $bobot2, $status2) = hitungNilai($nilaiHadir2, $nilaiTugas2, $nilaiUTS2, $nilaiUAS2, $sksMatkul2);
      list($nilaiAkhir3, $grade3, $mutu3, $bobot3, $status3) = hitungNilai($nilaiHadir3, $nilaiTugas3, $nilaiUTS3, $nilaiUAS3, $sksMatkul3);
      list($nilaiAkhir4, $grade4, $mutu4, $bobot4, $status4) = hitungNilai($nilaiHadir4, $nilaiTugas4, $nilaiUTS4, $nilaiUAS4, $sksMatkul4);
      list($nilaiAkhir5, $grade5, $mutu5, $bobot5, $status5) = hitungNilai($nilaiHadir5, $nilaiTugas5, $nilaiUTS5, $nilaiUAS5, $sksMatkul5);

      
      $totalBobot = $bobot1 + $bobot2 + $bobot3 + $bobot4 + $bobot5;
      $totalSKS = $sksMatkul1 + $sksMatkul2 + $sksMatkul3 + $sksMatkul4 + $sksMatkul5;
      $IPK = $totalBobot / $totalSKS;

         for ($i = 1; $i <= 5; $i++) {
          echo "<div class='matkul'>
          <p><strong>Nama Mata Kuliah ke-$i:</strong> ${'namaMatkul'.$i}</p>
          <p><strong>SKS:</strong> ${'sksMatkul'.$i}</p>
          <p><strong>Kehadiran:</strong> ${'nilaiHadir'.$i}</p>
          <p><strong>Tugas:</strong> ${'nilaiTugas'.$i}</p>
          <p><strong>UTS:</strong> ${'nilaiUTS'.$i}</p>
          <p><strong>UAS:</strong> ${'nilaiUAS'.$i}</p>
          <p><strong>Nilai Akhir:</strong> " . number_format(${'nilaiAkhir'.$i}, 2) . "</p>
          <p><strong>Grade:</strong> ${'grade'.$i}</p>
          <p><strong>Angka Mutu:</strong> ${'mutu'.$i}</p>
          <p><strong>Bobot:</strong> ${'bobot'.$i}</p>
          <p><strong>Status:</strong> ${'status'.$i}</p>
          </div><hr>";
          }
          echo "<div class='total'>
          <p><strong>Total SKS:</strong> $totalSKS</p>
          <p><strong>Total Bobot:</strong> $totalBobot</p>
          <p><strong>IPK:</strong> " . number_format($IPK, 2) . "</p>
          </div>";
           ?>        

    </section>
    
    <section id="contact">
      <h2>Kontak Kami</h2>
      <form id="formKontak">
        <label><span>Nama:</span>
          <input type="text" id="txtNama" name="txtNama" placeholder="Masukkan nama" />
        </label>

        <label><span>Email:</span>
          <input type="email" id="txtEmail" name="txtEmail" placeholder="Masukkan email" />
        </label>

        <label><span>Pesan Anda:</span>
          <textarea id="txtPesan" name="txtPesan" rows="4" placeholder="Tulis pesan anda..."></textarea>
        </label>
        <small id="charcount">0/200 karakter</small>
        <div class="tombol">
        <button type="submit">Kirim</button>
        <button type="reset">Batal</button>
      </form>
    </section>

    
    <section id="latihan">
      <h2>Latihan JavaScript</h2>
      <p id="pesan">Teks awal</p>
      <button onclick="ubahTeks()">Ubah Teks</button>
      <br><br>
      <button id="tombol">Klik Saya</button>
      <br><br>
      <input type="text" id="nama" placeholder="Masukkan nama">
      <button onclick="cekNama()">Submit</button>
    </section>

  </main>

  <footer>
    <p>&copy; 2025 Leonard Kevin Fernandi [2511500012]</p>
  </footer>

  <script>
    function ubahTeks() {
      document.getElementById("pesan").innerText = "Teks berhasil diubah!";
    }

    document.getElementById("tombol").addEventListener("click", function() {
      alert("Tombol diklik!");
      console.log("Tombol berhasil diklik!");
    });
  </script>

</body>
</html>
 
<script src="script.js"></script>