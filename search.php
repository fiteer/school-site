<?php
ob_start();
session_start();

$pageTitle = 'Search';

include 'init.php';
include 'config.php';



?>

<div class="container view-item ">
    <div class="row col-items ">

        <?php 
            @$search = trim(strip_tags($_GET['search']));
            if(isset($_GET['do']) && $_GET['do'] == 'query'){
                if(empty($search)){
                    echo "<div class='alert alert-danger'>plase inter 4 chara</div>";
                }elseif(strlen($search)>= 10 && strlen($search) <=3){
                    echo "<div class='alert alert-danger'>plase inter 4 chara</div>";
                }else{
                    $data = mysqli_query($conn, "SELECT * FROM techers WHERE firstname like '%$search%'");                    
                    $num = mysqli_num_rows($data);
                    if($num ==0){
                        $TheMsg = "<div class='alert alert-danger'>Not found </div>";
                            redirectHome($TheMsg, 'back');
                    }else{
                        while($rows = mysqli_fetch_assoc($data)){
                            ?>
                        
                            <div class="card-items search">
                                <div class="front">
                                    <div class='img-items'>
                                        <img src="layout/image/37183_img.jpg" alt='' class='img-tops'>
                                    </div>                            
                                    <ul class='list-items-s'>
                                        <li>Full Name: <span><a href='techer.php?userid=<?php echo $rows['t_id']?>'><i class='fa fa-user'></i> <?php echo $rows['firstname'] . " " .$rows['firstname']?></a></span></li>
                                        <li>Email: <span><i class='fa fa-email'></i> <?php echo $rows['email']?></span></li>
                                        <li>Subject: <span><i class='fa fa-book'></i> <?php echo $rows['subject']?></span></li>
                                        <li>Experiences: <span><i class='fa fa-book'></i> <?php echo $rows['experiences']?></span></li>
                                    </ul>        
                                </div>
                            </div>
    
                        <?php 
                        }
                    }
                }
            }



echo '
                <form action="search.php" method="GET">
                    <input type="text" class="form-control" name="search" placeholder="Search for Techer"/>
                    <input type="submit" class="submit" value="search">
                    <input type="hidden" name="do" value="query">
                </form>';
?>
                

    </div>
    <div class="row col-items ">

        <?php 
            @$post = trim(strip_tags($_GET['post']));
            if(isset($_GET['po']) && $_GET['po'] == 'query'){
                if(empty($post)){
                    echo "<div class='alert alert-danger'>plase inter 4 chara</div>";
                }elseif(strlen($post)>= 10 && strlen($post) <=3){
                    echo "<div class='alert alert-danger'>plase inter 4 chara</div>";
                }else{
                    $posts = mysqli_query($conn, "SELECT * FROM posts WHERE title like '%$post%'");                    
                    $nums = mysqli_num_rows($posts);
                    if($nums ==0){
                        $TheMsg = "<div class='alert alert-danger'>Not found </div>";
                            redirectHome($TheMsg, 'back');
                    }else{
                        while($row = mysqli_fetch_assoc($posts)){
                            ?>
                        
                            <div class="card-items search">
                            
                                <div class="front">
                                    <div class='img-items'>
                                        <img src="layout/image/8SCENE.png" alt='' class='img-tops'>
                                    </div>                            
                                    <ul class='list-items-s'>
                                        <li>Title: <span><a href='profile.php?postid=<?php echo $row['post_ID']?>'><i class='fa fa-user'></i> <?php echo $row['title']?></a></span></li>
                                        <li>Objective: <span><i class='fa fa-email'></i> <?php echo $row['objective']?></span></li>
                                        <li>Days Avalible: <span><i class='fa fa-book'></i> <?php echo $row['days_avalible']?></span></li>
                                        <li>Timely Time: <span><i class='fa fa-book'></i> <?php echo $row['timely_time']?></span></li>
                                        <li>Price: <span><i class='fa fa-book'></i> <?php echo $row['price']?></span></li>
                                    </ul>        
                                </div>
                            </div>
    
                        <?php 
                        }
                    }
                }
            }



echo '
                <form action="search.php" method="GET">
                    <input type="text" class="form-control" name="post" placeholder="Search for Post" />
                    <input type="submit" class="submit" value="search">
                    <input type="hidden" name="po" value="query">
                </form>';
?>
                

    </div>
    <div class="row col-items ">

        <?php 
            @$sub = trim(strip_tags($_GET['sub']));
            if(isset($_GET['doo']) && $_GET['doo'] == 'query'){
                if(empty($sub)){
                    echo "<div class='alert alert-danger'>plase inter 4 chara</div>";
                }elseif(strlen($sub)>= 10 && strlen($sub) <=3){
                    echo "<div class='alert alert-danger'>plase inter 4 chara</div>";
                }else{
                    $subs = mysqli_query($conn, "SELECT * FROM
                    `subjects` s
                    INNER JOIN
                    `techers` t 
                    WHERE s.techer_id = t.t_id
                    AND  sub_name like '%$sub%'
                    ORDER BY post_ID DESC");                   
                    $subjects = mysqli_num_rows($subs);
                    if($subjects ==0){
                        $TheMsg = "<div class='alert alert-danger'>Not found </div>";
                            redirectHome($TheMsg, 'back');
                    }else{
                        while($subject = mysqli_fetch_assoc($subs)){
                            ?>
                        
                            <div class="card-items search">
                            
                                <div class="front">
                                    <div class='img-items'>
                                        <img src="layout/image/8SCENE.png" alt='' class='img-tops'>
                                    </div>                            
                                    <ul class='list-items-s'>
                                        <li>Name: <span><a href='techer.php?userid=<?php echo $subject['t_id']?>'><i class='fa fa-user'></i> <?php echo $subject['sub_name']?></a></span></li>
                                        <li>Techer: <span><a href='techer.php?userid=<?php echo $subject['t_id']?>'><i class='fa fa-user'></i> <?php echo $subject['firstname']?></a></span></li>
                                     </ul>        
                                </div>
                            </div>
    
                        <?php 
                        }
                    }
                }
            }



echo '
                <form action="search.php" method="GET">
                    <input type="text" class="form-control" name="sub" placeholder="Search for Post" />
                    <input type="submit" class="submit" value="search">
                    <input type="hidden" name="doo" value="query">
                </form>';
?>
                

    </div>
</div> 

<?php
include $tepl . 'footer.php';
ob_end_flush();
?>