<?php
session_start();
require_once __DIR__ . '/fungsi.php';
?>

<!DOCTYPE html>
<html lang="en">

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
    <section id="home">
      <h2>Selamat Datang</h2>
      <?php
      echo "halo dunia!<br>";
      echo "nama saya hadi";
      ?>
      <p>Ini contoh paragraf HTML.</p>
    </section>

       <?php
        $flash_sukses = $_SESSION['flash_sukses'] ?? ''; #jika query sukses
        $flash_error  = $_SESSION['flash_error'] ?? ''; #jika ada error
        $old          = $_SESSION['old'] ?? []; #untuk nilai lama form

        unset($_SESSION['flash_sukses'], $_SESSION['flash_error'], $_SESSION['old']); #bersihkan 3 session ini
        ?>

    <section id="biodata">
      <h2>Biodata Dosen</h2>

      <?php if (!empty($flash_sukses)): ?>
        <div style="padding:10px; margin-bottom:10px; background:#d4edda; color:#155724; border-radius:6px;">
          <?= $flash_sukses; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($flash_error)): ?>
        <div style="padding:10px; margin-bottom:10px; background:#f8d7da; color:#721c24; border-radius:6px;">
          <?= $flash_error; ?>
        </div>
      <?php endif; ?>

      <form action="bioproses.php" method="POST">

        <label for="txtkodedosen"><span>Kode Dosen:</span>
          <input type="text" id="txtkodedosen" name="txtkodedosen" placeholder="Masukkan Kode Dosen" required
           value="<?= isset($old['txtkodedosen']) ? htmlspecialchars($old['txtkodedosen']) : '' ?>">
        </label>

        <label for="txtnamadosen"><span>Nama Dosen:</span>
          <input type="text" id="txtnamadosen" name="txtnamadosen" placeholder="Masukkan Nama Dosen" required
           value="<?= isset($old['txtnamadosen']) ? htmlspecialchars($old['txtnamadosen']) : '' ?>">
        </label>

        <label for="txtalamatrumah"><span>Alamat Rumah:</span>
          <input type="text" id="txtalamatrumah" name="txtalamatrumah" placeholder="Masukkan Alamat Rumah" required
           value="<?= isset($old['txtalamatrumah']) ? htmlspecialchars($old['txtalamatrumah']) : '' ?>">
        </label>

        <label for="txttanggaldosen"><span>Tanggal Jadi Dosen:</span>
          <input type="text" id="txttangaldosen" name="txttanggaldosen" placeholder="Masukkan Tanggal Jadi Dosen" required
           value="<?= isset($old['txttanggaldosen']) ? htmlspecialchars($old['txttanggaldosen']) : '' ?>">
        </label>

        <label for="txtjja"><span>JJA Dosen:</span>
          <input type="text" id="txtjja" name="txtjja" placeholder="Masukkan JJA Dosen" required
           value="<?= isset($old['txtjja']) ? htmlspecialchars($old['txtjja']) : '' ?>">
        </label>

        <label for="txtprodi"><span>Homebase Prodi:</span>
          <input type="text" id="txtprodi" name="txtprodi" placeholder="Masukkan Homebase Prodi" required
           value="<?= isset($old['txtprodi']) ? htmlspecialchars($old['txtprodi']) : '' ?>">
        </label>

        <label for="txtnomorhp"><span>Nomor HP:</span>
          <input type="text" id="txtnomorhp" name="txtnomorhp" placeholder="Masukkan Nomor HP" required
           value="<?= isset($old['txtnomorhp']) ? htmlspecialchars($old['txtnomorhp']) : '' ?>">
        </label>

        <label for="txtnamapasangan"><span>Nama Pasangan:</span>
          <input type="text" id="txtnamapasangan" name="txtnamapasangan" placeholder="Masukkan Nama Pasangan" required
           value="<?= isset($old['txtnamapasangan']) ? htmlspecialchars($old['txtnamapasangan']) : '' ?>">
        </label>

        <label for="txtnamaanak"><span>Nama Anak:</span>
          <input type="text" id="txtnamanak" name="txtnamaanak" placeholder="Masukkan Nama Anak" required
           value="<?= isset($old['txtnamaanak']) ? htmlspecialchars($old['txtnamaanak']) : '' ?>">
        </label>

        <label for="txtbidangilmu"><span>Bidang Ilmu Dosen:</span>
          <input type="text" id="txtbidangilmu" name="txtbidangilmu" placeholder="Masukkan Bidang Ilmu Dosen" required
           value="<?= isset($old['txtbidangilmu']) ? htmlspecialchars($old['txtbidangilmu']) : '' ?>">
        </label>

        <label for="txtCaptcha"><span>Captcha 2 + 3 = ?</span>
          <input type="number" id="txtCaptcha" name="txtCaptcha" placeholder="Jawab Pertanyaan..."
            required
            value="<?= isset($old['captcha']) ? htmlspecialchars($old['captcha']) : '' ?>">
        </label>

        <button type="submit">Kirim</button>
        <button type="reset">Batal</button>
      </form>
    </section>

    <?php
    $biodata = $_SESSION["biodata"] ?? [];

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
    ?>

    <section id="about">
      <h2>Tentang Saya</h2>
      <?php include 'bioread_inc.php'; ?>
    </section>

    <?php
    $flash_mantap = $_SESSION['flash_mantap'] ?? ''; #jika query sukses
    $flash_gagal  = $_SESSION['flash_gagal'] ?? ''; #jika ada error
    $oldata       = $_SESSION['oldata'] ?? []; #untuk nilai lama form

    unset($_SESSION['flash_mantap'], $_SESSION['flash_gagal'], $_SESSION['oldata']); #bersihkan 3 session ini
    ?>

    <section id="contact">
      <h2>Kontak Kami</h2>

      <?php if (!empty($flash_mantap)): ?>
        <div style="padding:10px; margin-bottom:10px; background:#d4edda; color:#155724; border-radius:6px;">
          <?= $flash_mantap; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($flash_gagal)): ?>
        <div style="padding:10px; margin-bottom:10px; background:#f8d7da; color:#721c24; border-radius:6px;">
          <?= $flash_gagal; ?>
        </div>
      <?php endif; ?>

      <form action="proses.php" method="POST">

        <label for="txtNama"><span>Nama:</span>
          <input type="text" id="txtNama" name="txtNama" placeholder="Masukkan nama"
            required autocomplete="name"
            value="<?= isset($old['nama']) ? htmlspecialchars($old['nama']) : '' ?>">
        </label>

        <label for="txtEmail"><span>Email:</span>
          <input type="email" id="txtEmail" name="txtEmail" placeholder="Masukkan email"
            required autocomplete="email"
            value="<?= isset($old['email']) ? htmlspecialchars($old['email']) : '' ?>">
        </label>

        <label for="txtPesan"><span>Pesan Anda:</span>
          <textarea id="txtPesan" name="txtPesan" rows="4" placeholder="Tulis pesan anda..."
            required><?= isset($old['pesan']) ? htmlspecialchars($old['pesan']) : '' ?></textarea>
          <small id="charCount">0/200 karakter</small>
        </label>

        <label for="txtCaptcha"><span>Captcha 2 + 3 = ?</span>
          <input type="number" id="txtCaptcha" name="txtCaptcha" placeholder="Jawab Pertanyaan..."
            required
            value="<?= isset($old['captcha']) ? htmlspecialchars($old['captcha']) : '' ?>">
        </label>

        <button type=" submit">Kirim</button>
          <button type="reset">Batal</button>
      </form>

      <br>
      <hr>
      <h2>Yang menghubungi kami</h2>
      <?php include 'read_inc.php'; ?>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Yohanes Setiawan Japriadi [0344300002]</p>
  </footer>

  <script src="script.js"></script>
</body>

</html>