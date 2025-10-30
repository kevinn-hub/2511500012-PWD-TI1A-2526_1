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
        <ul type="square">
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
        echo "nama saya kevin";
      ?>
      
      <p>ini contoh paragraf HTML.</p>
    </section>

    <section id="about">
      <?php
        $nim = 1234556788;
        $NIM = "2511500012";
        $nama = "kevin f\'ernando";
      ?>
      <h2>Tentang Saya</h2>
        <p><strong>Nim:</strong><?php
            echo $NIM;
            ?></p>
        <p><strong>Nama Lengkap:</strong> Leonard kevin Fernando &#128512;</p>
        <p><strong>Tempat lahir:</strong> Pangkalpinang, &#128197;</p> 
        <p><strong>Tanggal Lahir:</strong> &#127874; 11 juli 2007</p>
        <p><strong>Hobi Saya:</strong> Main bola voli &#127952; ,Main game &#127918; ,Nonton &#127916;</p>
        <p><strong>Pasangan:</strong> Belum laku &#128542;</p>
        <p><strong>Saya berstatus:</strong> Mahasiswa &#127891;</p> 
        <p><strong>Nama ayah:</strong> Yosef Maryoto &#128104;</p>
        <p><strong>Nama ibu:</strong> Deni &#128105;</p>
        <p><strong>Nama kakak:</strong> Tidak ada &#128542;</p> 
        <p><strong>Nama Adik:</strong> Anastasia Kezia Aurelia &#128103;</p>
      
    </section>

    <section id="contact">
      <h2>Kontak Kami</h2>
      <form id="formKontak">
        <label>
          <span>Nama:</span>
          <input type="text" id="txtNama" name="txtNama" placeholder="Masukkan nama">
        </label>

        <label>
          <span>Email:</span>
          <input type="email" id="txtEmail" name="txtEmail" placeholder="Masukkan email">
        </label>

        <label>
          <span>Pesan Anda:</span>
          <textarea id="txtPesan" name="txtPesan" rows="4" placeholder="Tulis pesan anda..."></textarea>
        </label>

        <small id="charCount">0/200 karakter</small>
        <div class="tombol">
          <button type="submit">Kirim</button>
          <button type="reset">Batal</button>
        </div>
      </form>
    </section>

   </main>
<footer>
    <p>&copy; 2025 LEONARD KEVIN FERNANDO [2511500012]</p>
  </footer>
  <script src="script.js"></script>

</body>
</html>