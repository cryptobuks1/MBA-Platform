<?php echo $header; ?>
<!--  breadcrumb -->
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
<!--  login -->
<section class="main-page container">
    <div class="main-container col1-layout">
        <div class="main">
            <?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
            <?php } ?>
            <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
            <?php } ?>
            <div class="col-main">
                <!--  login-->
                <section class="account-login-area">
                    <div class="login-area">
                        <div class="page-title margin-buttom-product"><span><?php echo $heading_title; ?></span></div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="new-user-box">
                                    <div class="new-user-inner">
                                        <div class="new-user-content">
                                            <span class="account-title"><?php echo $text_new_customer; ?></span>
                                            <p><strong><?php echo $text_register; ?></strong></p>
                                            <p><?php echo $text_register_account; ?></p>
                                        </div>
                                    </div>
                                  <!--  <div class="button-set">
                                        <div class="pull-right">
                                            <a href="<?php echo $register; ?>" class="btn btn-button gray9-bg white"><?php echo $button_continue; ?></a>

                                        </div>
                                    </div>-->
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <div class="new-user-box">
                                    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                                        <div class="new-user-inner">
                                            <div class="new-user-content">
                                                <span class="account-title"><?php echo $text_returning_customer; ?></span>
                                                <p class="select-text"><strong><?php echo $text_i_am_returning_customer; ?></strong></p>

                                                <div class="form-group">
                                                    <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                                                    <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
                                                    <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="button-set">
                                            <div class="pull-right">
                              
                                            <input type="submit" value="<?php echo $button_login; ?>" class="btn btn-button gray9-bg white" />
                                            <?php if ($redirect) { ?>
                                            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                                            <?php } ?>
                                            </div>
                                        </div>
                                    </form>  
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- / login -->
            </div>
        </div>
    </div>
</section>
<!-- / login -->
<?php echo $footer; ?>