<?php
function redirect_ke($url)
{
    header("Location: " . $url);
    exit();
}

function bersihkan($str)
{
    return htmlspecialchars(trim($str));
}

function tidakKosong($str)
{
    return strlen(trim($str)) > 0;
}

function formatTanggal($tgl)
{
    if (!$tgl) return '';
    $time = strtotime($tgl);
    if (!$time) return ''; // jika format salah, jangan error
    return date("d M Y", $time);
}

function validNIM($nim)
{
    $nim = trim($nim);
    if ($nim === '') return 'NIM wajib diisi.';
    if (mb_strlen($nim) < 3) return 'NIM minimal 3 karakter.';
    return '';
}

function validTanggal($tgl)
{
    if (trim($tgl) === '') return 'Tanggal Lahir wajib diisi.';
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) return 'Format Tanggal Lahir harus YYYY-MM-DD.';
    return '';
}

function tampilkanBiodata($conf, $arr)
{
    $html = "";
    foreach ($conf as $k => $v) {
        $label = $v["label"];
        $nilai = bersihkan($arr[$k] ?? '');
        $suffix = $v["suffix"];
        $html .= "<p><strong>{$label}</strong> {$nilai}{$suffix}</p>";
    }
    return $html;
}
