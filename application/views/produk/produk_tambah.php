<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
	<link rel="stylesheet" href="<?= base_url('assets/css/form.css'); ?>">
</head>
<body>

    <h1>Tambah Produk</h1>

    <form method="post" action="<?= base_url('produk/tambah'); ?>">
        <label>Nama Produk</label><br>
        <input type="text" name="nama_produk" required><br>

        <label>Harga</label><br>
        <input type="number" name="harga" required><br>

        <label>Kategori</label><br>
        <select name="kategori_id" required>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label>Status</label><br>
        <select name="status_id" required>
            <?php foreach ($status as $s): ?>
                <option value="<?= $s['id_status']; ?>"><?= $s['nama_status']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit">Simpan</button>
    </form>

    <!-- Tombol Kembali -->
    <br>
    <a href="<?= base_url('produk'); ?>">Kembali ke Daftar Produk</a>

</body>
</html>
