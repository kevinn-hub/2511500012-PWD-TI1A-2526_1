<?php
  session_start();
  require __DIR__ . '/koneksi.php';
  require_once __DIR__ . '/fungsi.php';

  #cek method form, hanya izinkan POST
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_error'] = 'Akses tidak valid.';
    redirect_ke('bioread.php');
  }

  #validasi cid wajib angka dan > 0
  $eid = filter_input(INPUT_POST, 'eid', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1]
  ]);

  if (!$eid) {
    $_SESSION['flash_error'] = 'CID Tidak Valid.';
    redirect_ke('bioedit.php?eid='. (int)$eid);
  }

  #ambil dan bersihkan (sanitasi) nilai dari form
  $kodeDosen = bersihkan($_POST['txtkodedosen'] ?? '');
  $namaDosen     = bersihkan($_POST['txtnamadosen'] ?? '');
  $alamatRumah   = bersihkan($_POST['txtalamatrumah'] ?? '');
  $tanggalJadi   = bersihkan($_POST['txttanggaldosen'] ?? '');
  $jja           = bersihkan($_POST['txtjja'] ?? '');
  $homebaseProdi = bersihkan($_POST['txtprodi'] ?? '');
  $nomorHp       = bersihkan($_POST['txtnomorhp'] ?? '');
  $namaPasangan  = bersihkan($_POST['txtnamapasangan'] ?? '');
  $namaAnak      = bersihkan($_POST['txtnamaanak'] ?? '');
  $bidangIlmu    = bersihkan($_POST['txtbidangilmu'] ?? '');
  $captcha       = bersihkan($_POST['txtCaptcha'] ?? '');

  #Validasi sederhana
 $errors = []; // array untuk menampung semua error

// Validasi masing-masing field
if ($kodeDosen === '') {
    $errors[] = 'Nama Dosen wajib diisi.';
}
if ($namaDosen === '') {
    $errors[] = 'Nama Dosen wajib diisi.';
}

if ($alamatRumah === '') {
    $errors[] = 'Alamat Rumah wajib diisi.';
}

if ($tanggalJadi === '') {
    $errors[] = 'Tanggal Jadi Dosen wajib diisi.';
}

if ($jja === '') {
    $errors[] = 'JJA Dosen wajib diisi.';
}

if ($homebaseProdi === '') {
    $errors[] = 'Homebase Prodi wajib diisi.';
}

if ($nomorHp === '') {
    $errors[] = 'Nomor HP wajib diisi.';
}

if ($namaPasangan === '') {
    $errors[] = 'Nama Pasangan wajib diisi.';
}

if ($namaAnak === '') {
    $errors[] = 'Nama Anak wajib diisi.';
}

if ($bidangIlmu === '') {
    $errors[] = 'Bidang Ilmu Dosen wajib diisi.';
}

if ($captcha === '') {
    $errors[] = 'Captcha wajib diisi.';
} elseif ($captcha !== "6") {
    $errors[] = 'Jawaban captcha salah.';
}

  /*
  kondisi di bawah ini hanya dikerjakan jika ada error, 
  simpan nilai lama dan pesan error, lalu redirect (konsep PRG)
  */
  if (!empty($errors)) {
    $_SESSION['old'] = [
      'txtkodedosen'   => $kodeDosen,
      'txtnamadosen'   => $namaDosen,
      'txtalamatrumah' => $alamatRumah,
      'txttanggaldosen'=> $tanggalJadi,
      'txtjja'         => $jja,
      'txtprodi'       => $homebaseProdi,
      'txtnomorhp'     => $nomorHp,
      'txtnamapasangan' => $namaPasangan,
      'txtnamaanak'    => $namaAnak,
      'txtbidangilmu'  => $bidangIlmu,
      'txtCaptcha'     => $captcha
    ];

    $_SESSION['flash_error'] = implode('<br>', $errors);
    redirect_ke('bioedit.php?eid='. (int)$eid);
  }

  /*
    Prepared statement untuk anti SQL injection.
    menyiapkan query UPDATE dengan prepared statement 
    (WAJIB WHERE cid = ?)
  */
  $stmt = mysqli_prepare($conn, "UPDATE tbl_biodata
                                SET ekodedosen     = ?, 
                                    enamadosen     = ?, 
                                    ealamatrumah   = ?, 
                                    etanggaljadidosen = ?, 
                                    ejjadosen      = ?, 
                                    ehomebaseprodi = ?, 
                                    enomorhp       = ?, 
                                    enamapasangan  = ?, 
                                    enamaanak      = ?, 
                                    ebidangilmudosen = ?
                                WHERE eid = ?");
  if (!$stmt) {
    #jika gagal prepare, kirim pesan error (tanpa detail sensitif)
    $_SESSION['flash_error'] = 'Terjadi kesalahan sistem (prepare gagal).';
    redirect_ke('bioedit.php?cid='. (int)$eid);
  }

  #bind parameter dan eksekusi (s = string, i = integer)
mysqli_stmt_bind_param($stmt, "ssssssssssi", 
    $kodeDosen, $namaDosen, $alamatRumah, $tanggalJadi, $jja, 
    $homebaseProdi, $nomorHp, $namaPasangan, $namaAnak, $bidangIlmu, $eid);


  if (mysqli_stmt_execute($stmt)) { #jika berhasil, kosongkan old value
    unset($_SESSION['old']);
    /*
      Redirect balik ke read.php dan tampilkan info sukses.
    */
    $_SESSION['flash_sukses'] = 'Terima kasih, data Anda sudah diperbaharui.';
    redirect_ke('bioread.php'); #pola PRG: kembali ke data dan exit()
  } else { #jika gagal, simpan kembali old value dan tampilkan error umum
    $_SESSION['old'] = [
    'txtkodedosen'   => $kodeDosen,
    'txtnamadosen'   => $namaDosen,
    'txtalamatrumah' => $alamatRumah,
    'txttanggaldosen'=> $tanggalJadi,
    'txtjja'         => $jja,
    'txtprodi'       => $homebaseProdi,
    'txtnomorhp'     => $nomorHp,
    'txtnamapasangan' => $namaPasangan,
    'txtnamaanak'    => $namaAnak,
    'txtbidangilmu'  => $bidangIlmu,
    'txtCaptcha'     => $captcha
  ];
    $_SESSION['flash_error'] = 'Data gagal diperbaharui. Silakan coba lagi.';
    redirect_ke('bioedit.php?cid='. (int)$eid);
  }
  #tutup statement
  mysqli_stmt_close($stmt);

  redirect_ke('bioedit.php?eid='. (int)$eid);