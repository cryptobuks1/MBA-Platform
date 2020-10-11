<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
	<div class="container-fluid">
	  <div class="pull-right">
		<button type="submit" form="form-amazon-login-pay" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
	  <div class="panel-body">
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-amazon-login-pay" class="form-horizontal">
		
		  <div class="form-group required">
			<label class="col-sm-2 control-label" for="xPub"><?php echo $entry_xPub; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="block_chain_xPub" value="<?php echo $xPub; ?>" placeholder="<?php echo $entry_xPub; ?>" id="amazon-login-pay-merchant-id" class="form-control" />
			  <?php if ($error_xPub) { ?>
				  <div class="text-danger"><?php echo $error_xPub; ?></div>
			  <?php } ?>
			</div>
		  </div>
		  <div class="form-group required">
			<label class="col-sm-2 control-label" for="api_key"><?php echo $entry_api_key; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="block_chain_api_key" value="<?php echo $api_key; ?>" placeholder="<?php echo $entry_api_key; ?>" id="amazon-login-pay-access-key" class="form-control" />
			  <?php if ($error_api_key) { ?>
				  <div class="text-danger"><?php echo $error_api_key; ?></div>
			  <?php } ?>
			</div>
		  </div>
		  <div class="form-group required">
			<label class="col-sm-2 control-label" for="main_password"><?php echo $entry_main_password; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="block_chain_main_password" value="<?php echo $main_password; ?>" placeholder="<?php echo $entry_main_password; ?>" id="amazon-login-pay-access-secret" class="form-control" />
			  <?php if ($error_main_password) { ?>
				  <div class="text-danger"><?php echo $error_main_password; ?></div>
			  <?php } ?>
			</div>
		  </div>
		  <div class="form-group required">
			<label class="col-sm-2 control-label" for="second_password"><?php echo $entry_second_password; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="block_chain_second_password" value="<?php echo $second_password; ?>" placeholder="<?php echo $entry_second_password; ?>" id="amazon-login-pay-client-id" class="form-control" />
			  <?php if ($error_second_password) { ?>
				  <div class="text-danger"><?php echo $error_second_password; ?></div>
			  <?php } ?>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 control-label" for="secret"><?php echo $entry_secret; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="block_chain_secret" value="<?php echo $secret; ?>" placeholder="<?php echo $entry_secret; ?>" id="amazon-login-pay-client-secret" class="form-control" />
			  <?php if ($error_secret) { ?>
				  <div class="text-danger"><?php echo $error_secret; ?></div>
			  <?php } ?>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-2 control-label" for="fee"><?php echo $entry_fee; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="block_chain_fee" value="<?php echo $fee; ?>" placeholder="<?php echo $entry_fee; ?>" id="amazon-login-pay-client-secret" class="form-control" />
			  <?php if ($error_fee) { ?>
				  <div class="text-danger"><?php echo $error_fee; ?></div>
			  <?php } ?>
			</div>
		  </div>
                  <div class="form-group">
			<label class="col-sm-2 control-label" for="block_chain_status"><?php echo $text_status; ?></label>
			<div class="col-sm-10">
			  <select name="block_chain_status" id="block_chain_status" class="form-control">
				<?php if ($block_chain_status == 1) { ?>
					<option value="1" selected='selected'><?php echo $text_enabled; ?></option>
				<?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
				<?php } ?>
				<?php if ($block_chain_status == 0) { ?>
					<option value="0" selected='selected'><?php echo $text_disabled; ?></option>
				<?php } else { ?>
					<option value="0"><?php echo $text_disabled; ?></option>
				<?php } ?>
			  </select>
			</div>
		  </div>  
		</form>
	  </div>
	</div>
  </div>
  
</div>
<?php echo $footer; ?>
