<?php
require_once('includes/bootstrap.php');
require_once('header.php');


if(!$session->isLoggedIn()) {
	header("Location: index1.php");
}

if(isset($_POST['submit'])) {
	$category = new Category(0,$_POST['cat']);
	$category->create();

	header("Location: viewcat.php");
} else {
	?>
<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">

	<table>
		<tr>
			<td>Category</td>
			<td><input type="text" name="cat"/></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="submit" value="Add Category"/></td>
		</tr>
	</table>
</form>

	<?php
}
require_once('footer.php');
?>