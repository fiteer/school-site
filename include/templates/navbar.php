<nav class="navbar navbar-expand-lg navbar-light bg-dark">
  <div class="container">
    <a class="navbar-brand" href="Home.php"><img src="layout/image/TutorFinder1.png" alt="" srcset=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav  me-auto mb-2 mb-lg-0">
      <?php 
          $menu = array('Home.php'=>'home','about-as.php'=>'about-as','Become-A-Tutor.php'=>'Become A Tutor','posts.php'=>'posts','search.php'=>'FIND A TUTOR');
          asort($menu);
          foreach($menu as $key=>$menus){
            echo '<li class="nav-item active"><a class="nav-link "  href="'. $key .'">'. $menus . '</a></li>';
          }
      ?>
        <!-- <li class="nav-item active"><a class="nav-link "  href="Home.php">home</a></li>
        <li class="nav-item"><a class="nav-link "  href="about-as.php">about-as</a></li>
        <li class="nav-item"><a class="nav-link "  href="Become-A-Tutor.php">Become A Tutor</a></li>
        <li class="nav-item"><a class="nav-link "  href="posts.php">posts</a></li>
        <li class="nav-item"><a class="nav-link "  href="search.php">FIND A TUTOR</a></li> -->

      </ul>
    </div>
  </div>
</nav>