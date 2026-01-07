<?php
session_start();
require 'koneksi.php';

// Ambil data dari tbl_biodata
$sql = "SELECT * FROM tbl_biodata ORDER BY eid DESC";
$q = mysqli_query($conn, $sql);
if (!$q) {
    die("Query error: " . mysqli_error($conn));
}

// Flash message
$flash_sukses = $_SESSION['flash_sukses'] ?? '';
$flash_error  = $_SESSION['flash_error'] ?? '';
unset($_SESSION['flash_sukses'], $_SESSION['flash_error']); 

function formatTanggal($tgl) {
    if (!$tgl) return '';
    return date('d-m-Y', strtotime($tgl));
}
?>

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

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>ID</th>
        <th>NIM</th>
        <th>Nama Lengkap</th>
        <th>Tempat Lahir</th>
        <th>Tanggal Lahir</th>
        <th>Hobi</th>
        <th>Pasangan</th>
        <th>Pekerjaan</th>
        <th>Nama Orang Tua</th>
        <th>Nama Kakak</th>
        <th>Nama Adik</th>
        <th>Aksi</th>
    </tr>

    <?php $i = 1; ?>
    <?php while ($row = mysqli_fetch_assoc($q)): ?>
        <tr>
            <td><?= $i++; ?></td>
            <td><?= $row['eid']; ?></td>
            <td><?= htmlspecialchars($row['enim']); ?></td>
            <td><?= htmlspecialchars($row['enamlengkap']); ?></td>
            <td><?= htmlspecialchars($row['etempatlahir']); ?></td>
            <td><?= htmlspecialchars($row['etanggallahir']); ?></td>
            <td><?= htmlspecialchars($row['ehobi']); ?></td>
            <td><?= htmlspecialchars($row['epasangan']); ?></td>
            <td><?= htmlspecialchars($row['epekerjaan']); ?></td>
            <td><?= htmlspecialchars($row['enamaortu']); ?></td>
            <td><?= htmlspecialchars($row['enamakakak']); ?></td>
            <td><?= htmlspecialchars($row['enamadik']); ?></td>
            <td>
                <a href="editbio.php?eid=<?= $row['eid']; ?>">Edit</a>
                <a onclick="return confirm('Hapus <?= htmlspecialchars($row['enamlengkap']); ?>?')" href="biodelete.php?eid=<?= $row['eid']; ?>">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
