<?= $this->extend('template/admin') ?>

<?= $this->section('content') ?>

<?php 

    if (isset($_GET['page_page'])) {
        $page = $_GET['page_page'];
        $jumlah = 3;
        $no = ($jumlah * $page) - $jumlah + 1;

    } else{
        $no = 1;
    }

?>


<div class="row">

    <div class="col">
        <h3><?= $judul;?></h3>
    </div>

</div>


<div class="row mt-2">

    <div class="col">
        <table class="table">

            <tr>
                <th>No</th>
                <th>pelanggan</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Status</th>
                <th>Aksi</th>
                
            </tr>

            <?php $no ?>

            <?php foreach ($pelanggan as $key => $value): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $value['pelanggan'] ?></td>
                <td><?= $value['alamat'] ?></td>
                <td><?= $value['telp'] ?></td>
                <td><?= $value['email'] ?></td>
                <?php 
                
                    if ($value['aktif']==1) {
                        $aktif = '<button type="button" class="btn btn-success">Aktif</button>';
                    } else {
                        $aktif = '<button type="button" class="btn btn-secondary">Non Aktif</button>';
                    }
                    
                ?>
                <td><a href="<?= base_url('/admin/pelanggan/update/') ?>/<?= $value['idpelanggan'] ?>/<?= $value['aktif'] ?>"><?= $aktif ?></a></td>
                <td><a href="<?= base_url('/admin/pelanggan/delete/') ?>/<?= $value['idpelanggan'] ?>"><img src="<?= base_url('/icon/trash.svg') ?>"></a></td>
            </tr>
            <?php endforeach; ?>

        </table>


        <?= $pager->links('page','bootstrap') ?>
    </div>
</div>

<?= $this->endSection() ?>




