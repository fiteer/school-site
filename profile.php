<?php

session_start();

$pageTitle = 'Profile';

include 'init.php';
include 'config.php';


if(isset($_SESSION['tid']) || isset($_SESSION['gid'])){
    $getUser = $con->prepare("SELECT * FROM techers WHERE email = ?");

    $getUser->execute(array($sessionUser));

    $infoUser = $getUser->fetch();
    $userid = $infoUser['t_id'];
 ?>
    <h1 class="text-center">My Profile</h1>
    <div class="information block">
        <div class="container">
            <div class="card">
                <div class="card-header bg-primary text-white">My Information</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            <span>First Name</span> :               <?php echo $infoUser['firstname']; ?>
                        </li>
                        <li>
                            <i class="fa fa-envelope-o fa-fw"></i>
                            <span>Last Name</span> :              <?php echo $infoUser['lastname']; ?>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Email</span> :          <?php echo $infoUser['email']; ?>
                        </li>
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Favouret Category</span> : 
                        </li>
                    </ul>
                    <a href="admin.php?do=Manage" class="btn btn-default">Edit Information</a>
                </div>
            </div>
        </div>
    </div>


        <?php 
    if(isset($_SESSION['gid'])){


        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if($do == 'Manage'){
            // if(!empty($stmt)){
            $stmt = $con->prepare("SELECT 
                                        subjects.*, 
                                        posts.title, 
                                        techers.firstname 
                                    FROM 
                                    subjects 
                                    INNER JOIN 
                                    posts 
                                    ON 
                                    posts.post_ID = subjects.post_id 
                                    INNER JOIN 
                                        techers 
                                    ON 
                                    techers.t_id = subjects.techer_id
                                    ORDER BY
                                    sub_id  DESC");

            $stmt->execute();

            $items = $stmt->fetchAll();
            
            ?>

            <h1 class='text-center'>Manage subjects</h1>
            <div class='container'>
                <div class="table-responsive">
                    <table class="main-table text-center manage-members  table table-bordered">
                        <tr>
                            <td>#ID</td>
                            
                            <td>Name</td>
                            <td>post</td>
                            <td>techer</td>
                            <td>Control</td>
                        </tr>
                        <?php
                            foreach($items as $item){?>
                                <tr>
                                    <td><?php echo $item['sub_id']?></td> 
                                    <td><?php echo $item['sub_name']?></td> 
                                    <td><?php echo $item['title']?></td> 
                                    <td><?php echo $item['firstname']?></td> 
                                </tr>
                        <?php }
                        ?>
                    </table>
                </div>
                <a href="admin.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New</a>
            </div>

            <?php
            
        }elseif($do == 'Add'){ }// Add Page ?>

            <?php

        $doo = isset($_GET['doo']) ? $_GET['doo'] : 'Manage';

        if($doo == 'Manage'){
            // if(!empty($stmt)){
            $stmt = $con->prepare("SELECT 
                                        cities.*, 
                                        posts.title, 
                                        techers.firstname 
                                    FROM 
                                    cities 
                                    INNER JOIN 
                                    posts 
                                    ON 
                                    posts.post_ID = cities.post_id 
                                    INNER JOIN 
                                        techers 
                                    ON 
                                    techers.t_id = cities.techer_id
                                    ORDER BY
                                    c_id  DESC");

            $stmt->execute();

            $items = $stmt->fetchAll();
            
            ?>

            <h1 class='text-center'>Manage Cities</h1>
            <div class='container'>
                <div class="table-responsive">
                    <table class="main-table text-center manage-members  table table-bordered">
                        <tr>
                            <td>#ID</td>
                            
                            <td>Name</td>
                            <td>post</td>
                            <td>techer</td>
                            <td>Control</td>
                        </tr>
                        <?php
                            foreach($items as $item){?>
                                <tr>
                                    <td><?php echo $item['c_id']?></td> 
                                    <td><?php echo $item['c_name']?></td> 
                                    <td><?php echo $item['title']?></td> 
                                    <td><?php echo $item['firstname']?></td> 
                                </tr>
                        <?php }
                        ?>
                    </table>
                </div>
                <a href="admin.php?doo=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add New</a>
            </div>

            <?php
            
        }elseif($doo == 'Add'){ }// Add Page 

            
        
    }else{?>
        <div id="view-items" class="view-items block">
        <div class="container">
            <div class="card">
                <div class="card-header bg-primary text-white">My Items</div>
                <div class="card-body">
                    <div class="row row-cols-md-4">
                    <?php $items = mysqli_query($conn, "SELECT * FROM posts WHERE author = $userid ORDER BY post_ID DESC");


                    if(empty($items)){

                        echo "<div class='naice-message'>
                                Not Exist Ads, Create <a href='newad.php'>New Add</a>
                            </div>";

                    }else{
                        foreach($items as $item){
                            echo "<div class='ads-user'>";
                                echo "<div class='ads-items'>";
                                    
                                    echo "<span class='price-items'>" . $item['price'] . "</span>";
                                    echo "<div class='img-items'>";
                                        echo "<img src='layout/image/8SCENE.png' class='img-top' alt='' />";
                                    echo "</div>";
                                    echo "<div class='items-body'>";
                                        echo "<h3 class='title-items'>";
                                            echo "<a href='items.php?userid=" . $item['post_ID'] . "'>";
                                                echo $item['title'];
                                            echo "</a>";
                                        echo "</h3>";
                                        echo "<p class='text-items'>". $item['objective'] ."</p>";
                                        echo "<p class='date-items'>". $item['date'] ."</p>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                            
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
    }

    }?>   


 <hr class="costom-hr">
                <?php 
                $stmt = $con->prepare("SELECT
                                            `message`.*,
                                            techers.firstname,
                                            students.firstname
                                        FROM
                                            `message`
                                        INNER JOIN
                                            techers
                                        ON
                                            techers.t_id = `message`.`techer_id`
                                        INNER JOIN
                                            students
                                        ON
                                            students.S_id  = `message`.`student_id`
                                        WHERE
                                            `techer_id` = ?
                                        
                                        ORDER BY
                                            m_id DESC");
                $stmt->execute(array($userid));
                $messages = $stmt->fetchAll();
                foreach($messages as $message){
                    ?>
                     <div class="comment-box">
                        <div class="row"> 
                            <?php
                            // if($comment['Status'] == 0){
                            //     echo '<div class="col-md-10">';
                            //         echo "<p class='leads alert alert-danger'>This Comment Is Waiting Approval</p>";
                            //     echo '</div>';
                            // }else{ ?>
                                 <div class="col-md-2 text-center"> 
                                    <img src="img.png" class="img-responsive img-thumbnail img-circle" alt="" /> -->
                                    <a href='student.php?userid=<?php echo $infoUser['t_id']?>'><?php echo $message['firstname']?></a>
                                </div>
                                <div class="col-md-10">
                                    <p class='lead'><?php echo $message['message']?><p>
                                </div>
                    <?php    ?>
                        </div>
                    </div>
                    <!-- <hr class="costom-hr"> -->
               <?php }
               
                 
            ?>
        </div>
    </div>
<?php  
}elseif(isset($_SESSION['sid'])) {
    $getUser = $con->prepare("SELECT * FROM students WHERE email = ?");

    $getUser->execute(array($sessionUser));

    $infoUser = $getUser->fetch();
    $userid = $infoUser['S_id'];
?>
    <h1 class="text-center">My Profile</h1>
    <div class="information block">
        <div class="container">
            <div class="card">
                <div class="card-header bg-primary text-white">My Information</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            <span>First Name</span> :               <?php echo $infoUser['firstname']; ?>
                        </li>
                        <li>
                            <i class="fa fa-envelope-o fa-fw"></i>
                            <span>Last Name</span> :              <?php echo $infoUser['lastname']; ?>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Email</span> :          <?php echo $infoUser['email']; ?>
                        </li>
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Favouret Category</span> : 
                        </li>
                    </ul>
                    <a href="admin.php?do=Manage" class="btn btn-default">Edit Information</a>
                </div>
            </div>
        </div>
    </div>

<hr class="costom-hr">
<?php 
$stmt = $con->prepare("SELECT
                            `message`.*,
                            techers.firstname,
                            students.firstname
                        FROM
                            `message`
                        INNER JOIN
                            techers
                        ON
                            techers.t_id = `message`.`techer_id`
                        INNER JOIN
                            students
                        ON
                            students.S_id  = `message`.`student_id`
                        WHERE
                            `techer_id` = ?
                        
                        ORDER BY
                            m_id DESC");
$stmt->execute(array($userid));
$messages = $stmt->fetchAll();
foreach($messages as $message){
    ?>
     <div class="comment-box">
        <div class="row"> 
            <?php
            // if($comment['Status'] == 0){
            //     echo '<div class="col-md-10">';
            //         echo "<p class='leads alert alert-danger'>This Comment Is Waiting Approval</p>";
            //     echo '</div>';
            // }else{ ?>
                 <div class="col-md-2 text-center"> 
                    <img src="img.png" class="img-responsive img-thumbnail img-circle" alt="" /> -->
                    <a href='student.php?userid=<?php echo $infoUser['t_id']?>'><?php echo $message['firstname']?></a>
                </div>
                <div class="col-md-10">
                    <p class='lead'><?php echo $message['message']?><p>
                </div>
    <?php    ?>
        </div>
    </div>
    <!-- <hr class="costom-hr"> -->
<?php }

 
?>
</div>
</div>
<?php

}else{

    header('Location: login.php');

    exit();

}

include $tepl . 'footer.php';

ob_end_flush();
?>