<?php echo $header; ?>
<div class="bt-breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li class="b_breadcrumb"><?php echo $heading_title; ?></li>
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="container">
    <div class="row">
        <div id="content" class="col-sm-12">
            <p><?php echo $text_message; ?></p>
            <div class="clearfix pull-right">
                <a href="<?php echo $continue; ?>"><button id="button-success" class="btn btn-primary" type="button" ><?php echo $button_continue; ?></button></a>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>