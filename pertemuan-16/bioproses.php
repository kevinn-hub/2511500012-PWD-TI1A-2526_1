    <?php
    session_start();
    require __DIR__ . './koneksi.php';
    require_once __DIR__ . '/fungsi.php';

    // Cek method POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['flash_error_biodata'] = 'Akses tidak valid.';
        redirect_ke('index.php#biodata');
    }

    // Ambil dan bersihkan nilai dari form
    $kodedosen        = bersihkan($_POST['txtKodeDosen'] ?? '');
    $namadosen        = bersihkan($_POST['txtNmDosen'] ?? '');
    $alamatrumah      = bersihkan($_POST['txtAlRmh'] ?? '');
    $tanggaljadidosen = bersihkan($_POST['txtTglDosen'] ?? '');
    $jjadosen         = bersihkan($_POST['txtJJA'] ?? '');
    $homebaseprodi    = bersihkan($_POST['txtProdi'] ?? '');
    $nomorhp          = bersihkan($_POST['txtNoHP'] ?? '');
    $namapasangan     = bersihkan($_POST['txNamaPasangan'] ?? '');
    $namaanak         = bersihkan($_POST['txtNmAnak'] ?? '');
    $namakakak        = bersihkan($_POST['txtNmKakak'] ?? '');
    $bidangilmudosen  = bersihkan($_POST['txtBidangIlmu'] ?? '');

    // Validasi sederhana
    $errors = [];

    if ($kodedosen === '') $errors[] = 'Kode Dosen wajib diisi.';
    if ($namadosen === '') $errors[] = 'Nama Dosen wajib diisi.';
    elseif (mb_strlen($namadosen) < 3) $errors[] = 'Nama Dosen minimal 3 karakter.';
    if ($alamatrumah === '') $errors[] = 'Alamat Rumah wajib diisi.';
    if ($tanggaljadidosen === '') $errors[] = 'Tanggal Jadi Dosen wajib diisi.';
    if ($jjadosen === '') $errors[] = 'JJA Dosen wajib diisi.';
    if ($homebaseprodi === '') $errors[] = 'Homebase Prodi wajib diisi.';
    if ($nomorhp === '') $errors[] = 'Nomor HP wajib diisi.';
    if ($namapasangan === '') $errors[] = 'Nama Pasangan wajib diisi.';
    if ($namaanak === '') $errors[] = 'Nama Anak wajib diisi.';
    if ($bidangilmudosen === '') $errors[] = 'Bidang Ilmu Dosen wajib diisi.';

    // Jika ada error, simpan old value dan redirect
    if (!empty($errors)) {
  $_SESSION['oldata'] = [
      'txtKodeDosen'   => $kodedosen,
      'txtNmDosen'     => $namadosen,
      'txtAlRmh'       => $alamatrumah,
      'txtTglDosen'    => $tanggaljadidosen,
      'txtJJA'         => $jjadosen,
      'txtProdi'       => $homebaseprodi,
      'txtNoHP'        => $nomorhp,
      'txNamaPasangan' => $namapasangan,
      'txtNmAnak'      => $namaanak,
      'txtNmKakak'     => $namakakak,
      'txtBidangIlmu'  => $bidangilmudosen
  ];


        $_SESSION['flash_error_biodata'] = implode('<br>', $errors);
        redirect_ke('index.php#biodata');
    }

    // Insert ke database
  $sql = "INSERT INTO tbl_biodata
  (ekodedosen, enamadosen, ealamatrumah, etanggaljadidosen, ejjadosen, ehomebaseprodi, enomorhp, enamapasangan, enamaanak, enamakakak, ebidangilmudosen, ecreatedat)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";


    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        $_SESSION['flash_error_biodata'] = 'Terjadi kesalahan sistem (prepare gagal).';
        redirect_ke('index.php#biodata');
    }

    // Bind dan execute
    mysqli_stmt_bind_param($stmt, "ssssssssssss", 
        $kodedosen,
        $namadosen,
        $alamatrumah,
        $tanggaljadidosen,
        $jjadosen,
        $homebaseprodi,
        $nomorhp,
        $namapasangan,
        $namaanak,
        $namakakak,
        $bidangilmudosen
    );

    if (mysqli_stmt_execute($stmt)) {
        unset($_SESSION['oldata']);
        $_SESSION['flash_sukses_biodata'] = 'Terima kasih, data Anda sudah tersimpan.';
    } else {
    $_SESSION['oldata'] = [
      'txtKodeDosen'   => $kodedosen,
      'txtNmDosen'     => $namadosen,
      'txtAlRmh'       => $alamatrumah,
      'txtTglDosen'    => $tanggaljadidosen,
      'txtJJA'         => $jjadosen,
      'txtProdi'       => $homebaseprodi,
      'txtNoHP'        => $nomorhp,
      'txNamaPasangan' => $namapasangan,
      'txtNmAnak'      => $namaanak,
      'txtNmKakak'     => $namakakak,
      'txtBidangIlmu'  => $bidangilmudosen
  ];


        $_SESSION['flash_error_biodata'] = 'Data gagal disimpan. Silakan coba lagi.';
    }

    // Simpan data untuk ditampilkan di #about
    $arrBiodata = [
      "kodedos" => $_POST["txtKodeDosen"] ?? "",
      "nama" => $_POST["txtNmDosen"] ?? "",
      "alamat" => $_POST["txtAlRmh"] ?? "",
      "tanggal" => $_POST["txtTglDosen"] ?? "",
      "jja" => $_POST["txtJJA"] ?? "",
      "prodi" => $_POST["txtProdi"] ?? "",
      "nohp" => $_POST["txtNoHp"] ?? "",
      "pasangan" => $_POST["txNamaPasangan"] ?? "",
      "anak" => $_POST["txtNmAnak"] ?? "",
      "ilmu" => $_POST["txtBidangIlmu"] ?? ""
    ];
    $_SESSION["biodata"] = $arrBiodata;

    mysqli_stmt_close($stmt);

    // Redirect kembali ke form
    header("Location: index.php#biodata");
    exit;
