<header>
  <nav>
    <ul id="nav">
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

      // make an if for
      if ($current_page_id == $page) {
        echo "<li><a href='" . $page . ".php' id='current_page'" . ">" . $page_name . "</a></li>";
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
