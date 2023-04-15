<?php
foreach ($dosen_penguji as $key2) {
    if ($key2->nip == $how) {
        $image_dosen = $key2->image != NULL ? $key2->image : 'Profile_Default.png';
        $pembimbing = "Penguji $key2->sebagai";
        $nama_dosen = "$key2->gelardepan $key2->nama, $key2->gelarbelakang";
    }
}
if (count($progress_bimbingan) == 0) {
    echo '<label class="main-chat-time"><span>Anda Belum Melakukan Bimbingan.</span></label>';
}
foreach ($progress_bimbingan as $key) {
    if ($key->from == session()->get('ses_id')) {
?>
        <div class="media flex-row-reverse">
            <div class="main-img-user"><img alt="" src="<?= base_url() ?>/image/<?= $key->image ?>"></div>
            <div class="media-body">
                <div class="main-msg-wrapper right">
                    <div class="container">
                        <div class="row">
                            <div class="col"><b><?= $key->pokok_bimbingan ?></b></div>
                            <div class="col-2">
                                <a class="btn-delete" data-id='<?php echo $key->id_bimbingan; ?>' data-nip='<?= $how ?>' data-keterangan='<?= $key->keterangan ?>' data-pokok='<?= $key->pokok_bimbingan ?>' href="#" style="color: #FFFFFF;"><i class="icon ion-md-trash"> </i></a><br>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?= $key->keterangan ?>
                    <?php if ($key->berkas != NULL) { ?>
                        <hr>
                        <form action="<?= base_url() ?>download_berkas_bimbingan" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_bimbingan" value="<?php echo $key->id_bimbingan; ?>" />
                            <button class="btn ripple btn-secondary" type="submit">Download Berkas</button>
                        </form>
                    <?php } ?>
                </div>
                <div>
                    <span><?= $key->create_at ?> - (<?= $key->status_baca == 'dibaca' ? 'Dibaca' : 'Terkirim' ?>)</span> <a href=""><i class="icon ion-android-more-horizontal"></i></a>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="media">
            <div class="main-img-user online"><img alt="" src="<?= base_url() ?>/image/<?= $image_dosen ?>"></div>
            <div class="media-body">
                <div class="main-msg-wrapper left">
                    <div class="container">
                        <div class="row">
                            <div class="col"><b><?= $key->pokok_bimbingan ?></b></div>
                            <!-- <div class="col-2"><a data-bs-target="#modaldel<?= $key->id_bimbingan ?>" data-bs-toggle="modal" href="#" style="color: #1E90FF;"><i class="icon ion-md-trash"> </i></a><br></div> -->
                        </div>
                    </div>
                    <hr>
                    <?= $key->keterangan ?>
                    <?php if ($key->berkas != NULL) { ?>
                        <hr>
                        <form action="<?= base_url() ?>download_berkas_bimbingan" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_bimbingan" value="<?php echo $key->id_bimbingan; ?>" />
                            <button class="btn ripple btn-primary" type="submit">Download Berkas</button>
                        </form>
                    <?php } ?>
                </div>
                <div>
                    <span><?= $key->create_at ?></span> <a href=""><i class="icon ion-android-more-horizontal"></i></a>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- <div class="modal" id="modaldel<?= $key->id_bimbingan ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Hapus Bimbingan</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="<?= base_url() ?>hapus_bimbingan_revisi_proposal" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_bimbingan" value="<?php echo $key->id_bimbingan; ?>" />
                    <input type="hidden" name="nip" value="<?= $how ?>">
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus <b><?= $key->pokok_bimbingan ?></b> ini ?
                        <p class="mt-3"><?= $key->keterangan ?></p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-danger" type="submit">Hapus</button>
                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Keluar</button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->
<?php } ?>
<script>
    $(document).ready(function() {
        $('.btn-delete').on("click", function() {
            // get data from button edit
            const id_bimbingan = $(this).data('id');
            const nip = $(this).data('nip');
            const pokok_bimbingan = $(this).data('pokok');
            const keterangan = $(this).data('keterangan');
            // Set data to Form Edit
            $('.id_bimbingan').val(id_bimbingan);
            $('.nip').val(nip);
            $('.pokok_bimbingan').html(pokok_bimbingan);
            $('.keterangan').html(keterangan);
            $('#modaldel').modal('show');
        });
    });
</script>