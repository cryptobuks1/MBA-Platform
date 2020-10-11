<?php echo $header; ?>
<!-- breadcrumb -->
<section class="breadcrumb-area padding-top-product">
    <div class="container">
        <div class="breadcrumb breadcrumb-box">
            <ul>
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><span ><span><?php echo $breadcrumb['text']; ?></span></span></a></li>
                <?php } ?>

            </ul>
        </div>
    </div>
</section>
<!-- / breadcrumb -->
<!-- Contact -->
<section class="main-page container">
    <div class="main-container col1-layout">
        <div class="main">
            <div class="col-main" id="content">
                <section class="contact-us-area">
                    <div class="contact-box">
                        <div class="page-title margin-buttom-product">
                            <span><?php echo $heading_title; ?>
                            </span>
                        </div>

                        <!-- contact details -->
                        <div class="contact-details">
                            <div class="page-title margin-buttom-product"><span><?php echo $text_location; ?></span></div>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <?php if ($image) { ?>
                                        <div class="col-sm-3"><img src="<?php echo $image; ?>" alt="<?php echo $store; ?>" title="<?php echo $store; ?>" class="img-thumbnail" /></div>
                                        <?php } ?>
                                        <div class="col-sm-3"><strong><?php echo $store; ?></strong><br />
                                            <address>
                                                <?php echo $address; ?>
                                            </address>
                                            <?php if ($geocode) { ?>
                                            <a href="https://maps.google.com/maps?q=<?php echo urlencode($geocode); ?>&hl=<?php echo $geocode_hl; ?>&t=m&z=15" target="_blank" class="btn btn-info"><i class="fa fa-map-marker"></i> <?php echo $button_map; ?></a>
                                            <?php } ?>
                                        </div>
                                        <div class="col-sm-3"><strong><?php echo $text_telephone; ?></strong><br>
                                            <?php echo $telephone; ?><br />
                                            <br />
                                            <?php if ($fax) { ?>
                                            <strong><?php echo $text_fax; ?></strong><br>
                                            <?php echo $fax; ?>
                                            <?php } ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <?php if ($open) { ?>
                                            <strong><?php echo $text_open; ?></strong><br />
                                            <?php echo $open; ?><br />
                                            <br />
                                            <?php } ?>
                                            <?php if ($comment) { ?>
                                            <strong><?php echo $text_comment; ?></strong><br />
                                            <?php echo $comment; ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($locations) { ?>
                            <h3><?php echo $text_store; ?></h3>
                            <div class="panel-group" id="accordion">
                                <?php foreach ($locations as $location) { ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><a href="#collapse-location<?php echo $location['location_id']; ?>" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"><?php echo $location['name']; ?> <i class="fa fa-caret-down"></i></a></h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapse-location<?php echo $location['location_id']; ?>">
                                        <div class="panel-body">
                                            <div class="row">
                                                <?php if ($location['image']) { ?>
                                                <div class="col-sm-3"><img src="<?php echo $location['image']; ?>" alt="<?php echo $location['name']; ?>" title="<?php echo $location['name']; ?>" class="img-thumbnail" /></div>
                                                <?php } ?>
                                                <div class="col-sm-3"><strong><?php echo $location['name']; ?></strong><br />
                                                    <address>
                                                        <?php echo $location['address']; ?>
                                                    </address>
                                                    <?php if ($location['geocode']) { ?>
                                                    <a href="https://maps.google.com/maps?q=<?php echo urlencode($location['geocode']); ?>&hl=<?php echo $geocode_hl; ?>&t=m&z=15" target="_blank" class="btn btn-info"><i class="fa fa-map-marker"></i> <?php echo $button_map; ?></a>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-sm-3"> <strong><?php echo $text_telephone; ?></strong><br>
                                                    <?php echo $location['telephone']; ?><br />
                                                    <br />
                                                    <?php if ($location['fax']) { ?>
                                                    <strong><?php echo $text_fax; ?></strong><br>
                                                    <?php echo $location['fax']; ?>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-sm-3">
                                                    <?php if ($location['open']) { ?>
                                                    <strong><?php echo $text_open; ?></strong><br />
                                                    <?php echo $location['open']; ?><br />
                                                    <br />
                                                    <?php } ?>
                                                    <?php if ($location['comment']) { ?>
                                                    <strong><?php echo $text_comment; ?></strong><br />
                                                    <?php echo $location['comment']; ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>

                            <!-- contact form -->
                            <div class="contact-form">
                                <div class="comment-respond padding-top">
                                    <div class="comment-respond-inner">
                                        <div class="hadding"><span><?php echo $text_contact; ?></span></div>
                                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="comment-form respond-form">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-6 comment-form-name required">
                                                    <input type="text" name="name" placeholder="<?php echo $entry_name; ?>" value="<?php echo $name; ?>" id="input-name" class="form-control border-radius" />
                                                    <?php if ($error_name) { ?>
                                                    <div class="text-danger"><?php echo $error_name; ?></div>
                                                    <?php } ?>
                                                </div>
                                                <div class="fcol-sm-6 col-md-6 col-lg-6 comment-form-email required">
                                                    <input type="text" name="email" placeholder="<?php echo $entry_email; ?>" value="<?php echo $email; ?>" id="input-email" class="form-control border-radius" />
                                                    <?php if ($error_email) { ?>
                                                    <div class="text-danger"><?php echo $error_email; ?></div>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-12 required">
                                                    <div class="comment-form-comment">
                                                        <textarea name="enquiry" rows="10" placeholder="<?php echo $entry_enquiry; ?>" id="input-enquiry" class="form-control border-radius"><?php echo $enquiry; ?></textarea>
                                                        <?php if ($error_enquiry) { ?>
                                                        <div class="text-danger"><?php echo $error_enquiry; ?></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php echo $captcha; ?>
                                            </div>
                                            <div class="form-submit  padding-top-product">
                                                <input class="btn submit-btn border-radius" type="submit" value="<?php echo $button_submit; ?>" />
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- / contact form -->
                        </div>
                        <!-- / contact details -->
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
<!-- Contact -->
<?php echo $footer; ?>
