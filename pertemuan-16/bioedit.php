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
  $stmt = mysqli_prepare($conn, "SELECT  ekodedosen, enamadosen, ealamatrumah, etanggaljadidosen, ejjadosen,
    ehomebaseprodi, enomorhp, enamapasangan, enamaanak, ebidangilmudosen
                                    FROM tbl_biodata WHERE eid = ? LIMIT 1");
  if (!$stmt) {
    $_SESSION['flash_error'] = 'Query tidak benar.';
    redirect_ke('biodread.php');
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
  $kodeDosen  = $row['ekodedosen'] ?? '';
  $namaDosen = $row['enamadosen'] ?? '';
  $alamatRumah = $row['ealamatrumah'] ?? '';
  $tanggalJadi = $row['etanggaljadidosen'] ?? '';
  $jja = $row['ejjadosen'] ?? '';
  $homebaseProdi = $row['ehomebaseprodi'] ?? '';
  $nomorHp = $row['enomorhp'] ?? '';
  $namaPasangan = $row['enamapasangan'] ?? '';
  $namaAnak = $row['enamaanak'] ?? '';
  $bidangIlmu = $row['ebidangilmudosen'] ?? '';

  #Ambil error dan nilai old input kalau ada
  $flash_error = $_SESSION['flash_error'] ?? '';
  $old = $_SESSION['old'] ?? [];
  unset($_SESSION['flash_error'], $_SESSION['old']);
  if (!empty($old)) {
    $kodeDosen     = $old['txtkodedosen']    ?? $kodeDosen ?? '';
    $namaDosen     = $old['txtnamadosen']    ?? $namaDosen ?? '';
    $alamatRumah   = $old['txtalamatrumah']  ?? $alamatRumah ?? '';
    $tanggalJadi   = $old['txttanggaldosen'] ?? $tanggalJadi ?? '';
    $jja           = $old['txtjja']          ?? $jja ?? '';
    $homebaseProdi = $old['txtprodi']        ?? $homebaseProdi ?? '';
    $nomorHp       = $old['txtnomorhp']      ?? $nomorHp ?? '';
    $namaPasangan  = $old['txtnamapasangan'] ?? $namaPasangan ?? '';
    $namaAnak      = $old['txtnamaanak']     ?? $namaAnak ?? '';
    $bidangIlmu    = $old['txtbidangilmu']   ?? $bidangIlmu ?? '';
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

          <label for="txtkodedosen"><span>Kode Dosen:</span>
          <input type="text" id="txtkodedosen" name="txtkodedosen" placeholder="Masukkan Kode Dosen" required
                value="<?= !empty($kodeDosen) ? htmlspecialchars($kodeDosen) : '' ?>">
          </label>

          <label for="txtnamadosen"><span>Nama Dosen:</span>
            <input type="text" id="txtnamadosen" name="txtnamadosen" placeholder="Masukkan Nama Dosen" required
                  value="<?= !empty($namaDosen) ? htmlspecialchars($namaDosen) : '' ?>">
          </label>

          <label for="txtalamatrumah"><span>Alamat Rumah:</span>
            <input type="text" id="txtalamatrumah" name="txtalamatrumah" placeholder="Masukkan Alamat Rumah" required
                  value="<?= !empty($alamatRumah) ? htmlspecialchars($alamatRumah) : '' ?>">
          </label>

          <label for="txttanggaldosen"><span>Tanggal Jadi Dosen:</span>
            <input type="text" id="txttanggaldosen" name="txttanggaldosen" placeholder="Masukkan Tanggal Jadi Dosen" required
                  value="<?= !empty($tanggalJadi) ? htmlspecialchars($tanggalJadi) : '' ?>">
          </label>

          <label for="txtjja"><span>JJA Dosen:</span>
            <input type="text" id="txtjja" name="txtjja" placeholder="Masukkan JJA Dosen" required
                  value="<?= !empty($jja) ? htmlspecialchars($jja) : '' ?>">
          </label>

          <label for="txtprodi"><span>Homebase Prodi:</span>
            <input type="text" id="txtprodi" name="txtprodi" placeholder="Masukkan Homebase Prodi" required
                  value="<?= !empty($homebaseProdi) ? htmlspecialchars($homebaseProdi) : '' ?>">
          </label>

          <label for="txtnomorhp"><span>Nomor HP:</span>
            <input type="text" id="txtnomorhp" name="txtnomorhp" placeholder="Masukkan Nomor HP" required
                  value="<?= !empty($nomorHp) ? htmlspecialchars($nomorHp) : '' ?>">
          </label>

          <label for="txtnamapasangan"><span>Nama Pasangan:</span>
            <input type="text" id="txtnamapasangan" name="txtnamapasangan" placeholder="Masukkan Nama Pasangan" required
                  value="<?= !empty($namaPasangan) ? htmlspecialchars($namaPasangan) : '' ?>">
          </label>

          <label for="txtnamaanak"><span>Nama Anak:</span>
            <input type="text" id="txtnamanak" name="txtnamaanak" placeholder="Masukkan Nama Anak" required
                  value="<?= !empty($namaAnak) ? htmlspecialchars($namaAnak) : '' ?>">
          </label>

          <label for="txtbidangilmu"><span>Bidang Ilmu Dosen:</span>
            <input type="text" id="txtbidangilmu" name="txtbidangilmu" placeholder="Masukkan Bidang Ilmu Dosen" required
                  value="<?= !empty($bidangIlmu) ? htmlspecialchars($bidangIlmu) : '' ?>">
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
  