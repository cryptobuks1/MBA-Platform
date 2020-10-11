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
			<label class="col-sm-2 control-label" for="api"><?php echo $entry_api_key; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="blocktrail_api" value="<?php echo $blocktrail_api; ?>" placeholder="<?php echo $entry_api_key; ?>" id="amazon-login-pay-merchant-id" class="form-control" />
			  <?php if ($error_api) { ?>
				  <div class="text-danger"><?php echo $error_api; ?></div>
			  <?php } ?>
			</div>
		  </div>
		  <div class="form-group required">
			<label class="col-sm-2 control-label" for="api_secret"><?php echo $entry_api_secret; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="blocktrail_api_secret" value="<?php echo $blocktrail_api_secret; ?>" placeholder="<?php echo $entry_api_secret; ?>" id="amazon-login-pay-access-key" class="form-control" />
			  <?php if ($error_api_secret) { ?>
				  <div class="text-danger"><?php echo $error_api_secret; ?></div>
			  <?php } ?>
			</div>
		  </div>
		  <div class="form-group required">
			<label class="col-sm-2 control-label" for="wallet_name"><?php echo $entry_wallet_name; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="blocktrail_wallet_name" value="<?php echo $blocktrail_wallet_name; ?>" placeholder="<?php echo $entry_wallet_name; ?>" id="amazon-login-pay-access-secret" class="form-control" />
			  <?php if ($error_wallet_name) { ?>
				  <div class="text-danger"><?php echo $error_wallet_name; ?></div>
			  <?php } ?>
			</div>
		  </div>
		  <div class="form-group required">
			<label class="col-sm-2 control-label" for="wallet_password"><?php echo $entry_wallet_password; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="blocktrail_wallet_password" value="<?php echo $blocktrail_wallet_password; ?>" placeholder="<?php echo $entry_wallet_password; ?>" id="amazon-login-pay-client-id" class="form-control" />
			  <?php if ($error_wallet_password) { ?>
				  <div class="text-danger"><?php echo $error_wallet_password; ?></div>
			  <?php } ?>
			</div>
		  </div>
                   
                  <div class="form-group">
			<label class="col-sm-2 control-label" for="mode"><?php echo $entry_mode; ?></label>
			<div class="col-sm-10">
			  <select name="blocktrail_mode" id="blocktrail_mode" class="form-control">
				<?php if ($blocktrail_mode == "live") { ?>
					<option value="live" selected='selected'><?php echo $text_live; ?></option>
				<?php } else { ?>
					<option value="live"><?php echo $text_live; ?></option>
				<?php } ?>
				<?php if ($block_chain_status == "test") { ?>
					<option value="test" selected='selected'><?php echo $text_test; ?></option>
				<?php } else { ?>
					<option value="test"><?php echo $text_test; ?></option>
				<?php } ?>
			  </select>
			</div>
		  </div>  
                  <div class="form-group">
			<label class="col-sm-2 control-label" for="blocktrail_status"><?php echo $text_status; ?></label>
			<div class="col-sm-10">
			  <select name="blocktrail_status" id="blocktrail_status" class="form-control">
				<?php if ($blocktrail_status == 1) { ?>
					<option value="1" selected='selected'><?php echo $text_enabled; ?></option>
				<?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
				<?php } ?>
				<?php if ($blocktrail_status == 0) { ?>
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
