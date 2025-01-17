<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
	<link rel="stylesheet" href="<?= base_url('assets/css/form.css'); ?>">
</head>
<body>
    <h1>Edit Produk</h1>
    <form method="post" action="<?= base_url('produk/edit/' . $produk['id_produk']); ?>">
        <label>Nama Produk</label><br>
        <input type="text" name="nama_produk" value="<?= $produk['nama_produk']; ?>" required><br><br>

        <label>Harga</label><br>
        <input type="number" name="harga" value="<?= $produk['harga']; ?>" required><br><br>

        <label>Kategori</label><br>
        <select name="kategori_id" required>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>" <?= $produk['kategori_id'] == $k['id_kategori'] ? 'selected' : ''; ?>>
                    <?= $k['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Status</label><br>
        <select name="status_id" required>
            <?php foreach ($status as $s): ?>
                <option value="<?= $s['id_status']; ?>" <?= $produk['status_id'] == $s['id_status'] ? 'selected' : ''; ?>>
                    <?= $s['nama_status']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Update</button>
    </form>
    <br>
    <a href="<?= base_url('produk'); ?>">Kembali ke Daftar Produk</a>
</body>
</html>
