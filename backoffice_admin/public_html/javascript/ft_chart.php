<?php
require_once '../class/Auth.php';
$sess_obj=new Auth();
$sess_obj->checkUserLoged();



//require_once ("functions.php");
//require_once ("functions_as.php");
require_once '../class/Database.php';
require_once '../class/Validation.php';
require_once '../class/Tree.php';
require_once '../class/TreeView.php';
//require_once "../class/TreeViewAs.php";
//$obj_tree_view = new TreeViewAs();
$obj_tree_view=new TreeView();
$obj_tree=new Tree();
$obj_val=new Validation();



$user_id=$sess_obj->sess_user_id;

$id = $_GET["id"];



$obj=new Database();
$obj->connectDB();


if(isset($_POST['go_submit']))
{
    

$go=$_POST['go_id'];
$go=$obj_val->userNameToID($go);
$child_id = $go;
$go=getEncrypt($go);

if($user_id < $child_id)
{
$status=$obj_tree->userDownlineUser($child_id,$user_id);
if($status=="yes")
{
echo "<script>document.location.href='ft_chart.php?id=$go';</script>";
}
else
{
$go=getEncrypt($user_id);
echo "<script>document.location.href='ft_chart.php?id=$go';</script>";
}
}
else
{
$go=getEncrypt($user_id);
echo "<script>document.location.href='ft_chart.php?id=$go';</script>";
}
}

 ?>

<html>
<head>
<title>Tree view</title>
	<?php
	include 'tool_tip.php';
	 ?>

<div id="content" >

<div >
<!--style="position:absolute; left:10px; font-size: 12px;" -->
<table width ="100%" border="0">
<tr valign="top">
<td width=50px>&nbsp;&nbsp;&nbsp;
<a href="../index.php"><img src="./images/home.gif"  title="Back to homepage..."/></a>&nbsp;<b></td><td valign="middle" width=90px> <b>Back To Home</b> </td>
<td>
<img src="images/active.gif" style="border:hidden" title="Paid" align="absmiddle" width="40px" height="40px"/><b>Paid</b>&nbsp;&nbsp;&nbsp;
<img src="images/inactive.png" style="border:hidden" title="Not Paid" align="absmiddle" width="40px" height="40px"/><b>Inactive</b>&nbsp;&nbsp;&nbsp;

<img src="images/add.png" style="border:hidden" title="New One" align="absmiddle" width="24px" height="24px"/>&nbsp;<b>Vacant</b>&nbsp; <font color="#000000"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></font>&nbsp;&nbsp;
</td>
<td align="right">
<form action="ft_chart.php" method="post" onSubmit= "return validate_go(this);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" value="" name="go_id" id="go_id"><input type="submit" value="Find ID" name="go_submit"></form>
</td>
</tr>
<table>
</div>

<?php
$id_decrypt = $obj_tree_view->getDecrypt($id);
if($sess_obj->sess_user_id)
{

//$obj_tree_view->cconfigure($id);
$obj_tree_view->addtomatrix($id_decrypt,1,0);
$obj_tree_view->balancematrix();
$obj_tree_view->displaymatrix($user_id,$id);
}
?>

</div>
	
</body>
</html>

