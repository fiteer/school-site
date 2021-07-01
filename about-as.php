<?php
ob_start();
session_start();

$pageTitle = 'HomePage';

include 'init.php';



?>

<div class="container homepage about-as">
    <div class="row home-info">
        <div class="imag-right">
            <img src="layout/image/8SCENE.png" alt="" >
        </div>
        <div class="text-left">
            <h2>About Us</h2>
            <p>
                Tutor Finder plays as a mediator between tutors and 
                students. It helps the parents to find an authorized 
                tutor that satisfied their children's educational needs. 
                At the same time, it allows tutors to offer their educational 
                services using a suitable way instead of publishing their services 
                unprofessionally.            
            </p>
            <p>
                Tutor Finder gathers all private tutors in Saudi Arabia in one platform. 
                It allows students and their parents to search for a private tutor by 
                subject or tutor's name. Also, the platform can show the availability of 
                tutors by region and city.            
            </p>
            <p>
                Tutor Finder is one of the technologies and an Internet tool that can be 
                used to facilitate and enhance the learning process.
            </p>
        </div>
        </div>

            

    </div>
</div> 

<?php
include $tepl . 'footer.php';
ob_end_flush();
?>