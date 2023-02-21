<?php

use CodeIgniter\Images\Image;
?>
<?= $this->extend('Template/content') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title mb-0">Beranda Admin</h6>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="card-body">
                        <div class="vtimeline">
                            <div class="timeline-wrapper timeline-wrapper-primary">
                                <div class="timeline-badge success"><img class="timeline-image" alt="img" src="../../assets/img/faces/3.jpg"> </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h6 class="timeline-title">Validasi Usulan Topik</h6>
                                    </div>
                                    <div class="timeline-body">
                                        <p>Tolerably earnestly middleton extremely distrusts she boy now not.
                                            Add and offered prepare how cordial two promise. Greatly who affixed
                                            suppose but enquire compact prepare all put. Added forth chief trees
                                            but rooms think may.</p>
                                    </div>
                                    <div class="timeline-footer d-flex align-items-center flex-wrap">
                                        <i class="fe fe-heart  text-muted me-1"></i>
                                        <span>19</span>
                                        <span class="ms-auto"><i class="fe fe-calendar text-muted me-1"></i>19
                                            Oct 2019</span>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-wrapper timeline-inverted timeline-wrapper-secondary">
                                <div class="timeline-badge"><i class="las la-business-time"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h6 class="timeline-title">Validasi Bimbingan Proposal</h6>
                                    </div>
                                    <div class="timeline-body">
                                        <p>You have a meeting at Laborator Office Today.</p>
                                    </div>
                                    <div class="timeline-footer d-flex align-items-center flex-wrap">
                                        <i class="fe fe-heart  text-muted me-1"></i>
                                        <span>25</span>
                                        <span class="ms-auto"><i class="fe fe-calendar text-muted me-1"></i>10th
                                            Oct 2019</span>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-wrapper timeline-wrapper-info">
                                <div class="timeline-badge"><i class="las la-user-circle"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h6 class="timeline-title">Berita Acara Seminar Proposal</h6>
                                    </div>
                                    <div class="timeline-body">
                                        <p>Alpha 5 has arrived just over a month after Alpha 4 with some major
                                            feature improvements and a boat load of bug fixes.</p>
                                    </div>
                                    <div class="timeline-footer d-flex align-items-center flex-wrap">
                                        <i class="fe fe-heart  text-muted me-1"></i>
                                        <span>19</span>
                                        <span class="ms-auto"><i class="fe fe-calendar text-muted me-1"></i>5th
                                            Oct 2019</span>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-wrapper timeline-inverted timeline-wrapper-danger">
                                <div class="timeline-badge success"><img class="timeline-image" alt="img" src="../../assets/img/faces/12.jpg"> </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h6 class="timeline-title">Validasi Revisi Pasca Seminar Proposal</h6>
                                    </div>
                                    <div class="timeline-body">
                                        <p>Pianoforte principles our unaffected not for astonished travelling
                                            are particular.</p>
                                        <img src="../../assets/img/media/4.jpg" class="mb-3" alt="img">
                                    </div>
                                    <div class="timeline-footer d-flex align-items-center flex-wrap">
                                        <i class="fe fe-heart  text-muted me-1"></i>
                                        <span>19</span>
                                        <span class="ms-auto"><i class="fe fe-calendar text-muted me-1"></i>27th
                                            Sep 2017</span>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-wrapper timeline-wrapper-success">
                                <div class="timeline-badge"><i class="las la-envelope-open-text"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h6 class="timeline-title">Histori Seminar Proposal</h6>
                                    </div>
                                    <div class="timeline-body">
                                        <p>Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                            weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah
                                            plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle quora
                                            plaxo ideeli hulu weebly balihoo....</p>
                                        <a class="btn ripple btn-primary text-white mb-3">Read more</a>
                                    </div>
                                    <div class="timeline-footer d-flex align-items-center flex-wrap">
                                        <i class="fe fe-heart  text-muted me-1"></i>
                                        <span>25</span>
                                        <span class="ms-auto"><i class="fe fe-calendar text-muted me-1"></i>25th
                                            Sep 2017</span>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-wrapper timeline-inverted timeline-wrapper-warning">
                                <div class="timeline-badge success"><img class="timeline-image" alt="img" src="../../assets/img/faces/15.jpg"> </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h6 class="timeline-title">Mr. Doe shared a video</h6>
                                    </div>
                                    <div class="timeline-body">
                                        <div class="embed-responsive embed-responsive-16by9 mb-3">
                                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/XZmGGAbHqa0?rel=0&amp;controls=0&amp;showinfo=0" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                    <div class="timeline-footer d-flex align-items-center flex-wrap">
                                        <i class="fe fe-heart  text-muted me-1"></i>
                                        <span>32</span>
                                        <span class="ms-auto"><i class="fe fe-calendar text-muted me-1"></i>19th
                                            Sep 2017</span>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-wrapper timeline-wrapper-dark">
                                <div class="timeline-badge"><i class="las la-check-circle"></i></div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h6 class="timeline-title">Sarah Young accepted your friend request</h6>
                                    </div>
                                    <div class="timeline-body">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet
                                            cupiditate, delectus deserunt doloribus earum eveniet explicabo fuga
                                            iste magni maxime</p>
                                    </div>
                                    <div class="timeline-footer d-flex align-items-center flex-wrap">
                                        <i class="fe fe-heart text-muted me-1"></i>
                                        <span>26</span>
                                        <span class="ms-auto"><i class="fe fe-calendar text-muted me-1"></i>15th
                                            Sep 2017</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>