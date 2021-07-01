<?php

    session_start();
    $pageTitle = 'Login';
    if(isset($_SESSION['user'])){
        header('Location: index.php');
    }
    include 'init.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['login'])){

            $email = $_POST['email'];
            $pass = $_POST['password'];
            $hashedPass = sha1($pass);
            
            $stmt = $con->prepare("SELECT
                                        S_id, email, `password`
                                    FROM
                                        students
                                    WHERE
                                        email = ?
                                    AND
                                    `password` = ?");
            $stmt->execute(array($email, $hashedPass));

            $get = $stmt->fetch();

            $check = $stmt->rowCount();

            if($check > 0){

                $_SESSION['user'] = $email; // Register Session Name

                $_SESSION['sid'] = $get['S_id']; // Register User ID In Session
                

                header('Location: Home.php'); // Redirect To Dashboard Page
                exit();

            }
        }else{
            
            $formErrors = array();

            $firstname   = $_POST['firstname'];
            $lastname   = $_POST['lastname'];
            $email      = $_POST['email'];
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

                $check = chickItem("firstname", "students", $firstname);

                if($check == 1){

                    $formErrors[] = 'This firstname Is Exsit';

                }else{

                    // Insert Userinfo Into Database

                    $stmt = $con->prepare("INSERT INTO 
                                                students(firstname, lastname, email,`password`, `date`)
                                            VALUES(:zfname, :zlname, :zemail, :zpass, now())");
                    $stmt->execute(array(
                        'zfname'  => $firstname,
                        'zlname'  => $lastname,
                        'zemail'  => $email,
                        'zpass'  => sha1($password),
                    ));

                    //Echo Success Message

                    $successMas = 'Congerat You Are Now Regestiret User';                    

                } 

            }

        }
    }
?>

    <div class="container login-page">
        <h1 class="text-center">
            <span class="selected" data-class="login">Login</span> | 
            <span data-class="signup">Registre</span>
        </h1>
        <div class="signup-stu">
        <!-- Start Login Form -->
        <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <p>Student Login</p>
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
                <p>Tutor Registration</p>
                <div class="form-login-page">
                    <input
                        class="form-control"
                        type="text" 
                        name="firstname"
                        autocomplete="off"
                        required
                        placeholder="Enter Your Name" />
                </div>
                <div class="form-login-page">
                    <input
                        class="form-control"
                        type="text" 
                        name="lastname"
                        autocomplete="off"
                        required
                        placeholder="Enter Your Full Name" />
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
                <input class="btn btn-success btn-block" type="submit" name="signup" value="Signup">
            </form>
            <div class="img-stu">
                <img src="layout/image/6SCENE3.png" alt="">
            </div>
        </div>
        <!-- End Signup Form -->
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