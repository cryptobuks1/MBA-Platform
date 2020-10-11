<?php if (count($languages) > 1) { ?>
<li class="list-line dropdown flags">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language">
   <a class="dropdown-toggle" data-toggle="dropdown"  aria-expanded="false">
    <?php foreach ($languages as $language) { ?>
    <?php if ($language['code'] == $code) { ?>
    <img src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>">
   <span><?php echo $language['name']; ?></span>
        <i class="fa fa-angle-down"></i>
    <?php } ?>
    <?php } ?>
       </a>
    <ul class="dropdown-menu sfmenuffect">
      <?php foreach ($languages as $language) { ?>
      <li><button class="btn btn-link btn-block language-select" type="button" name="<?php echo $language['code']; ?>"><img src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>" /><span><?php echo $language['name']; ?></span></button></li>
      <?php } ?>
    </ul>
  <input type="hidden" name="code" value="" />
  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
 </li>
<?php } ?>