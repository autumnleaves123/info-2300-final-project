<h2>Update</h2>

<?php

$sidebar_pages = ["admin"=>"Feed",
					"admin-board"=>"Eboard",
					"admin-gallery"=>"Gallery",
					"admin-resources"=>"Resources"];

foreach ($sidebar_pages as $page=>$page_name) {

	if ($current_admin_page == $page) {
		echo "<a class='admin-current-page' href='" . $page . ".php'" . ">" . $page_name . "</a>";
	} else {
		echo "<a href='" . $page . ".php'>" . $page_name . "</a>";
	}
}

?>

<form id="logout-form" action="admin.php" method="POST">
	<button id="logout-form-button" type="submit" name="logout-button">Log Out</button>
</form>
