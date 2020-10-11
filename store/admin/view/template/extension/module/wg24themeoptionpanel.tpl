<?php echo $header;  echo $column_left; 
?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
        <div class="panel-body" title="<?php echo  $token ?>">
       <?php echo $wg24optiondesign; ?>
      </div>
    </div>
  </div>
</div>
 
 <script type="text/javascript"  src="view/javascript/wg24options/js/custom.js"></script>
 <script type="text/javascript"  src="view/javascript/wg24options/js/demofont.js"></script> 
 <link rel="stylesheet" type="text/css" href="view/javascript/wg24options/css/default.css" media="screen"/>
<link href="view/javascript/wg24options/css/colorpicker.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript"  src="view/javascript/wg24options/js/colorpicker.js"></script>

<script type="text/javascript"  src="view/javascript/wg24options/js/medialibrary-uploader.js"></script>
<script type="text/javascript"  src="view/javascript/wg24options/js/jquery.tipsy.js"></script>
  
<?php echo $footer; ?>
