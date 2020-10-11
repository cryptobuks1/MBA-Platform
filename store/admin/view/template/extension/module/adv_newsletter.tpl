<?php echo $header; ?><?php echo $column_left; ?>
    <div id="content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="pull-right">
                    <button type="submit" form="form-adv_newsletter" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary btn-sm"><i class="fa fa-cog"></i></button>
                    <button type="button" data-toggle="tooltip" title="" class="btn btn-warning btn-sm" onclick="$('input[name=type]').val('filter');$('#form-adv_newsletter-status').submit()" data-original-title="Filter"><i class="fa fa-search"></i></button>
                    <button type="button" data-toggle="tooltip" title="" class="btn btn-info btn-sm" onclick="$('input[name=type]').val('status');$('#form-adv_newsletter-status').submit()" data-original-title="Save status"><i class="fa fa-retweet"></i></button>
                    <!--<button type="button" data-toggle="tooltip" title="" class="btn btn-danger btn-sm" onclick="confirm('Are you sure?') ? $('#form-adv_newsletter-status').submit() : false;" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>-->
                    <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></a>
                </div>
                <h1><?php echo $heading_title; ?></h1>
                <ul class="breadcrumb">
                    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-adv_newsletter" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                                <div class="col-sm-10">
                                    <select name="advanced_newsletter_status" id="input-status" class="form-control">
                                        <?php if ($advanced_newsletter_status) { ?>
                                            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                            <option value="0"><?php echo $text_disabled; ?></option>
                                        <?php } else { ?>
                                            <option value="1"><?php echo $text_enabled; ?></option>
                                            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Send newsletter for status</label>
                                <div class="col-sm-10">
                                    <select name="advanced_newsletter_send_for[]" class="form-control" multiple>
                                        <option value="0" <?php echo (!empty($advanced_newsletter_send_for) && in_array(0, $advanced_newsletter_send_for) ? 'selected="selected"' : '')?>>Disabled</option>
                                        <option value="1" <?php echo (!empty($advanced_newsletter_send_for) && in_array(1, $advanced_newsletter_send_for) ? 'selected="selected"' : '')?>>Enabled</option>
                                        <option value="2" <?php echo (!empty($advanced_newsletter_send_for) && in_array(2, $advanced_newsletter_send_for) ? 'selected="selected"' : '')?>>Blacklist</option>
                                        <option value="3" <?php echo (!empty($advanced_newsletter_send_for) && in_array(3, $advanced_newsletter_send_for) ? 'selected="selected"' : '')?>>Un-subscribed</option>
                                        <option value="4" <?php echo (!empty($advanced_newsletter_send_for) && in_array(4, $advanced_newsletter_send_for) ? 'selected="selected"' : '')?>>Non-verfied</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Display on frontend as</label>
                                <div class="col-sm-10">
                                    <select name="advanced_newsletter_display_as" class="form-control">
                                        <option value="normal" <?php echo (!empty($advanced_newsletter_display_as) && $advanced_newsletter_display_as == 'normal' ? 'selected="selected"' : '')?>>Normal</option>
                                        <option value="popup" <?php echo (!empty($advanced_newsletter_display_as) && $advanced_newsletter_display_as == 'popup' ? 'selected="selected"' : '')?>>Popup</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-newspaper-o"></i> <?php echo 'Email subscribed'; ?></h3>
            </div>

            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-adv_newsletter-status" class="form-horizontal">
                    <input type="hidden" name="type">
                    <div class="table-responsive">
                        <?php echo $list_html?>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
<?php echo $footer; ?>