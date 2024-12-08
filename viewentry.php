<?php
require_once('includes/bootstrap.php');

require_once("header.php");

if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
	header("Location: index1.php");
}
$validId = $_GET['id'];

if(isset($_POST['submit'])) {
	$_POST['name'] = addslashes($_POST['name']);
	$_POST['comment'] = addslashes($_POST['comment']);
	$comment = new Comment(0, $validId, 0, $_POST['name'], $_POST['comment']);
	$comment->create();

	header("Location: {$_SERVER['SCRIPT_NAME']}?id=$validId");
} else {

	$entry = Entry::find("SELECT * FROM entries WHERE id = :validId ORDER BY date DESC LIMIT 1", ['validId' => $validId]);
	$entry = array_shift($entry);

	$category = Category::find("SELECT * FROM categories WHERE id = :id", ['id' => $entry->getCatId()]);
	$category = array_shift($category);

	echo "<h2 id='title'>" . $entry->getSubject() . "</h2><br>";
	echo "<p id='byline'>In <a href='viewcat.php?id=" . $entry->getCatId() . "'>" . $category->getCat() . "</a> - Posted on <span class='datetime'>" . date("D jS F Y g.iA", strtotime($entry->getDate())) . "</span>";

	if($session->isLoggedIn()) {
		echo "<span id='edit'><a href='updateentry.php?id=" . $entry->getId() . "'>edit</a></span>";
	}

	echo "</p>";

	echo "<p id='entrybody'>";
	echo nl2br($entry->getBody());
	echo "</p>";


	echo "<div id='comments'>";
	$comments = Comment::find("SELECT * FROM comments WHERE entry_id = :validId ORDER BY date DESC", ['validId' => $validId]);

	if(count($comments) == 0) {
		echo "<p>No comments.</p>";
	} else {
		foreach($comments as $comment) {
			echo "<a name='comment" . $comment->getId() . "'></a>\n";
			echo "<p class='commenthead'>Comment by " . $comment->getName() . " on " . date("D jS F Y g.iA", strtotime($comment->getDate())) . "</p>\n";
			echo "<p class='commentbody'>" . $comment->getComment() . "</p>\n";
		}
	}
	echo "</div>\n";

	?>
    <div id='addcomment'>
        <h3>Leave a comment</h3>

        <form action="<?php echo $_SERVER['SCRIPT_NAME'] . "?id=" . $validId; ?>" method="post">
            <table>
                <tr>
                    <td>Your name</td>
                    <td><input type="text" name="name"></td>
                </tr>
                <tr>
                    <td>Comments</td>
                    <td><textarea name="comment" rows="10" cols="50"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Add comment"></td>
                </tr>
            </table>
        </form>
    </div>


	<?php
}
require_once('footer.php');
?>