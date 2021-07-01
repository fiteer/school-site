<?php
ob_start();
session_start();

$pageTitle = 'Post';

include 'init.php';
include 'config.php';



?>

<div class="container view-item">
    <div class="row col-items">

        <?php 

//$uid = isset($_GET['uid']) && is_numeric($_GET['uid']) ? intval($_GET['uid']) : 0;

            if(isset($_SESSION['user'])){
            
                $items = mysqli_query($conn, "SELECT * FROM
                `posts` p
                INNER JOIN
                `techers` t 
                WHERE p.author = t.t_id 
                ORDER BY post_ID DESC");
                mysqli_fetch_assoc($items);


                if(empty($items)){

                    echo "<div class='naice-message'>Sorry This Category Is Empty</div>";
    
                }else{
                   
                    foreach($items as $item){
                        
                        ?>
                        
                        <div class="card-items">
                            <div class="front">
                                <div class='img-items'>
                                    <img src="layout/image/8SCENE.png" alt='' class='img-top'>
                                </div>
                                <h3><a href='items.php?postid=<?php echo $item['post_ID']?>'> <?php echo $item['title']?></a></h3>
                                <p class='text-items'><?php echo $item['objective']?></p>
                                <ul class='list-items'>
                                    <li>Added By: <span><a href='techer.php?userid=<?php echo $item['t_id']?>'><i class='fa fa-user'></i> <?php echo $item['firstname']?></a></span></li>
                                    <li>Days Avalible: <span><i class='fa fa-days'></i> <?php echo $item['days_avalible']?></span></li>
                                    <li>Timely Time: <span><i class='fa fa-time'></i> <?php echo $item['timely_time']?></span></li>
                                    <li>Phase Study: <span><i class='fa fa-user'></i> <?php echo $item['phase_study']?></span></li>
                                    <li>Price: <span><i class='fa fa-user'></i> <?php echo $item['price']?></span></li>
                                    <li>Added For Date: <span><i class='fa fa-book'></i> <?php echo $item['date']?></span></li>
                                </ul>
                            </div>
                        </div>
                    <?php }
               }
            }else{
                $TheMsg = "<div class='alert alert-danger'>You Can't Access. Plase Login or Sign Up</div>";
                redirectHome($TheMsg, 'Login.php', 7);
            }
            ?>
                

    </div>
</div> 

<?php
include $tepl . 'footer.php';
ob_end_flush();
?>