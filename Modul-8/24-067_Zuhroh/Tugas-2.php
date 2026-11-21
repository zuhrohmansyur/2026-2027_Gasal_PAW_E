<?php
require 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: Tugas-1.php');
    exit;
}

$level = (int)$_SESSION['level'];

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
$master = [
    'barang' => [
        'judul' => 'Data Barang', 'table' => 'barang', 'pk' => 'id', 'pk_label' => 'ID',
        'fields' => [
            'kode_barang' => ['Kode Barang', 'text'],
            'nama_barang' => ['Nama Barang', 'text'],
            'harga'       => ['Harga', 'number'],
            'stok'        => ['Stok', 'number'],
            'supplier_id' => ['Supplier', 'supplier'],
        ],
    ],
    'supplier' => [
        'judul' => 'Data Supplier', 'table' => 'supplier', 'pk' => 'id', 'pk_label' => 'ID',
        'fields' => [
            'nama'   => ['Nama Supplier', 'text'],
            'telp'   => ['Telepon', 'text', 'opsional'],
            'alamat' => ['Alamat', 'text', 'opsional'],
        ],
    ],
    'pelanggan' => [
        'judul' => 'Data Pelanggan', 'table' => 'pelanggan', 'pk' => 'id', 'pk_label' => 'ID Pelanggan',
        'fields' => [
            'nama'          => ['Nama Pelanggan', 'text'],
            'jenis_kelamin' => ['Jenis Kelamin', 'jk'],
            'telp'          => ['Telepon', 'text', 'opsional'],
            'alamat'        => ['Alamat', 'text', 'opsional'],
        ],
    ],
    'user' => [
        'judul' => 'Data User', 'table' => 'user', 'pk' => 'id_user', 'pk_label' => 'ID',
        'fields' => [
            'nama'     => ['Nama', 'text'],
            'username' => ['Username', 'text'],
            'password' => ['Password', 'password'],
            'level'    => ['Level', 'level'],
        ],
    ],
];
$boleh = ['home', 'transaksi', 'laporan'];
if ($level === 1) $boleh = array_merge($boleh, array_keys($master));

$page  = $_GET['page'] ?? 'home';
$pesan = '';
if (!in_array($page, $boleh, true)) {
    $pesan = 'Anda tidak memiliki hak akses ke halaman tersebut.';
    $page  = 'home';
}

function jalankan($k, $sql, $params) {
    $s = mysqli_prepare($k, $sql);
    if ($params) mysqli_stmt_bind_param($s, str_repeat('s', count($params)), ...$params);
    return mysqli_stmt_execute($s);
}

$edit = null;
$opsiSupplier = [];
if (isset($master[$page])) {
    $cfg = $master[$page];
    $t = $cfg['table']; $pk = $cfg['pk']; $fields = $cfg['fields'];

    $col = mysqli_fetch_assoc(mysqli_query($koneksi, "SHOW COLUMNS FROM `$t` WHERE Field = '$pk'"));
    $pkAuto = stripos($col['Extra'] ?? '', 'auto_increment') !== false;
    if (!$pkAuto) $fields = [$pk => [$cfg['pk_label'], 'text']] + $fields;

    // Pilihan supplier untuk Data Barang
    if ($page === 'barang') {
        $rs = mysqli_query($koneksi, "SELECT id, nama FROM supplier ORDER BY nama");
        while ($r = mysqli_fetch_assoc($rs)) $opsiSupplier[$r['id']] = $r['nama'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $aksi = $_POST['aksi'] ?? '';
        try {
            if ($aksi === 'hapus') {
                $id = (string)($_POST['id'] ?? '');
                if ($page === 'user' && $id === (string)$_SESSION['id_user']) {
                    $pesan = 'Akun yang sedang login tidak dapat dihapus.';
                } else {
                    jalankan($koneksi, "DELETE FROM `$t` WHERE `$pk` = ?", [$id]);
                    $pesan = 'Data berhasil dihapus.';
                }
            } elseif ($aksi === 'simpan') {
                $idLama = (string)($_POST['id_lama'] ?? '');   
                $vals = [];
                $kosong = false;
                foreach ($fields as $f => $meta) {
                    if ($f === $pk && $idLama !== '') { $vals[$f] = $idLama; continue; }
                    $v = trim($_POST[$f] ?? '');
                    if ($f === 'password') {
                        $vals[$f] = ($v === '') ? null : password_hash($v, PASSWORD_DEFAULT);
                        if ($v === '' && $idLama === '') $kosong = true;
                    } else {
                        $vals[$f] = $v;
                        if ($v === '' && ($meta[2] ?? '') !== 'opsional') $kosong = true;
                    }
                }
                if ($kosong) {
                    $pesan = 'Semua field wajib diisi.';
                } else {
                    if ($idLama === '') {
                        $cols = '`' . implode('`,`', array_keys($vals)) . '`';
                        $ph   = implode(',', array_fill(0, count($vals), '?'));
                        jalankan($koneksi, "INSERT INTO `$t` ($cols) VALUES ($ph)", array_values($vals));
                        $pesan = 'Data berhasil ditambahkan.';
                    } else {
                        unset($vals[$pk]);                      
                        if (array_key_exists('password', $vals) && $vals['password'] === null) unset($vals['password']);
                        $set = implode(',', array_map(fn($c) => "`$c` = ?", array_keys($vals)));
                        $params = array_values($vals);
                        $params[] = $idLama;
                        jalankan($koneksi, "UPDATE `$t` SET $set WHERE `$pk` = ?", $params);
                        $pesan = 'Data berhasil diubah.';
                    }
                }
            }
        } catch (mysqli_sql_exception $ex) {
            if ($ex->getCode() == 1062)                          $pesan = 'Data duplikat (misalnya username atau ID sudah dipakai).';
            elseif (in_array($ex->getCode(), [1451, 1452]))      $pesan = 'Data tidak dapat diproses karena berhubungan dengan data di tabel lain.';
            else                                                 $pesan = 'Terjadi kesalahan database: ' . $ex->getMessage();
        }
    }

    if (isset($_GET['edit'])) {
        $s = mysqli_prepare($koneksi, "SELECT * FROM `$t` WHERE `$pk` = ?");
        $eid = (string)$_GET['edit'];
        mysqli_stmt_bind_param($s, 's', $eid);
        mysqli_stmt_execute($s);
        $edit = mysqli_fetch_assoc(mysqli_stmt_get_result($s));
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sistem Penjualan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="Tugas-2.php">Sistem Penjualan</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link <?= $page === 'home' ? 'active' : '' ?>" href="Tugas-2.php?page=home">Home</a></li>
        <?php if ($level === 1): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Data Master</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="Tugas-2.php?page=barang">Data Barang</a></li>
            <li><a class="dropdown-item" href="Tugas-2.php?page=supplier">Data Supplier</a></li>
            <li><a class="dropdown-item" href="Tugas-2.php?page=pelanggan">Data Pelanggan</a></li>
            <li><a class="dropdown-item" href="Tugas-2.php?page=user">Data User</a></li>
          </ul>
        </li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="Tugas-2.php?page=transaksi">Transaksi</a></li>
        <li class="nav-item"><a class="nav-link" href="Tugas-2.php?page=laporan">Laporan</a></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><?= e($_SESSION['nama']) ?></a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="Tugas-3.php">kasir</a></li>
             <li><a class="dropdown-item" href="Tugas-3.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
<?php if ($pesan): ?><div class="alert alert-info"><?= e($pesan) ?></div><?php endif; ?>

<?php if ($page === 'home'): ?>
  <h2>Selamat datang, <?= e($_SESSION['nama']) ?></h2>
  <p>Anda login sebagai <?= $level === 1 ? 'Owner' : 'Kasir' ?>.</p>

<?php elseif ($page === 'transaksi'): ?>
  <div class="card card-body mb-3">
    <h2>Transaksi</h2>
    <p>Letakkan kode halaman Transaksi dari modul sebelumnya di sini, misalnya:
       <code>include 'transaksi.php';</code></p>
  </div>

<?php elseif ($page === 'laporan'): ?>
  <div class="card card-body mb-3">
    <h2>Laporan</h2>
    <p>Letakkan kode halaman Laporan dari modul sebelumnya di sini, misalnya:
       <code>include 'laporan.php';</code></p>
  </div>

<?php elseif (isset($master[$page])): ?>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0"><?= e($cfg['judul']) ?></h2>
    <a class="btn btn-primary" href="Tugas-2.php?page=<?= e($page) ?>&tambah=1">+ Tambah</a>
  </div>

  <table class="table table-bordered table-striped">
    <tr>
      <th>No</th>
      <?php foreach ($fields as $f => $meta): if ($f === 'password') continue; ?>
        <th><?= e($meta[0]) ?></th>
      <?php endforeach; ?>
      <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    $q = mysqli_query($koneksi, "SELECT * FROM `$t` ORDER BY `$pk` ASC");
    while ($r = mysqli_fetch_assoc($q)):
    ?>
    <tr>
      <td><?= $no++ ?></td>
      <?php foreach ($fields as $f => $meta): if ($f === 'password') continue; ?>
        <td>
          <?php
          if ($meta[1] === 'level')         echo e($r[$f] == 1 ? 'Owner' : 'Kasir');
          elseif ($meta[1] === 'supplier')  echo e($opsiSupplier[$r[$f]] ?? $r[$f]);
          else                              echo e($r[$f]);
          ?>
        </td>
      <?php endforeach; ?>
      <td>
        <a class="btn btn-warning btn-sm" href="Tugas-2.php?page=<?= e($page) ?>&edit=<?= urlencode($r[$pk]) ?>">Edit</a>
        <form class="d-inline" method="post" action="Tugas-2.php?page=<?= e($page) ?>" onsubmit="return confirm('Hapus data ini?')">
          <input type="hidden" name="aksi" value="hapus">
          <input type="hidden" name="id" value="<?= e($r[$pk]) ?>">
          <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
  <div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog">
      <form class="modal-content" method="post" action="Tugas-2.php?page=<?= e($page) ?>">
        <div class="modal-header">
          <h5 class="modal-title"><?= $edit ? 'Edit' : 'Tambah' ?> <?= e($cfg['judul']) ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="aksi" value="simpan">
          <input type="hidden" name="id_lama" value="<?= e($edit[$pk] ?? '') ?>">
          <?php foreach ($fields as $f => $meta): ?>
            <label class="form-label"><?= e($meta[0]) ?></label>
            <?php if ($meta[1] === 'level'): ?>
              <select class="form-select mb-3" name="<?= e($f) ?>">
                <option value="1" <?= ($edit['level'] ?? '') == 1 ? 'selected' : '' ?>>1 - Owner</option>
                <option value="2" <?= ($edit['level'] ?? '') == 2 ? 'selected' : '' ?>>2 - Kasir</option>
              </select>
            <?php elseif ($meta[1] === 'jk'): ?>
              <select class="form-select mb-3" name="<?= e($f) ?>">
                <option value="L" <?= ($edit[$f] ?? '') === 'L' ? 'selected' : '' ?>>L - Laki-laki</option>
                <option value="P" <?= ($edit[$f] ?? '') === 'P' ? 'selected' : '' ?>>P - Perempuan</option>
              </select>
            <?php elseif ($meta[1] === 'supplier'): ?>
              <select class="form-select mb-3" name="<?= e($f) ?>">
                <option value="">-- Pilih Supplier --</option>
                <?php foreach ($opsiSupplier as $sid => $snama): ?>
                  <option value="<?= e($sid) ?>" <?= (string)($edit[$f] ?? '') === (string)$sid ? 'selected' : '' ?>><?= e($snama) ?></option>
                <?php endforeach; ?>
              </select>
            <?php elseif ($meta[1] === 'password'): ?>
              <input class="form-control mb-3" type="password" name="<?= e($f) ?>" placeholder="<?= $edit ? 'Kosongkan jika tidak diubah' : '' ?>">
            <?php else: ?>
              <input class="form-control mb-3" type="<?= e($meta[1]) ?>" name="<?= e($f) ?>" value="<?= e($edit[$f] ?? '') ?>" <?= ($f === $pk && $edit) ? 'readonly' : '' ?>>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><?= $edit ? 'Update' : 'Simpan' ?></button>
        </div>
      </form>
    </div>
  </div>
<?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (isset($master[$page]) && ($edit || isset($_GET['tambah']))): ?>
<script>
  var el = document.getElementById('modalForm');
  new bootstrap.Modal(el).show();
  el.addEventListener('hidden.bs.modal', function () {
    location.href = 'Tugas-2.php?page=<?= e($page) ?>';
  });
</script>
<?php endif; ?>
</body>
</html>