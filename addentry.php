<?php
require_once('includes/bootstrap.php');
require_once('header.php');


if(!$session->isLoggedIn()) {
	header("Location: index1.php");
}

if(isset($_POST['submit'])) {
	$_POST['cat']=addslashes($_POST['cat']);
	$_POST['subject']=addslashes($_POST['subject']);
	$_POST['body']=addslashes($_POST['body']);
	$entry = new Entry(0,$_POST['cat'],0,$_POST['subject'],
	$_POST['body']);
	$entry->create();
	header("Location: index1.php");
} else {
	?>
	<h1>Add New Entry</h1>
	<?php
	$categories = Category::all();
	if(count($categories) == 0) {
		echo "No Categories!";
	} else {
		?>
<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
	<table>
		<tr>
			<td>Category</td>
			<td>
				<select name="cat">
					<?php
					foreach($categories as $category){
						echo "<option value='".$category->getId()."'>"
						.$category->getCat()."</option>";
					}
				}
					?>
				</select>
			</td>
		</tr>

		<tr>
			<td>Subject</td>
			<td><input type="text" name="subject"></td>
		</tr>

		<tr>
			<td>Body</td>
			<td><textarea name="body" rows="10" cols="50"></textarea></td>
		</tr>

		<tr>
			<td></td>
			<td><input type="submit" name="submit" value="Post Entry"></td>
		</tr>
	</table>
</form>

		<?php
	}

require_once('footer.php');
?>