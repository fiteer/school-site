<?php
ob_start();
session_start();

$pageTitle = 'HomePage';

include 'init.php';



?>

<div class="container homepage">
    <div class="row home-info">
        <div class="imag-right">
            <img src="layout/image/4SCENE.png" alt="" >
        </div>
        <div class="text-left">
            <h2>Our tutors are ready to help</h2>
            <p>
                Private lessons with expert tutors allow you to improve your skills faster and get better results.
            </p>
            <p>
                Find the best tutors in Saudi Arabia and meet them anywhere in the way it suits you.
            </p>
            <div class="find-info">
                <a href="search.php">Find a tutor</a>
            </div>
        </div>
        </div>

            

    </div>
</div> 

<?php
include $tepl . 'footer.php';
ob_end_flush();
?>