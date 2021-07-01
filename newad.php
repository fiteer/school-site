<?php

session_start();

$pageTitle = 'Create New Post';

include 'init.php';
include 'config.php';

if(isset($_SESSION['user'])){

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $formErrors = array();

        $title      = $_POST['title'];
        $desc       = $_POST['objective'];
        $days       = $_POST['days'];
        $timely       = $_POST['timely'];
        $city       = $_POST['city'];
        $subject       = $_POST['subject'];
        $phase       = $_POST['phase'];
        $price       = $_POST['price'];

        if(strlen($title) < 4){
            $formErrors[] = 'Item title Must Be At Least 4 Characters';
        }
        if(strlen($desc) < 10){
            $formErrors[] = 'Item Description Must Be At Least 4 Characters';
        }


        if(empty($formErrors)){
            //$seid = isset() || isset($_SESSION['gid']);
            $stmt = $con->prepare("INSERT INTO 
                                        posts(title, `objective`, days_avalible, timely_time,c_id, sub_id, phase_study, price, author, `date`)
                                        VALUES(:ztitle, :zdesc, :zdays, :ztimely, :zcity, :zsubject, :zphase, :zprice, :zauthor, now())");
            $stmt->execute(array(

                'ztitle'         => $title,
                'zdesc'         => $desc,
                'zdays'         => $days,
                'ztimely'         => $timely,
                'zcity'         => $city,
                'zsubject'         => $subject,
                'zphase'         => $phase,
                'zprice'         => $price,
                'zauthor'        => $_SESSION['tid']
            ));

            if($stmt){
                $successMas = "Post Added";
            }

        }

    }

?>
    <h1 class="text-center"><?php echo $pageTitle?></h1>
    <div class="information block">
        <div class="container ">
            <div class="card">
                <div class="card-header bg-primary text-white"><?php echo $pageTitle?></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                                <!-- Start title Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">title</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            pattern=".{4,}"
                                            title="This Field Require At Least 4 Characters"
                                            class="form-control live"
                                            type="text" 
                                            name="title"  
                                            placeholder="title Of The post"
                                            data-class=".live-title"
                                            required>
                                    </div>
                                </div>
                                <!-- End title Field -->
                                <!-- Start Description Field -->
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Objective</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            class="form-control live" 
                                            type="text" 
                                            name="objective" 
                                            placeholder="Objective"
                                            data-class=".live-desc"
                                            required>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Days Avalible</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            class="form-control live" 
                                            type="text" 
                                            name="days" 
                                            placeholder="Days Avalible"
                                            required>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Timely Time</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            class="form-control live" 
                                            type="text" 
                                            name="timely" 
                                            placeholder="Timely Time"
                                            required>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">city</label>
                                    <div class="col-sm-10 col-md-10">
                                        <select name="city">
                                            <option value="0">...</option>
                                            <?php
                                                    $allctiy = mysqli_query($conn, "SELECT * FROM cities");                    
                                                    foreach($allctiy as $city){
                                                    echo "<option value='" . $city['c_id'] . "'>" . $city['c_name'] . "</option>";
                                                    
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Subject</label>
                                    <div class="col-sm-10 col-md-10">
                                        <select name="subject">
                                            <option value="0">...</option>
                                            <?php
                                                    $allsubs = mysqli_query($conn, "SELECT * FROM subjects");                    
                                                    foreach($allsubs as $sub){
                                                    echo "<option value='" . $sub['sub_id'] . "'>" . $sub['sub_name'] . "</option>";
                                                    
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Phase Study</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            class="form-control live" 
                                            type="text" 
                                            name="phase" 
                                            placeholder="Phase Study"
                                            required>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-2 col-form-label">Price</label>
                                    <div class="col-sm-10 col-md-10">
                                        <input 
                                            class="form-control live" 
                                            type="text" 
                                            name="price" 
                                            placeholder="The Price"
                                            required>
                                    </div>
                                </div>
                                <!-- End Description Field -->
                                <!-- Start Submit Field -->
                                <div class="mb-2 row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <input type="submit" value="Add Item" class="btn btn-primary">
                                    </div>
                                </div>
                                <!-- End Submit Field -->
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class='view-items'>
                                <div class='card live-preview'>
                                    <span class='price-tag'>
                                        $<span class="live-price">0</span>
                                    </span>
                                    <div class='card-header'>
                                        <img src='img.png' class='card-img-top' alt='' />
                                    </div>
                                    <div class='card-body'>
                                        <h3 class='card-title live-title'>Title</h3>
                                        <p class='card-text live-desc'>Description</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Looping Through Errors -->
                    <?php 
                        if(! empty($formErrors)){
                            foreach($formErrors as $error){

                                echo "<div class='alert alert-danger'>" . $error . "</div>";

                            }
                        }

                        if(isset($successMas)){

                            echo "<div class='alert alert-success'>" . $successMas . "</div>";
        
                        }
                    ?>
                    <!-- End Looping Through Errors -->
                </div>
            </div>
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