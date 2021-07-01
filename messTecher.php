<?php

session_start();

$pageTitle = 'Profile';

include 'init.php';
include 'config.php';


if(isset($_SESSION['user'])){
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


   


<hr class="costom-hr">
                <?php 
                if(isset($_GET['userid']) && is_numeric($_GET['userid'])){
                    $id = intval($_GET['userid']);
                $stmt = $con->prepare("SELECT *
                                        FROM
                                            `message`
                                        
                                        where 
                                        techer_id = ?
                                        
                                        ORDER BY
                                            m_id DESC");
                $stmt->execute(array($userid));
                $messages = $stmt->fetchAll();
                foreach($messages as $message){
                    //if(isset($message[''])){
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
                                    <?php echo $message['student_id']?>
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
<?php }
}else{

    header('Location: login.php');

    exit();

}

include $tepl . 'footer.php';

ob_end_flush();
?>