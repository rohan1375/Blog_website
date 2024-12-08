<?php
require_once('includes/bootstrap.php');

require_once('header.php');

$entries = Entry::find("SELECT * from `entries` ORDER BY date DESC LIMIT 6");
if(count($entries) > 0) {
	$lastEntry = array_shift($entries);

	$category = Category::find("SELECT * from `categories` WHERE id = :id", ['id' => $lastEntry->getCatId()]);
	$category = array_shift($category);

	echo "<h2 id='title'><a href='viewentry.php?id={$lastEntry->getId()}'> {$lastEntry->getSubject()} </a></h2><br>";
	echo "<p id='byline'>In <a href='viewcat.php?id={$category->getId()}'> {$category->getCat()} </a> - Posted on <span class='datetime'>" . date("D jS F Y g:iA", strtotime($lastEntry->getDate())) . "</span>";

	if($session->isLoggedIn()) {
		echo "<span id='edit'><a href='updateentry.php?id=" . $lastEntry->getId() . "'>edit</a></span>";
	}
	?>
    </p>

    <p id='entrybody'>
		<?php echo nl2br($lastEntry->getBody()); ?>
    </p>

    <p id='comments'>
		<?php
		$comments = Comment::find("SELECT * FROM `comments` WHERE entry_id = :entry_id", ['entry_id' => $lastEntry->getId()]);

		if(count($comments) == 0) {
			echo "No comments.";
		} else {
			echo "(<strong>" . count($comments) . "</strong>) comments: ";
			foreach($comments as $comment) {
				echo "<a href='viewentry.php?id=" . $lastEntry->getId() . "#comment" . $comment->getId() . "'>" . $comment->getName() . " </a>";
			}
		}
		?>
    </p>

    <div id='prev'>
        <ul>
			<?php
			foreach($entries as $entry) {
				echo "<li><a href='viewentry.php?id=" . $entry->getId() . "'>" . $entry->getSubject() . "</a></li>";
			}
			?>
        </ul>
    </div>
	<?php
} else {
	echo "<p>No entries</p>";
}

require_once('footer.php');
?>