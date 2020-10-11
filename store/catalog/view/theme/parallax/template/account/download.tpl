<?php echo $header; ?>
   <!--  breadcrumb -->
            <section class="breadcrumb-area padding-top-product">
                <div class="container">
                    <div class="breadcrumb breadcrumb-box">
                        <ul>
                            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                            <li><a href="<?php echo $breadcrumb['href']; ?>"><span ><span><?php echo $breadcrumb['text']; ?></a></li>
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
                        <div class="col-main">
                            <!--  login-->
                            <section class="account-login-area">
                                <div class="login-area">
                                    <div class="page-title margin-buttom-product"><span><?php echo $heading_title; ?></span></div>
                                   <div id="content" ><?php echo $content_top; ?>
      <?php if ($downloads) { ?>
      <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-right"><?php echo $column_order_id; ?></td>
            <td class="text-left"><?php echo $column_name; ?></td>
            <td class="text-left"><?php echo $column_size; ?></td>
            <td class="text-left"><?php echo $column_date_added; ?></td>
            <td></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($downloads as $download) { ?>
          <tr>
            <td class="text-right"><?php echo $download['order_id']; ?></td>
            <td class="text-left"><?php echo $download['name']; ?></td>
            <td class="text-left"><?php echo $download['size']; ?></td>
            <td class="text-left"><?php echo $download['date_added']; ?></td>
            <td><a href="<?php echo $download['href']; ?>" data-toggle="tooltip" title="<?php echo $button_download; ?>" class="btn btn-primary"><i class="fa fa-cloud-download"></i></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
                                </div>
                            </section>
                            <!-- / login -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- / login -->

<?php echo $footer; ?>