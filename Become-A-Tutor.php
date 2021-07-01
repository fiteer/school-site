<?php

    session_start();
    $pageTitle = 'Login';
    include 'init.php';
    if(isset($_SESSION['user'])){
        $TheMsg = "<div class='alert alert-success'>You Can't Access, Plase Loguot And Try Agin.</div>";
        redirectHome($TheMsg, 'Home.php', 15);
    }
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['login'])){

            $email = $_POST['email'];
            $pass = $_POST['password'];
            $hashedPass = sha1($pass);
            $group = 1;
            $stmt = $con->prepare("SELECT
                                        t_id, email, `password`, group_id
                                    FROM
                                        techers
                                    WHERE
                                        email = ?
                                    AND
                                    `password` = ?");
            $stmt->execute(array($email, $hashedPass));

            $get = $stmt->fetch();

            $check = $stmt->rowCount();

            if($check > 0){

                $_SESSION['user'] = $email; // Register Session Name
                if($get['group_id'] == 1){ 
                    $_SESSION['gid'] = $get['group_id']; // Register User ID In Session
                }else{
                    $_SESSION['tid'] = $get['t_id'];
                }
                header('Location: Home.php'); // Redirect To Dashboard Page
                exit();

            }
        }else{
            
            $formErrors = array();

            $firstname   = $_POST['firstname'];
            $lastname   = $_POST['lastname'];
            $email      = $_POST['email'];
            $subject    = $_POST['subject'];
            $exper      = $_POST['experiences'];
            $password   = $_POST['password'];
            $password2  = $_POST['password2'];            
            if(isset($firstname)){

                $filterUser = filter_var($firstname, FILTER_SANITIZE_STRING);

                if(strlen($filterUser) < 4){

                    $formErrors [] = 'firstname Must Be Lager Than 4 Characters';

                }

            }

            if(isset($lastname)){

                $filterUser = filter_var($lastname, FILTER_SANITIZE_STRING);

                if(strlen($filterUser) < 5){

                    $formErrors [] = 'firstname Must Be Lager Than 5 Characters';

                }

            }

            if(isset($password) && isset($password2)){

                if(empty($password)){

                    $formErrors[] = 'Sorry Password Cant Be Empty ';

                }

                if(sha1($password) !== sha1($password2)){

                    $formErrors[] = 'Sorry Password Is Not Match';

                }

            }

            if(isset($email)){

                $filterEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

                if(filter_var($filterEmail, FILTER_VALIDATE_EMAIL) != true){

                    $formErrors[] = 'Sorry This Email Is Not Valid';

                }

            }

            if(empty($formErrors)){

                $check = chickItem("firstname", "techers", $firstname);

                if($check == 1){

                    $formErrors[] = 'This firstname Is Exsit';

                }else{

                    // Insert Userinfo Into Database

                    $stmt = $con->prepare("INSERT INTO 
                                                techers(firstname, lastname, email,`password`, `subject`, experiences, `date`)
                                            VALUES(:zfname, :zlname, :zemail, :zpass, :zsubject, :zexper, now())");
                    $stmt->execute(array(
                        'zfname'  => $firstname,
                        'zlname'  => $lastname,
                        'zemail'  => $email,
                        'zpass'  => sha1($password),
                        'zsubject'  => $subject,
                        'zexper'  => $exper,
                    ));

                    //Echo Success Message

                    $successMas = 'Congerat You Are Now Regestiret Techer';                    

                } 

            }
        }
        
    }
    $sub = array('PHP','CSS, HTML and JAVASCRIPT','OS','Arabic Language', 'Database', 'DBMS');
?>

    <div class="container login-page">
        <h1 class="text-center">
            <span class="selected" data-class="login">Login</span> | 
            <span data-class="signup">Registre</span>
        </h1>
        <div class="signup-stu">
            <!-- Start Login Form -->
            <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <p>Tutor Login</p>
                <div class="form-login-page">
                    <input
                        title="firstname Must Be 4 Characters"
                        class="form-control"
                        type="email" 
                        name="email"
                        autocomplete="off"
                        required
                        placeholder="Type Your Name" />
                </div>
                <div class="form-login-page">
                    <input 
                        class="form-control" 
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        required
                        placeholder="Type Your Password" />
                </div>
                <input class="btn btn-primary btn-block" type="submit" name="login" value="Login">
            </form>
            <!-- End Login Form -->
            <!-- Start Signup Form -->
            <form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="form-login-page">
                    <input
                        class="form-control"
                        type="text" 
                        name="firstname"
                        autocomplete="off"
                        required
                        placeholder="Enter Your First Name" />
                </div>
                <div class="form-login-page">
                    <input
                        class="form-control"
                        type="text" 
                        name="lastname"
                        autocomplete="off"
                        required
                        placeholder="Enter Your Last Name" />
                </div>
                <div class="form-login-page">
                    <input
                        class="form-control" 
                        type="email"
                        name="email"
                        required
                        placeholder="Enter Your Email" />
                </div>
                <div class="form-login-page">
                    <input 
                        class="form-control" 
                        type="password"
                        name="password"
                        autocomplete="new-password"
                        required
                        placeholder="Enter Complex Password" />
                </div>
                <div class="form-login-page">
                    <input 
                        class="form-control" 
                        type="password"
                        name="password2"
                        autocomplete="new-password"
                        required
                        placeholder="Enter a Password Again" />
                </div>
                <div class="form-login-page">
                    <select name="subject" calss="control" required>
                        <option class="option" value="0">Choose Subject</option>
                        <?php 
                            foreach($sub as $subs){
                                echo "<option class='option' value='$subs'>". $subs ."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-login-page">
                    <select name="experiences" calss="control" required>
                        <span>
                            <option class="option" value="0">Choose experiences</option>
                            <option class="option" value="1 Year">1 Year</option>
                            <option class="option" value="2 Years">2 Years</option>
                            <option class="option" value="3 Years">3 Years</option>
                            <option class="option" value="4 Years">4 Years</option>
                            <option class="option" value="More from 4 Years">More from 4 Years</option>
                        </span>
                    </select>
                </div>
                <input class="btn btn-success btn-block" type="submit" name="signup" value="Signup">
            </form>
        <!-- End Signup Form -->
            <div class="img-stu">
                <img src="layout/image/6SCENE3.png" alt="">
            </div>
        </div>
        <div class="the-errors text-center">
            <?php  
            
                if(!empty($formErrors)){

                    foreach($formErrors as $error){

                        echo "<div class='masg error'>" . $error . "</div>";

                    }

                }

                if(isset($successMas)){

                    echo "<div class='masg success'>" . $successMas . "</div>";

                }

            ?>
        </div>
    </div>

<?php  
    include $tepl . 'footer.php';
?>