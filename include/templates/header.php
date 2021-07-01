<!DOCTYPE html>
<html>
    <head>
         <meta charset="UTF-8" />
         <title><?php getTitle(); ?></title>
         <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css">
         <link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css">
         <link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css">
         <link rel="stylesheet" href="<?php echo $css ?>control.css">
    </head>
<body>
<div class="upper-bar">
     <div class="container">
          <?php
               if(isset($_SESSION['user'])){
                    //echo "Welcom: " . $_SESSION['user']. " ";

                    // echo "<a href='profile.php'>My Profile</a>";
                    ?>
                    <div class="navbar navbar-expand-lg session-user">
                         <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                              <img src="layout/image/37183_img.jpg" class="img-thumbnail img-circle" alt="" />
                              <li class="nav-item dropdown">
                                   <a class="btn btn-default  nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                   <?php echo $sessionUser ?>
                                   </a>
                                   <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                                        <?php 
                                             if(isset($_SESSION['tid']) || isset($_SESSION['gid'])){
                                                  echo '<li><a class="dropdown-item" href="newad.php">New Post</a></li>';
                                             }else{
                                                  echo '';
                                             }
                                             if(isset($_SESSION['gid'])){
                                                  echo '<li><a class="dropdown-item" href="admin.php">Dashbord</a></li>';
                                             }else{
                                                  echo '';
                                             }
                                             if(isset($_SESSION['sid'])){
                                                  echo '<li><a class="dropdown-item" href="messStudent.php?userid='.$_SESSION['sid'].'">My Message</a></li>';
                                             }else{
                                                  echo '<li><a class="dropdown-item" href="messTecher.php">My message</a></li>';
                                             }
                                        ?>
                                        <li><a class="dropdown-item confirm" href="logout.php">Logout</a></li>
                                   </ul>
                              </li>
                         </ul>
                    </div>
                    <?php

               }else{ ?>

                    <a href="login.php">
                         <span class="login-header pull-right"><p>Login</p><h3>or</h3><p>Registre</p></span>
                    </a>

          <?php }?>
     </div>
</div>
