<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
<table class="table table-striped table-bordered">
  <tr>
    <td style="width: 50%;"><strong><?php echo $review['author']; ?></strong></td>
    <td class="text-right"><?php echo $review['date_added']; ?></td>
  </tr>
  <tr>
    <td colspan="2"><p><?php echo $review['text']; ?></p>
       <div class="rating"> <?php for ($i = 1; $i <= 5; $i++) { ?>
      <?php if ($review['rating'] < $i) { ?>
       <span class="star-o"></span>
      <?php } else { ?>
     <span class="star active"></span>
      <?php } ?>
      <?php } ?>   </div></td>
  </tr>
</table>
<?php } ?>
<div class="text-right"><?php echo $pagination; ?></div>
<?php } else { ?>
<p><?php echo $text_no_reviews; ?></p>
<?php } ?>

