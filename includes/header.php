<header>
	<div id="cudap-logo">
		<a href='index.php'><img alt="cudap logo" src="../images/cudap_logo.png"></a>
	</div>

  <nav>
    <?php
    $top_pages = ["index"=>"Home",
              "about"=>"About",
              "signchoir"=>"Sign Choir",
              "events"=>"Events",
              "gallery"=>"Gallery",
              "learn"=>"Learn",
              "contact"=>"Contact",
              "admin"=>"Admin"
            ];

    // $about_subpages = ["aboutcudap"=>"About CUDAP", "meettheboard"=>"Meet the Board"];
		// $learn_subpages = ["signs"=>"Learn Signs", "resources"=>"Resources"];

    $hidden_pages = ["login"=>"Login"];

    foreach ($top_pages as $page=>$page_name){

      if ($page == "about") {
				?>

				<div class="dropdown <?php if ($current_page_id == 'about') { echo ("current-page");}?>">
					<a href="#" class="dropbtn" >About</a>
					<div class="dropdown-pages">
						<a href="aboutcudap.php">About CUDAP</a>
						<a href="meettheboard.php">Meet the Board</a>
					</div>
				</div>

			<?php

			} else if ($page == "learn") { ?>

				<div class="dropdown <?php if ($current_page_id == 'learn') { echo ("current-page");}?>">
					<a href="#" class="dropbtn">Learn</a>
					<div class="dropdown-pages">
						<a href="signs.php">Learn Signs</a>
						<a href="resources.php">Resources</a>
					</div>
				</div>

			<?php

			} else if ($page == $current_page_id) {

				echo "<a class='top-nav current-page' href='" . $page . ".php'" . ">" . $page_name . "</a>";

			} else {

				echo "<a class='top-nav' href='" . $page . ".php'>" . $page_name . "</a>";
			}
		}

		?>

  </nav>
</header>
