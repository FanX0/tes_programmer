<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
	<link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
</head>
<body>
<h1>Data Produk</h1>
 <!-- Tombol Tambah Produk -->
 <a href="<?= base_url('produk/tambah'); ?>" style="margin-bottom: 10px; display: inline-block;">Tambah Produk</a>

    
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>ID Produk</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Status</th>
				<th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($produk)) : ?>
                <?php foreach ($produk as $item) : ?>
                    <tr>
                        <td><?= $item['id_produk']; ?></td>
                        <td><?= $item['nama_produk']; ?></td>
                        <td><?= $item['harga']; ?></td>
                        <td><?= $item['nama_kategori']; ?></td>
                        <td><?= $item['nama_status']; ?></td>
						<td>
                            <!-- Tombol Edit -->
                            <a href="<?= base_url('produk/edit/' . $item['id_produk']); ?>">Edit</a> |
                            
                            <!-- Tombol Delete dan Alert -->
                            <a href="<?= base_url('produk/hapus/' . $item['id_produk']); ?>" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">Tidak ada data produk.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

	
</body>
</html>
