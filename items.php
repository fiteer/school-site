<?php
ob_start();
session_start();
$pageTitle = 'Show Post';
include 'init.php';
// Check If Get Request Item Is Numeric & Get Its Integer Value
$postid = isset($_GET['postid']) && is_numeric($_GET['postid']) ? intval($_GET['postid']) : 0;
// Select All Data Depend On This ID

$stmt = $con->prepare("SELECT 
                            posts.*,
                            techers.firstname
                        FROM 
                            posts
                        INNER JOIN
                            techers
                        ON
                            techers.t_id = posts.author 
                        WHERE post_ID = ?");
// Execute Query
$stmt->execute(array($postid));
// Fetch The Data 
$count = $stmt->rowCount();
    if($count > 0){
        $item = $stmt->fetch();
?>

        <h1 class="text-center"><?php echo $item['firstname'] ?></h1>
        <div class="container">
            <div class="row">
                <div class="col-md-3 img-info">
                    <?php //echo "<img src='admin/upload/avatar/" . $item['avatar'] ."' alt='' class='img-responsive img-thumbnail'>";?>
                </div>
                <div class="col-md-9 items-info">
                    <h2><?php echo $item['title'] ?></h2>
                    <p><?php echo $item['objective'] ?></p>
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Days Avalible</span> : <?php echo $item['days_avalible'] ?>
                        </li>
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Timely Time</span> : <?php echo $item['timely_time'] ?>
                        </li>
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Phase Study</span> : <?php echo $item['phase_study'] ?>
                        </li>
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Price</span> : <?php echo $item['price'] ?>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Added By</span> : <a href="#"><?php echo $item['firstname'] ?></a>
                        </li>
                        <li class="tags-items">
                            <i class="fa fa-user fa-fw"></i>
                            <span>Tags</span> : 
                            <?php
                            
                                // $allTags = explode(",", $item['Tags']);
                                // foreach($allTags as $tag){
                                //     $tag = str_replace(' ', '', $tag);
                                //     $lowerTags = strtolower($tag);
                                //     if(! empty($tag)){
                                //      echo "<a href='tags.php?name={$lowerTags}'>" . $tag . "</a> | ";
                                //     }
                                // }

                            ?>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="costom-hr">
            <?php if(isset($_SESSION['sid']) || isset($_SESSION['tid'])){ ?>
            <!-- Start Session Add Comment -->
            <div class="row">
                <div class="offset-sm-3 col-md-9">
                    <div class="add-comment">
                        <h3>Add Your Message</h3>
                        <form action="<?php echo $_SERVER['PHP_SELF'] . '?postid=' . $item['post_ID'] ?>" method="POST">
                            <textarea name="message" required></textarea>
                            <input class="btn btn-primary" type="submit" value="Add Message">
                        </form>
                        <?php
                        
                            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                                if(isset($_SESSION['sid'])){
                                $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
                                $postid  = $item['post_ID'];
                                $sid  = $_SESSION['sid'];
                                    if(!empty($message)){

                                        $stmt = $con->prepare("INSERT INTO
                                                    `message`(`message`, `Date`, post_id, `student_id`)
                                                    VALUES(:zmessage, now(), :zpostid, :zuserid)");
                                        $stmt->execute(array(

                                            'zmessage' => $message,
                                            'zpostid'  => $postid,
                                            'zuserid'  =>$sid
                
                                        ));

                                        if($stmt){
                                            echo "<div class='alert alert-success'>Comment Added</div>";
                                        }

                                    }
                                }else{
                                    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
                                    $postid  = $item['post_ID'];
                                    $tid  = $_SESSION['tid'];
                                    if(!empty($message)){

                                        $stmt = $con->prepare("INSERT INTO
                                                    `message`(`message`, `Date`, post_id, `techer_id`)
                                                    VALUES(:zmessage, now(), :zpostid, :zuserid)");
                                        $stmt->execute(array(

                                            'zmessage' => $message,
                                            'zpostid'  => $postid,
                                            'zuserid'  =>$tid
                
                                        ));

                                        if($stmt){
                                            echo "<div class='alert alert-success'>Comment Added</div>";
                                        }

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
                                            students.S_id = `message`.`student_id`
                                        WHERE
                                            `post_id` = ?
                                        
                                        
                                        ORDER BY
                                            m_id DESC");
                $stmt->execute(array($postid));
                $messages = $stmt->fetchAll();
                
                foreach($messages as $message){?>
                    <div class="comment-box">
                        <div class="row">
                            <?php
                            // if($comment['Status'] == 0){
                            //     echo '<div class="col-md-10">';
                            //         echo "<p class='leads alert alert-danger'>This Comment Is Waiting Approval</p>";
                            //     echo '</div>';
                            // }else{ ?>
                                <div class="col-md-2 text-center">
                                    <img src="img.png" class="img-responsive img-thumbnail img-circle" alt="" />
                                    <?php echo $message['firstname']?>
                                </div>
                                <div class="col-md-10">
                                    <p class='lead'><?php echo $message['message']?><p>
                                </div>
                    <?php    ?>
                        </div>
                    </div>
                    <hr class="costom-hr">
               <?php }
            
            ?>
        </div>

<?php
    }else{
        $theMessage =  "<div class='alert alert-danger'>There\'s No Such ID Or This Item Is Waiting Approval</div>";
        redirectHome($theMessage, 'back', 5);
    }
include $tepl . 'footer.php';
ob_end_flush();
?>