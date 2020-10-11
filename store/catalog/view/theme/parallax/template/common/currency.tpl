<?php if (count($currencies) > 1) { ?>
<li class="list-line dropdown currency">
   <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-currency"> 
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
           <?php foreach ($currencies as $currency) { ?>
    <?php if ($currency['symbol_left'] && $currency['code'] == $code) { ?>
    <span><?php echo $currency['symbol_left']; ?> <?php echo $currency['title']; ?></span>
    <?php } elseif ($currency['symbol_right'] && $currency['code'] == $code) { ?>
     <span><?php echo $currency['symbol_right']; ?> <?php echo $currency['title']; ?></span>
    <?php } ?>
    <?php } ?>
        <i class="fa fa-angle-down"></i>
    </a>
    <ul class="dropdown-menu sfmenuffect">
        <?php foreach ($currencies as $currency) { ?>
      <?php if ($currency['symbol_left']) { ?>
      <li><button class="currency-select btn btn-link btn-block" type="button" name="<?php echo $currency['code']; ?>"><?php echo $currency['symbol_left']; ?> <?php echo $currency['title']; ?></button></li>
      <?php } else { ?>
      <li><button class="currency-select btn btn-link btn-block" type="button" name="<?php echo $currency['code']; ?>"><?php echo $currency['symbol_right']; ?> <?php echo $currency['title']; ?></button></li>
      <?php } ?>
      <?php } ?>
    </ul>
<input type="hidden" name="code" value="" />
<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>  
</li>
<?php } ?>



