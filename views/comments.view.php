<form action="<?= ROOT ?>/comments/" method="post">
	<div class="form-group col-sm-6">
		<label for="subject">Subject</label>
		<input type="text" name="subject" id="subject" value="<?= isset($_POST['subject']) ? $_POST['subject'] : null ?>" class="form-control">
	</div>

	<div class="form-group col-sm-6">
		<label for="comment">Comment</label>
		<textarea name="descr" class="form-control" id="comment"><?= isset($_POST['comment']) ? $_POST['comment'] : null ?></textarea>
	</div>

	<div class="form-group col-sm-6">
		<input type="submit" name="cmntSubmit" value="Submit" class="btn btn-primary">
	</div>
</form>

<div class="clear"></div>

<?php
	if ($cmntsQuery) {
		foreach ($cmntsQuery as $comment) {
			echo "<div class='comment'>";
			echo "<h3>".$comment->Subject."</h3>";
			echo "<span class='comment-date'>".date("D jS M", $comment->Date)."</span>";
			echo "<div class='clear cmntsep'></div>";
			echo "<p>".$comment->Description."</p>";
			echo "</div>";
		}
	} else {
		echo "<h2>There are no comments to display yet!</h2>";
	}
?>

<div class="clear"></div>

<a href="<?= ROOT ?>" class="btn btn-primary">Go back</a>