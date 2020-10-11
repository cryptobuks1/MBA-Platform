<?php echo $header; ?>
<style>
#block1:hover {
  color: yellow;
}
#block2:hover {
  color: yellow;
}
</style>
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
        <div id="content" class="col-sm-12" style="min-height:300px !important;">
           <form class="form-horizontal" name="domesticForm" role="form" action="index.php?route=register/type" method="post">
           <!-- <table><tr>
                        <td>User Type</td></tr>
                    <tr>
                        <td style="">
                        <input type="radio" name="reg_type" value="business" checked="checked" id="yesCheck" />Business Affilite </td><td>
                        <input type="radio" name="reg_type" value="customer" id="noCheck" />Customer</td>
                         </tr>
                         <tr>
                             <td colspan="5">
                                 
                             </td>
                             <td>
                                 <div class="buttons">
        <div class="">
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
        </div>
    </div>
                             </td>
                         </tr>
            </table>-->
           
           <div class="row">
               <div class="col-sm-5"  style="margin: 45px !important;">
               <div style="text-align:center;border-radius:20px 20px 0px 0px;background-color: #060606;min-height: 250px;">
                   <div style="min-height: 180px;color: #b9b9b9;padding-top: 5px !important;"><b><h3> Business Affiliate </h3></b>
                       <div id="block1" style='margin-top: 35px;color: #b9b9b9;'>  Be a Business Affiliate</div>
                   </div>
                   
                
               </div> 
               
                     <input type="submit" name="business" value="<?php echo 'Register Now'; ?>" class="btn btn-primary1" style="background-color:#f7db9e;border-color:#f7db9e;min-width:458px !important;border-radius:0px 0px 20px 20px;"/>
             </div>
             <div class="col-sm-5" style="margin: 45px !important;">
               <div  style="text-align:center;border-radius:20px 20px 0px 0px;background-color: #060606;min-height: 250px;">
                   <div style="min-height: 180px;color: #b9b9b9;padding-top: 5px !important;"><b> <h3>Customer </h3></b>
                       <div id="block2" style='margin-top: 35px;color: #b9b9b9;'> Be a Customer</div>
                   </div>
                  
               </div>
                
                    <input type="submit" name="customer" value="<?php echo 'Register Now'; ?>" class="btn btn-primary1" style="background-color:#f7db9e;border-color:#f7db9e;min-width:458px !important;border-radius:0px 0px 20px 20px;" />
                </div>
           </div>
           
        </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>