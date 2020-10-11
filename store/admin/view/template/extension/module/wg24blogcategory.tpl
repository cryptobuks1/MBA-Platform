<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-banner" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
           <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-html" class="form-horizontal">     
               <div class="row">  
               <div class="col-md-5">
                <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left">
                   Cate Name
                   </td>
                  <td class="text-right">Action</td>
                </tr>
              </thead>
              <tbody>
             <?php foreach($showcat as $cat){ ?> 
                <tr>
                  <td class="text-left"><?php echo $cat['title'] ?></td>
                  <td class="text-right"><a href="<?php echo $cat['cateDelete'] ?>" onclick="confirm('Are you sure?')"  data-toggle="tooltip" title="Delete" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><a href="<?php echo $cat['cateEdit'] ?>" data-toggle="tooltip" title="Edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                  <?php } ?>
              </tbody>
            </table>
          </div>
         </div>
                   <div class="col-md-7">
          <div class="tab-pane">
            <ul class="nav nav-tabs" id="language">
              <?php foreach ($languages as $language) { ?>
              <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
              <?php } ?>
            </ul>
              
            <div class="tab-content">
              <?php  foreach ($languages as $language) { ?>
              <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                <div class="form-group">
                  <label class="col-sm-12 control-label" for="input-title<?php echo $language['language_id']; ?>">Name</label>
                  <div class="col-sm-12">
                    <input type="text" name="module_description[<?php echo $language['language_id']; ?>][title]" placeholder="<?php echo $entry_title; ?>" id="input-heading<?php echo $language['language_id']; ?>" value="<?php echo isset($module_description[$language['language_id']]['title']) ? $module_description[$language['language_id']]['title'] : ''; ?>" class="form-control" />
                   <?php if (isset($error_module_title[$language['language_id']])) { ?>
                  <div class="text-danger"><?php echo $error_module_title[$language['language_id']]; ?></div>
                  <?php } ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-12 control-label" for="input-description<?php echo $language['language_id']; ?>">Description</label>
                  <div class="col-sm-12">
                    <textarea name="module_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($module_description[$language['language_id']]['description']) ? $module_description[$language['language_id']]['description'] : ''; ?></textarea>
                  </div>
                </div>
                  
              </div>
              <?php }  ?>
              
              
              
            
              <div class="form-group">
            <label class="col-sm-12 control-label" for="input-status">Parrent Category</label>
            <div class="col-sm-12">
              <select name="module[catparrent]" id="input-status" class="form-control">
               <option value="0">Root</option>
                <?php 
                foreach($allparrentcate as $cat){ $parentcat=isset($blog_cat_id) ? $blog_cat_id : ''; ?>
                <option value="<?php echo $cat['blog_cat_id'] ?>"  <?php if($cat['blog_cat_id']==$parentcat){  echo 'selected="selected"';} ?>   ><?php echo $cat['title'] ?></option>
               <?php } ?>
              </select>
            </div>
          </div>
             <div class="form-group">   
                 <a href="" id="thumb-logo" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
            <input type="hidden" name="module[catpic]" value="<?php echo isset($catpic) ? $catpic : ''; ?>" id="input-logo" />
            </div> 
              
             <div class="form-group">
                  <label class="col-sm-12 control-label" for="input-title">Meta Title</label>
                  <div class="col-sm-12">
                    <input type="text" name="module[mtitle]" placeholder="<?php echo $entry_title; ?>" id="input-heading" value="<?php echo isset($mtitle) ? $mtitle : ''; ?>" class="form-control" />
                  </div>
                </div> 
              <div class="form-group">
                  <label class="col-sm-12 control-label" for="input-title">Meta Keyword</label>
                  <div class="col-sm-12">
                      <textarea  name="module[mkeyword]" placeholder="<?php echo $entry_title; ?>" id="input-heading" ><?php echo isset($mkeyword) ? $mkeyword : ''; ?></textarea>
                  </div>
               </div>
                 <div class="form-group">
                  <label class="col-sm-12 control-label" for="input-title">Meta Description</label>
                  <div class="col-sm-12">
                      <textarea name="module[mdesc]" placeholder="<?php echo $entry_title; ?>" id="input-heading"  ><?php echo isset($mdesc) ? $mdesc : ''; ?></textarea>
                  </div>
                </div>
              
              
              <div class="form-group">
            <label class="col-sm-12 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-12">
              <select name="module[status]" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
              
             
              
            </div>
       
          </div>
          
        </div>        
       </div> 
        </form>
      </div>
    </div>
  </div>
  </div>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script>
  <style>
      .form-horizontal .control-label {
  text-align: left;
}
  </style>
     <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
<?php echo $footer; ?>
