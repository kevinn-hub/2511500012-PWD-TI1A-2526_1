<?php
  session_start();
  require __DIR__ . '/koneksi.php';
  require_once __DIR__ . '/fungsi.php';

  #cek method form, hanya izinkan POST
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error_biodata'] = 'Akses tidak valid.';
    redirect_ke('bioread.php');
  }

  #validasi cid wajib angka dan > 0
  $eid = filter_input(INPUT_POST, 'eid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
  ]);

  if (!$eid) {
    $_SESSION['flash_error_biodata'] = 'eID Tidak Valid.';
    redirect_ke('bioedit.php?eid='. (int)$eid);
  }

  #ambil dan bersihkan (sanitasi) nilai dari form
    $nim          = bersihkan($_POST['txtNim'] ?? '');
    $namalengkap  = bersihkan($_POST['txtNamaLengkap'] ?? '');
    $tempatlahir  = bersihkan($_POST['txtTempatlahir'] ?? '');
    $tanggallahir = bersihkan($_POST['txtTanggallahir'] ?? '');
    $hobi         = bersihkan($_POST['txtHobi'] ?? '');
    $pasangan     = bersihkan($_POST['txtPasangan'] ?? '');
    $pekerjaan    = bersihkan($_POST['txtPekerjaan'] ?? '');
    $namaorangtua = bersihkan($_POST['txtNamaOrtu'] ?? '');
    $namakakak    = bersihkan($_POST['txtNamaKakak'] ?? '');
    $namaadik     = bersihkan($_POST['txtNamaAdik'] ?? '');
    $captcha      = bersihkan($_POST['txtCaptcha'] ?? '');


  #Validasi sederhana
  $errors = []; #ini array untuk menampung semua error yang ada
    if ($nim === '') {
      $errors[] = 'NIM wajib diisi.';
    }

    if ($namalengkap === '') {
        $errors[] = 'Nama lengkap wajib diisi.';
    } elseif (mb_strlen($namalengkap) < 3) {
        $errors[] = 'Nama lengkap minimal 3 karakter.';
    }

    if ($tempatlahir === '') {
        $errors[] = 'Tempat lahir wajib diisi.';
    }

    if ($tanggallahir === '') {
        $errors[] = 'Tanggal lahir wajib diisi.';
    }

    if ($hobi === '') {
        $errors[] = 'Hobi wajib diisi.';
    }

    if ($pasangan === '') {
        $errors[] = 'Pasangan wajib diisi.';
    }

    if ($pekerjaan === '') {
        $errors[] = 'Pekerjaan wajib diisi.';
    }

    if ($namaorangtua === '') {
        $errors[] = 'Nama orang tua wajib diisi.';
    }

    if ($namakakak === '') {
        $errors[] = 'Nama kakak wajib diisi.';
    }

    if ($namaadik === '') {
        $errors[] = 'Nama adik wajib diisi.';
    }

  if ($captcha!=="6") {
    $errors[] = 'Jawaban '. $captcha.' captcha salah.';
  }

  /*
  kondisi di bawah ini hanya dikerjakan jika ada error, 
  simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
  */
  if (!empty($errors)) {
    $_SESSION['oldata'] = [
    'nim'            => $nim,
    'namalengkap'    => $namalengkap,
    'tempatlahir'    => $tempatlahir,
    'tanggallahir'   => $tanggallahir,
    'hobi'           => $hobi,
    'pasangan'       => $pasangan,
    'pekerjaan'      => $pekerjaan,
    'namaorangtua'   => $namaorangtua,
    'namakakak'      => $namakakak,
    'namaadik'       => $namaadik
    ];

    $_SESSION['flash_error_biodata'] = implode('<br>', $errors);
    redirect_ke('bioedit.php?eid='. (int)$eid);
  }

  /*
    Prepared statement untuk anti SQL injection.
    menyiapkan query UPDATE dengan prepared statement 
    (WAJIB WHERE cid = ?)
  */
  $stmt = mysqli_prepare($conn, "UPDATE tbl_biodata
                                SET enim = ?, enamalengkap = ?, etempatlahir = ?, etanggallahir = ?, 
                                    ehobi = ?, epasangan = ?, epekerjaan = ?, 
                                    enamaorangtua = ?, enamakakak = ?, enamaadik = ? 
                                WHERE eid = ?");
  if (!$stmt) {
    #jika gagal prepare, kirim pesan error (tanpa detail sensitif)
    $_SESSION['flash_error_biodata'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('bioedit.php?eid='. (int)$eid);
  }

  #bind parameter dan eksekusi (s = string, i = integer)
  mysqli_stmt_bind_param($stmt, "ssssssssssi",    
    $nim,
    $namalengkap,
    $tempatlahir,
    $tanggallahir,
    $hobi,
    $pasangan,
    $pekerjaan,
    $namaorangtua,
    $namakakak,
    $namaadik,
    $eid);

  if (mysqli_stmt_execute($stmt)) { #jika berhasil, kosongkan old value
    unset($_SESSION['oldata']);
    /*
      Redirect balik ke read.php dan tampilkan info sukses.
    */
    $_SESSION['flash_sukses_biodata'] = 'Terima kasih, data Anda sudah diperbaharui.';
    redirect_ke('bioread.php'); #pola PRG: kembali ke data dan exit()
  } else { #jika gagal, simpan kembali old value dan tampilkan error umum
    $_SESSION['oldata'] = [
    'nim'            => $nim,
    'namalengkap'    => $namalengkap,
    'tempatlahir'    => $tempatlahir,
    'tanggallahir'   => $tanggallahir,
    'hobi'           => $hobi,
    'pasangan'       => $pasangan,
    'pekerjaan'      => $pekerjaan,
    'namaorangtua'   => $namaorangtua,
    'namakakak'      => $namakakak,
    'namaadik'       => $namaadik
    ];
    $_SESSION['flash_error_biodata'] = 'Data gagal diperbaharui. Silakan coba lagi.';
    redirect_ke('bioedit.php?eid='. (int)$eid);
  }
  #tutup statement
  mysqli_stmt_close($stmt);

  redirect_ke('bioedit.php?eid='. (int)$eid);