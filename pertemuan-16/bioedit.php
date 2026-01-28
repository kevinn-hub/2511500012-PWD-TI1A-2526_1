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
    $_SESSION['flash_error_biodata'] = 'Akses tidak valid.';
    redirect_ke('bioread.php');
  }

  /*
    Ambil data lama dari DB menggunakan prepared statement, 
    jika ada kesalahan, tampilkan penanda error.
  */
  $stmt = mysqli_prepare($conn, "SELECT eid, enim, enamalengkap, etempatlahir, etanggallahir, ehobi, epasangan, epekerjaan, enamaorangtua, enamakakak, enamaadik 
                                    FROM tbl_biodata WHERE eid = ? LIMIT 1");
  if (!$stmt) {
    $_SESSION['flash_error_biodata'] = 'Query tidak benar.';
    redirect_ke('bioread.php');
  }

  mysqli_stmt_bind_param($stmt, "i", $eid);
  mysqli_stmt_execute($stmt);
  $res = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($res);
  mysqli_stmt_close($stmt);

  if (!$row) {
    $_SESSION['flash_error_biodata'] = 'Record tidak ditemukan.';
    redirect_ke('bioread.php');
  }

  #Nilai awal (prefill form)
    $nim          = $row['enim']           ?? '';
    $namalengkap  = $row['enamalengkap']   ?? '';
    $tempatlahir  = $row['etempatlahir']   ?? '';
    $tanggallahir = $row['etanggallahir']  ?? '';
    $hobi         = $row['ehobi']          ?? '';
    $pasangan     = $row['epasangan']      ?? '';
    $pekerjaan    = $row['epekerjaan']     ?? '';
    $namaorangtua = $row['enamaorangtua']  ?? '';
    $namakakak    = $row['enamakakak']     ?? '';
    $namaadik     = $row['enamaadik']      ?? '';

  #Ambil error dan nilai old input kalau ada
  $flash_error = $_SESSION['flash_error_biodata'] ?? '';
  $old = $_SESSION['old'] ?? [];
  unset($_SESSION['flash_error_biodata'], $_SESSION['oldata']);
  if (!empty($old_biodata)) {
    $nim          = $old['nim']           ?? $nim;
    $namalengkap  = $old['namalengkap']   ?? $namalengkap;
    $tempatlahir  = $old['tempatlahir']   ?? $tempatlahir;
    $tanggallahir = $old['tanggallahir']  ?? $tanggallahir;
    $hobi         = $old['hobi']          ?? $hobi;
    $pasangan     = $old['pasangan']      ?? $pasangan;
    $pekerjaan    = $old['pekerjaan']     ?? $pekerjaan;
    $namaorangtua = $old['namaorangtua']  ?? $namaorangtua;
    $namakakak    = $old['namakakak']     ?? $namakakak;
    $namaadik     = $old['namaadik']      ?? $namaadik;
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
        <?php if (!empty($flash_error_biodata)): ?>
          <div style="padding:10px; margin-bottom:10px; 
            background:#f8d7da; color:#721c24; border-radius:6px;">
            <?= $flash_error_biodata; ?>
          </div>
        <?php endif; ?>
        <form action="bioupdate.php" method="POST">

          <input type="hidden" name="eid" value="<?= (int)$eid; ?>">

          <label for="txtNim"><span>NIM:</span>
            <input type="text" id="txtNim" name="txtNim" placeholder="Masukkan NIM" required
                  value="<?= !empty($nim) ? $nim : '' ?>" >
          </label>

          <label for="txtNamaLengkap"><span>Nama Lengkap:</span>
            <input type="text" id="txtNamaLengkap" name="txtNamaLengkap" placeholder="Masukkan Nama Lengkap" required
                  value="<?= !empty($namalengkap) ? $namalengkap : '' ?>" >
          </label>

          <label for="txtTempatlahir"><span>Tempat Lahir:</span>
            <input type="text" id="txtTempatlahir" name="txtTempatlahir" placeholder="Masukkan Tempat Lahir" required
                  value="<?= !empty($tempatlahir) ? $tempatlahir : '' ?>">
          </label>

          <label for="txtTanggallahir"><span>Tanggal Lahir:</span>
            <input type="text" id="txtTanggallahir" name="txtTanggallahir" placeholder="Masukkan Tanggal Lahir" required
                  value="<?= !empty($tanggallahir) ? $tanggallahir : '' ?>">
          </label>

          <label for="txtHobi"><span>Hobi:</span>
            <input type="text" id="txtHobi" name="txtHobi" placeholder="Masukkan Hobi" required
                  value="<?= !empty($hobi) ? $hobi : '' ?>">
          </label>

          <label for="txtPasangan"><span>Pasangan:</span>
            <input type="text" id="txtPasangan" name="txtPasangan" placeholder="Masukkan Pasangan" required
                  value="<?= !empty($pasangan) ? $pasangan : '' ?>">
          </label>

          <label for="txtPekerjaan"><span>Pekerjaan:</span>
            <input type="text" id="txtPekerjaan" name="txtPekerjaan" placeholder="Masukkan Pekerjaan" required
                  value="<?= !empty($pekerjaan) ? $pekerjaan : '' ?>">
          </label>

          <label for="txtNamaOrtu"><span>Nama Orang Tua:</span>
            <input type="text" id="txtNamaOrtu" name="txtNamaOrtu" placeholder="Masukkan Nama Orang Tua" required
                  value="<?= !empty($namaorangtua) ? $namaorangtua : '' ?>">
          </label>

          <label for="txtNamaKakak"><span>Nama Kakak:</span>
            <input type="text" id="txtNamaKakak" name="txtNamaKakak" placeholder="Masukkan Nama Kakak" required
                  value="<?= !empty($namakakak) ? $namakakak : '' ?>">
          </label>

          <label for="txtNamaAdik"><span>Nama Adik:</span>
            <input type="text" id="txtNamaAdik" name="txtNamaAdik" placeholder="Masukkan Nama Adik" required
                  value="<?= !empty($namaadik) ? $namaadik : '' ?>">
          </label>


          <label for="txtCaptcha"><span>Captcha 2 x 3 = ?</span>
            <input type="number" id="txtCaptcha" name="txtCaptcha" 
              placeholder="Jawab Pertanyaan..." required>
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