<?php
  session_start();
  require 'koneksi.php';
  require 'fungsi.php';

  $sql = "SELECT * FROM tbl_biodata ORDER BY eid DESC";
  $q = mysqli_query($conn, $sql);
  if (!$q) {
    die("Query error: " . mysqli_error($conn));
  }
?>

<?php
  $flash_sukses = $_SESSION['flash_sukses_biodata'] ?? ''; #jika query sukses
  $flash_error  = $_SESSION['flash_error_biodata'] ?? ''; #jika ada error
  #bersihkan session ini
  unset($_SESSION['flash_sukses_biodata'], $_SESSION['flash_error_biodata']); 
?>

<?php if (!empty($flash_sukses)): ?>
        <div style="padding:10px; margin-bottom:10px; 
          background:#d4edda; color:#155724; border-radius:6px;">
          <?= $flash_sukses; ?>
        </div>
<?php endif; ?>

<?php if (!empty($flash_error)): ?>
        <div style="padding:10px; margin-bottom:10px; 
          background:#f8d7da; color:#721c24; border-radius:6px;">
          <?= $flash_error; ?>
        </div>
<?php endif; ?>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>No</th>
    <th>Aksi</th>
    <th>ID</th>
    <th>kode dosen</th>
    <th>nama dosen</th>
    <th>alamat rumah</th>
    <th>tanggal jadi dosen</th>
    <th>jja dosen</th>
    <th>homebase prodi</th>
    <th>nomor hp</th>
    <th>nama pasangan</th>
    <th>nama kakak</th>
    <th>bidang ilmu dosen</th>
    <th>Created At</th>
  </tr>
  <?php $i = 1; ?>
  <?php while ($row = mysqli_fetch_assoc($q)): ?>
    <tr>
      <td><?= $i++ ?></td>
      <td>
        <a href="edit.php?eid=<?= (int)$row['eid']; ?>">Edit</a>
        <a onclick="return confirm('Hapus <?= htmlspecialchars($row['cnama']); ?>?')" href="proses_delete.php?cid=<?= (int)$row['cid']; ?>">Delete</a>
      </td>
      <td><?= $row['eid']; ?></td>
      <td><?= htmlspecialchars($row['ekodedosen']); ?></td>
      <td><?= htmlspecialchars($row['enamadosen']); ?></td>
      <td><?= htmlspecialchars($row['ealamatrumah']); ?></td>
      <td><?= htmlspecialchars($row['etanggaljadidosen']); ?></td>
      <td><?= htmlspecialchars($row['ejjadosen']); ?></td>
      <td><?= htmlspecialchars($row['ehomebaseprodi']); ?></td>
      <td><?= htmlspecialchars($row['enomorhp']); ?></td>
      <td><?= htmlspecialchars($row['enamapasangan']); ?></td>
      <td><?= htmlspecialchars($row['enamakakak']); ?></td>
      <td><?= htmlspecialchars($row['ebidangilmudosen']); ?></td>
      <td><?= htmlspecialchars($row['ecreatedat']); ?></td>
    </tr>
  <?php endwhile; ?>
</table>