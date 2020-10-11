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
			<label class="col-sm-2 control-label" for="wallet_id"><?php echo $entry_wallet_id; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="bitgo_wallet_id" value="<?php echo $bitgo_wallet_id; ?>" placeholder="<?php echo $entry_wallet_id; ?>" id="amazon-login-pay-merchant-id" class="form-control" />
			  <?php if ($error_wallet_id) { ?>
				  <div class="text-danger"><?php echo $error_wallet_id; ?></div>
			  <?php } ?>
			</div>
		  </div>
		  <div class="form-group required">
			<label class="col-sm-2 control-label" for="token"><?php echo $entry_token; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="bitgo_token" value="<?php echo $bitgo_token; ?>" placeholder="<?php echo $entry_token; ?>" id="amazon-login-pay-access-key" class="form-control" />
			  <?php if ($error_token) { ?>
				  <div class="text-danger"><?php echo $error_token; ?></div>
			  <?php } ?>
			</div>
		  </div>
		  <div class="form-group required">
			<label class="col-sm-2 control-label" for="wallet_passphrase"><?php echo $entry_wallet_passphrase; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="bitgo_wallet_passphrase" value="<?php echo $bitgo_wallet_passphrase; ?>" placeholder="<?php echo $entry_wallet_passphrase; ?>" id="amazon-login-pay-access-secret" class="form-control" />
			  <?php if ($error_wallet_passphrase) { ?>
				  <div class="text-danger"><?php echo $error_wallet_passphrase; ?></div>
			  <?php } ?>
			</div>
		  </div>
                  <div class="form-group">
			<label class="col-sm-2 control-label" for="mode"><?php echo $entry_mode; ?></label>
			<div class="col-sm-10">
			  <select name="bitgo_mode" id="bitgo_mode" class="form-control">
				<?php if ($bitgo_mode == "live") { ?>
					<option value="live" selected='selected'><?php echo $text_live; ?></option>
				<?php } else { ?>
					<option value="live"><?php echo $text_live; ?></option>
				<?php } ?>
				<?php if ($bitgo_mode == "test") { ?>
					<option value="test" selected='selected'><?php echo $text_test; ?></option>
				<?php } else { ?>
					<option value="test"><?php echo $text_test; ?></option>
				<?php } ?>
			  </select>
			</div>
		  </div>  
                  <div class="form-group">
			<label class="col-sm-2 control-label" for="bitgo_status"><?php echo $text_status; ?></label>
			<div class="col-sm-10">
			  <select name="bitgo_status" id="bitgo_status" class="form-control">
				<?php if ($bitgo_status == 1) { ?>
					<option value="1" selected='selected'><?php echo $text_enabled; ?></option>
				<?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
				<?php } ?>
				<?php if ($bitgo_status == 0) { ?>
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
