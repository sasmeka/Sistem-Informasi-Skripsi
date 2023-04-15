<?php
if (count($progress_bimbingan) == 0) {
    echo '<label class="main-chat-time"><span>Belum Terdapat Bimbingan.</span></label>';
}
foreach ($progress_bimbingan as $key) {
    if ($key->from == session()->get('ses_id')) {
?>
        <div class="media flex-row-reverse">
            <div class="main-img-user"><img alt="" src="<?= base_url() ?>/image/<?= $key->image != NULL ? $key->image : 'Profile_Default.png' ?>"></div>
            <div class="media-body">
                <div class="main-msg-wrapper right">
                    <div class="container">
                        <div class="row">
                            <div class="col"><b><?= $key->pokok_bimbingan ?></b></div>
                            <div class="col-2">
                                <a class="btn-delete" data-id='<?php echo $key->id_bimbingan; ?>' data-nim='<?= $nim ?>' data-keterangan='<?= $key->keterangan ?>' data-pokok='<?= $key->pokok_bimbingan ?>' href="#" style="color: #FFFFFF;"><i class="icon ion-md-trash"> </i></a><br>
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
            <div class="main-img-user online"><img alt="" src="<?= base_url() ?>/image/<?= $key->image != NULL ? $key->image : 'Profile_Default.png' ?>"></div>
            <div class="media-body">
                <div class="main-msg-wrapper left">
                    <div class="container">
                        <div class="row">
                            <div class="col"><b><?= $key->pokok_bimbingan ?></b></div>
                        </div>
                    </div>
                    <hr>
                    <?= $key->keterangan ?>
                    <?php if ($key->pokok_bimbingan != NULL) { ?>
                        <hr>
                        <div class="row">
                            <?php if ($key->berkas != NULL) { ?>
                                <div class="col-auto">
                                    <form action="<?= base_url() ?>download_berkas_bimbingan" method="POST" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_bimbingan" value="<?php echo $key->id_bimbingan; ?>" />
                                        <button class="btn ripple btn-primary" type="submit">Download Berkas</button>
                                    </form>
                                </div>
                            <?php } ?>
                            <div class="col-auto">
                                <button class="btn ripple btn-success btn-rev" data-id='<?php echo $key->id_bimbingan; ?>' data-nim='<?= $nim ?>' data-pokok='revisi - <?= $key->pokok_bimbingan ?>' href="#">Revisi</button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div>
                    <span><?= $key->create_at ?></span> <a href=""><i class="icon ion-android-more-horizontal"></i></a>
                </div>
            </div>
        </div>
        <!-- <div class="modal" id="modaladd<?= $key->id_bimbingan; ?>">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Masukkan Dokumen Bimbingan Proposal</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="<?= base_url() ?>tambah_bimbingan_revisi_proposal_dosen" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="modal-body">
                            <input type="hidden" name="nim" value="<?= $nim ?>">
                            <input type="hidden" name="id_bimbingan" value="<?= $key->id_bimbingan ?>">
                            <div class="form-group">
                                <label for="">Pokok Bimbingan</label>
                                <input type="teks" name="pokok_bimbingan" class="form-control" readonly id="exampleInput" value="Revisi - <?= $key->pokok_bimbingan ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Upload File</label>
                                <div class="input-group file-browser">
                                    <input type="text" class="form-control border-right-0 browse-file" placeholder="-" name="ket_berkas" readonly>
                                    <label class="input-group-btn">
                                        <span class="btn btn-default">
                                            Browse <input type="file" name="berkas" class="d-none" multiple>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan/Pesan</label>
                                <textarea name="keterangan" class="ckeditor" id="ckeditor" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit">Kirim</button>
                            <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Keluar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
    <?php } ?>
    <!-- <div class="modal" id="modaldel<?= $key->id_bimbingan ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Hapus Bimbingan</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="<?= base_url() ?>hapus_bimbingan_revisi_proposal_dosen" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_bimbingan" value="<?php echo $key->id_bimbingan; ?>" />
                    <input type="hidden" name="nim" value="<?= $nim ?>">
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
            const nim = $(this).data('nim');
            const pokok_bimbingan = $(this).data('pokok');
            const keterangan = $(this).data('keterangan');
            // Set data to Form Edit
            $('.id_bimbingan').val(id_bimbingan);
            $('.nim').val(nim);
            $('.pokok_bimbingan').html(pokok_bimbingan);
            $('.keterangan').html(keterangan);
            $('#modaldel').modal('show');
        });
    });
    $(document).ready(function() {
        $('.btn-rev').on("click", function() {
            // get data from button edit
            const id_bimbingan = $(this).data('id');
            const nim = $(this).data('nim');
            const pokok_bimbingan = $(this).data('pokok');
            // Set data to Form Edit
            $('.id_bimbingan').val(id_bimbingan);
            $('.nim').val(nim);
            $('.pokok_bimbingan').val(pokok_bimbingan);
            $('#modalrev').modal('show');
        });
    });
</script>