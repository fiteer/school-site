<?php

session_start();

$pageTitle = 'Profile';

include 'init.php';
include 'config.php';
$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;


if(isset($_SESSION['user'])){
    $getUser = $con->prepare("SELECT * FROM techers WHERE t_id = ?");

    $getUser->execute(array($userid));

    $infoUser = $getUser->fetch();
    //$userid = $infoUser['UserID'];
?>
    <h1 class="text-center"><?php echo $infoUser['firstname']?></h1>
    <div class="information block">
        <div class="container">
            <div class="card">
                <div class="card-header bg-primary text-white">Techer Information</div>
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
                            <i class="fa fa-book fa-fw"></i>
                            <span>Subject</span> :          <?php echo $infoUser['subject']; ?>
                        </li>
                        <li>
                            <i class="fa fa-book fa-fw"></i>
                            <span>Experiences</span> :          <?php echo $infoUser['experiences']; ?>
                        </li>
                        <li>
                            <i class="fa fa-phone fa-fw"></i>
                            <span>Subject</span> :          <?php echo $infoUser['subject']; ?>
                        </li>
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Favouret Category</span> : 
                        </li>
                    </ul>
                    <a href="#" class="btn btn-default">Edit Information</a>
                </div>
            </div>
        </div>
    </div>

    <hr class="costom-hr">
            <?php if(isset($_SESSION['user'])){?>                 
                
    <div class="my-comment block">
        <div class="container"> -->
            <!-- Start Session Add Comment -->
             <div class="row">
                <div class="offset-sm-3 col-md-9">
                    <div class="add-comment">
                        <h3>Add Your Message</h3>
                        <form action="<?php echo $_SERVER['PHP_SELF'] . '?userid=' . $infoUser['t_id'] ?>" method="POST">
                            <textarea name="message" required></textarea>
                            <input class="btn btn-primary" type="submit" value="Add Message">
                        </form>
                        <?php
                        
                            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                                $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
                                $sid  = $_SESSION['sid'];
                                $tid  = $userid;

                                if(!empty($message)){

                                    $stmt = $con->prepare("INSERT INTO
                                                `message`(`message`, `Date`, `techer_id`, student_id)
                                                VALUES(:zmessage, now(), :ztecherid, :zstudent)");
                                    $stmt->execute(array(

                                        'zmessage'   => $message,
                                        'ztecherid'  => $tid,
                                        'zstudent'   => $sid            
                                    ));

                                    if($stmt){
                                         echo "<div class='alert alert-success'>Comment Added</div>";
                                    }

                                }
        
                            }

                        ?>
                    </div>
                </div>
            </div>
            <!-- End Session Add Comment -->
             <?php }else{
                echo "<a href='login.php'>Login</a> Or <a href='login.php'>Register</a> To Add Comment";
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
                if(isset($_SESSION['tid']) == $userid || isset($_SESSION['gid']) == $userid){
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
                                    <?php echo $message['firstname']?>
                                </div>
                                <div class="col-md-10">
                                    <p class='lead'><?php echo $message['message']?><p>
                                </div>
                    <?php    ?>
                        </div>
                    </div>
                    <!-- <hr class="costom-hr"> -->
               <?php }
               
                 }
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