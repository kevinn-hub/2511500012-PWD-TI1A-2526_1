<?php
  session_start();
  require 'koneksi.php';
  require 'fungsi.php';

  /*
    Ambil nilai cid dari GET dan lakukan validasi untuk 
    mengecek cid harus angka dan lebih besar dari 0 (> 0).
    'options' => ['min_range' => 1] artinya cid harus ≥ 1 
    (bukan 0, bahkan bukan negatif, bukan huruf, bukan HTML).
  */
  $eid = filter_input(INPUT_GET, 'eid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
  ]);
  /*
    Skrip di atas cara penulisan lamanya adalah:
    $cid = $_GET['cid'] ?? '';
    $cid = (int)$cid;

    Cara lama seperti di atas akan mengambil data mentah 
    kemudian validasi dilakukan secara terpisah, sehingga 
    rawan lupa validasi. Untuk input dari GET atau POST, 
    filter_input() lebih disarankan daripada $_GET atau $_POST.
  */

  /*
    Cek apakah $cid bernilai valid:
    Kalau $cid tidak valid, maka jangan lanjutkan proses, 
    kembalikan pengguna ke halaman awal (read.php) sembari 
    mengirim penanda error.
  */
  if (!$eid) {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('bioread.php');
  }
  

  /*
    Ambil data lama dari DB menggunakan prepared statement, 
    jika ada kesalahan, tampilkan penanda error.
  */
  $stmt = mysqli_prepare($conn, "SELECT enim, enamlengkap, etempatlahir, etanggallahir, ehobi, epasangan, epekerjaan, enamaortu, enamakakak, enamadik
                                    FROM tbl_biodata WHERE eid = ? LIMIT 1");
  if (!$stmt) {
    $_SESSION['flash_error'] = 'Query tidak benar.';
    redirect_ke('bioread.php');
  }

  mysqli_stmt_bind_param($stmt, "i", $eid);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($res);
  mysqli_stmt_close($stmt);

  if (!$row) {
    $_SESSION['flash_error'] = 'Record tidak ditemukan.';
    redirect_ke('bioread.php');
  }

  #Nilai awal (prefill form)
  $nim          = $row["enim"] ?? '';
  $namaLengkap  = $row["enamlengkap"] ?? '';
  $tempatLahir  = $row["etempatlahir"] ?? '';
  $tanggalLahir = $row["etanggallahir"] ?? '';
  $hobi         = $row["ehobi"] ?? '';
  $pasangan     = $row["epasangan"] ?? '';
  $pekerjaan    = $row["epekerjaan"] ?? '';
  $namaOrtu     = $row["enamaortu"] ?? '';
  $namaKakak    = $row["enamakakak"] ?? '';
  $namaAdik     = $row["enamadik"] ?? '';


  #Ambil error dan nilai old input kalau ada
  $flash_error = $_SESSION['flash_error'] ?? '';
  $old = $_SESSION['old'] ?? [];
  unset($_SESSION['flash_error'], $_SESSION['old']);
  if (!empty($old)) {
  $nim          = $old['txtNim'] ?? $nim;
  $namaLengkap  = $old['txtNmLengkap'] ?? $namaLengkap;
  $tempatLahir  = $old['txtT4Lhr'] ?? $tempatLahir;
  $tanggalLahir = $old['txtTglLhr'] ?? $tanggalLahir;
  $hobi         = $old['txtHobi'] ?? $hobi;
  $pasangan     = $old['txtPasangan'] ?? $pasangan;
  $pekerjaan    = $old['txtKerja'] ?? $pekerjaan;
  $namaOrtu     = $old['txtNmOrtu'] ?? $namaOrtu;
  $namaKakak    = $old['txtNmKakak'] ?? $namaKakak;
  $namaAdik     = $old['txtNmAdik'] ?? $namaAdik;
}
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judul Halaman</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header>
      <h1>Ini Header</h1>
      <button class="menu-toggle" id="menuToggle" aria-label="Toggle Navigation">
        &#9776;
      </button>
      <nav>
        <ul>
          <li><a href="#home">Beranda</a></li>
          <li><a href="#about">Tentang</a></li>
          <li><a href="#contact">Kontak</a></li>
        </ul>
      </nav>
    </header>

    <main>

        

      <section id="biodata">
        <h2>Edit Buku Tamu</h2>
        <?php if (!empty($flash_error)): ?>
          <div style="padding:10px; margin-bottom:10px; 
            background:#f8d7da; color:#721c24; border-radius:6px;">
            <?= $flash_error; ?>
          </div>
        <?php endif; ?>
        <form action="bioupdate.php" method="POST">

          <input type="hidden" name="eid" value="<?= (int)$eid; ?>">

                <label for="txtNim"><span>NIM:</span>
          <input type="text" id="txtNim" name="txtNim" placeholder="Masukkan NIM" required
                value="<?= !empty($nim) ? htmlspecialchars($nim) : '' ?>" readonly>
        </label>

        <label for="txtNmLengkap"><span>Nama Lengkap:</span>
          <input type="text" id="txtNmLengkap" name="txtNmLengkap" placeholder="Masukkan Nama Lengkap" required
                value="<?= !empty($namaLengkap) ? htmlspecialchars($namaLengkap) : '' ?>">
        </label>

        <label for="txtT4Lhr"><span>Tempat Lahir:</span>
          <input type="text" id="txtT4Lhr" name="txtT4Lhr" placeholder="Masukkan Tempat Lahir" required
                value="<?= !empty($tempatLahir) ? htmlspecialchars($tempatLahir) : '' ?>">
        </label>

        <label for="txtTglLhr"><span>Tanggal Lahir:</span>
          <input type="date" id="txtTglLhr" name="txtTglLhr" placeholder="YYYY-MM-DD" required
                value="<?= !empty($tanggalLahir) ? htmlspecialchars($tanggalLahir) : '' ?>">
        </label>

        <label for="txtHobi"><span>Hobi:</span>
          <input type="text" id="txtHobi" name="txtHobi" placeholder="Masukkan Hobi" required
                value="<?= !empty($hobi) ? htmlspecialchars($hobi) : '' ?>">
        </label>

        <label for="txtPasangan"><span>Pasangan:</span>
          <input type="text" id="txtPasangan" name="txtPasangan" placeholder="Masukkan Pasangan" required
                value="<?= !empty($pasangan) ? htmlspecialchars($pasangan) : '' ?>">
        </label>

        <label for="txtKerja"><span>Pekerjaan:</span>
          <input type="text" id="txtKerja" name="txtKerja" placeholder="Masukkan Pekerjaan" required
                value="<?= !empty($pekerjaan) ? htmlspecialchars($pekerjaan) : '' ?>">
        </label>

        <label for="txtNmOrtu"><span>Nama Orang Tua:</span>
          <input type="text" id="txtNmOrtu" name="txtNmOrtu" placeholder="Masukkan Nama Orang Tua" required
                value="<?= !empty($namaOrtu) ? htmlspecialchars($namaOrtu) : '' ?>">
        </label>

        <label for="txtNmKakak"><span>Nama Kakak:</span>
          <input type="text" id="txtNmKakak" name="txtNmKakak" placeholder="Masukkan Nama Kakak" required
                value="<?= !empty($namaKakak) ? htmlspecialchars($namaKakak) : '' ?>">
        </label>

        <label for="txtNmAdik"><span>Nama Adik:</span>
          <input type="text" id="txtNmAdik" name="txtNmAdik" placeholder="Masukkan Nama Adik" required
                value="<?= !empty($namaAdik) ? htmlspecialchars($namaAdik) : '' ?>">
        </label>

       

          <button type="submit">update</button>
          <button type="reset">Batal</button>
          <a href="bioread.php" class="reset">Kembali</a>
        </form>
      </section>
    </main>

    <script src="script.js"></script>
  </body>
</html>