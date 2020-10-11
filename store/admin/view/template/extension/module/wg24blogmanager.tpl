<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $reset; ?>" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-banner').submit() : false;" data-toggle="tooltip" title="<?php echo $button_reset; ?>" class="btn btn-default"><?php echo $button_reset; ?></a>
        <a href="<?php echo $cancel; ?>"  data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><?php echo $button_cancel; ?></a>
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
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-banner">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left">
                   <?php echo $column_name; ?>
                   </td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-left"><?php echo $text_categorymodule; ?></td>
                  <td class="text-right"><a href="<?php echo $addcategory; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa fa-plus"></i></a></td>
                </tr>
                <tr>
                  <td class="text-left"><?php echo $text_Blogpost; ?></td>
                  <td class="text-right"><a href="<?php echo $addBlogpost; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa fa-plus"></i></a></td>
                </tr>
                 <tr>
                  <td class="text-left"><?php echo $text_ManageBlogpost; ?></td>
                  <td class="text-right"><a href="<?php echo $manageBlogpost; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                
                
               
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>