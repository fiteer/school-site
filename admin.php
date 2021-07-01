<?php

    /**
     * ====================================================================
     * = Items Page
     * ====================================================================
     */

    ob_start(); // Output Buffring Start

    session_start();?>

<?php

    if(isset($_SESSION['gid'])){

        $pageTitle = 'subject';

        include 'init.php';
        include 'config.php';


        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

        if($do == 'Manage'){
            // if(!empty($stmt)){
                        
        }elseif($do == 'Add'){ // Add Page ?>

            <h1 class="text-center">Add New Subject</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
                    <!-- Start Name Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10 col-md-9">
                            <input 
                                    class="form-control"
                                    type="text" 
                                    name="name"  
                                    placeholder="Name Of The Item">
                        </div>
                    </div>
                    <!-- End Name Field -->
                    <!-- Start techer Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">techer</label>
                        <div class="col-sm-10 col-md-9">
                            <select name="techer">
                                <option value="0">...</option>
                                <?php
                                        $allMembers = mysqli_query($conn, "SELECT * FROM techers");                    
                                        foreach($allMembers as $tech){
                                        echo '<option value="' . $tech['t_id'] . '">' . $tech['firstname'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Members Field -->
                    <!-- Start post Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">post</label>
                        <div class="col-sm-10 col-md-9">
                            <select name="post">
                                <option value="0">...</option>
                                <?php
                                        $allCats = mysqli_query($conn, "SELECT * FROM posts");                    
                                        foreach($allCats as $post){
                                        echo "<option value='" . $post['post_ID'] . "'>" . $post['title'] . "</option>";
                                        
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Categories Field -->
                    <!-- Start Submit Field -->
                    <div class="mb-2 row">
                        <div class="offset-sm-2 col-sm-10">
                            <input type="submit" value="Add subject" class="btn btn-primary">
                        </div>
                    </div>
                    <!-- End Submit Field -->
                </form>
            </div>

        <?php

        }elseif($do == 'Insert'){ // Insert Page

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo '<h1 class="text-center">Insert Page</h1>';
                echo '<div class="container">';

                // Upload Variable
                
                    // Upload Variable
                
                // Get Variables From The Form

                $name       = $_POST['name'];
                $techer     = $_POST['techer'];
                $post       = $_POST['post'];
                

                // Validate The Form

                $formError = array();

                if(empty($name)){
                    $formError[] = 'Name Can\'t be <strong>Empty</strong>';
                }
                if($techer == 0){
                    $formError[] = 'You Must Choose The <strong>Techer</strong>';
                }
                if($post == 0){
                    $formError[] = 'You Must Choose The <strong>Post</strong>';
                }


                // Loop Into Errors Array And Echo It

                foreach($formError as $error){

                    echo '<div class="alert alert-danger">' . $error . '</div>';
                    
                }

                if(empty($formError)){
                    $stmt = $con->prepare("INSERT INTO
                                    subjects(`sub_name`, post_id, techer_id)
                                VALUES(:zname, :zpost, :ztecher)");
                    $stmt->execute(array(

                        'zname'     => $name,
                        'zpost'      => $post,
                        'ztecher'   => $techer,
                    ));

                    $TheMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                    header("refresh:5;url=profile.php");
                    exit();

                }

            }else{

                $TheMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                redirectHome($TheMsg, 'back');


            }
            echo '</div>';

        }

        $doo = isset($_GET['doo']) ? $_GET['doo'] : 'Manage';

        if($doo == 'Manage'){
            // if(!empty($stmt)){
                       
        }elseif($doo == 'Add'){ // Add Page ?>

            <h1 class="text-center">Add New Cities</h1>
            <div class="container">
                <form class="form-horizontal" action="?doo=Insert" method="POST" enctype="multipart/form-data">
                    <!-- Start Name Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10 col-md-9">
                            <input 
                                    class="form-control"
                                    type="text" 
                                    name="name"  
                                    placeholder="Name Of The Item">
                        </div>
                    </div>
                    <!-- End Name Field -->
                    <!-- Start techer Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">techer</label>
                        <div class="col-sm-10 col-md-9">
                            <select name="techer">
                                <option value="0">...</option>
                                <?php
                                        $allMembers = mysqli_query($conn, "SELECT * FROM techers");                    
                                        foreach($allMembers as $tech){
                                        echo '<option value="' . $tech['t_id'] . '">' . $tech['firstname'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Members Field -->
                    <!-- Start post Field -->
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">post</label>
                        <div class="col-sm-10 col-md-9">
                            <select name="post">
                                <option value="0">...</option>
                                <?php
                                        $allCats = mysqli_query($conn, "SELECT * FROM posts");                    
                                        foreach($allCats as $post){
                                        echo "<option value='" . $post['post_ID'] . "'>" . $post['title'] . "</option>";
                                        
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Categories Field -->
                    <!-- Start Submit Field -->
                    <div class="mb-2 row">
                        <div class="offset-sm-2 col-sm-10">
                            <input type="submit" value="Add Cities" class="btn btn-primary">
                        </div>
                    </div>
                    <!-- End Submit Field -->
                </form>
            </div>

        <?php

        }elseif($doo == 'Insert'){ // Insert Page

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                echo '<h1 class="text-center">Insert Page</h1>';
                echo '<div class="container">';

                // Upload Variable
                
                    // Upload Variable
                
                // Get Variables From The Form

                $cname       = $_POST['name'];
                $ctecher     = $_POST['techer'];
                $cpost       = $_POST['post'];
                

                // Validate The Form

                $formError = array();

                if(empty($cname)){
                    $formError[] = 'Name Can\'t be <strong>Empty</strong>';
                }
                if($ctecher == 0){
                    $formError[] = 'You Must Choose The <strong>Techer</strong>';
                }
                if($cpost == 0){
                    $formError[] = 'You Must Choose The <strong>Post</strong>';
                }


                // Loop Into Errors Array And Echo It

                foreach($formError as $error){

                    echo '<div class="alert alert-danger">' . $error . '</div>';
                    
                }

                if(empty($formError)){
                    $stmt = $con->prepare("INSERT INTO
                                    cities(`c_name`, post_id, techer_id)
                                VALUES(:zname, :zpost, :ztecher)");
                    $stmt->execute(array(

                        'zname'     => $cname,
                        'zpost'      => $cpost,
                        'ztecher'   => $ctecher,
                    ));

                    echo "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                    header("refresh:5;url=profile.php");
                    exit();


                }

            }else{

                $TheMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                redirectHome($TheMsg, '');


            }
            echo '</div>';

        }
        include $tepl . 'footer.php';
        
    }else{

        header('Location: index.php');
        exit();

    }

    ob_end_flush();

?>