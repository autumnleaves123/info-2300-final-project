<header>
	<div id="cudap-logo">
		<a href='index.php'><img alt="cudap logo" src="../images/cudap_logo.png"></a>
	</div>

  <nav>
    <ul>
      <?php
      $pages = ["index"=>"Home",
                "about"=>"About",
                "signchoir"=>"Sign Choir",
                "events"=>"Events",
                "gallery"=>"Gallery",
                "learn"=>"Learn",
                "contact"=>"Contact",
                "admin"=>"Admin"
              ];
      $subpages = ["aboutcudap"=>"About CUDAP",
                "meettheboard"=>"Meet the Board",
                "signs"=>"Learn Signs",
                "resources"=>"Resources"
              ];
      $hidden_pages = ["login"=>"Login"];

      foreach ($pages as $page=>$page_name){
        //create li tag that contains a hyperlink to the file named
        //condition: if current page is same as key, then add id attribute

        // TODO: make an if for logo
        // TODO: make sublevels
        // TODO: if logged in, add admin and if not, do not
        if ($current_page_id == $page) {
          echo "<li><a href='" . $page . ".php' id='current-page'" . ">" . $page_name . "</a></li>";
        } else if ($page == "about" || $page == "learn") {
          echo "<li>$page_name</li>";
        } else {
          echo "<li><a href='" . $page . ".php'>" . $page_name . "</a></li>";
        }
      }
    ?>
    </ul>
  </nav>
</header>
