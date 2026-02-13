<?php
require('connection.php');
session_start();

$fname = $lname = $emailid = $password = $password1 = "";
$fname_err = $lname_err = $emailid_err = $password_err = $password1_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    if (empty(trim($_POST["fname"]))) {
        $fname_err = "Please enter your first name.";
    } else {
        $fname = trim($_POST["fname"]);
    }
    if (empty(trim($_POST["lname"]))) {
        $lname_err = "Please enter your last name.";
    } else {
        $lname = trim($_POST["lname"]);
    }
    if (empty(trim($_POST["emailid"]))) {
        $emailid_err = "Please enter your email.";
    } else {
        $emailid = trim($_POST["emailid"]);
        if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) {
            $emailid_err = "Invalid email format.";
        }
    }
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
    if (empty(trim($_POST["password1"]))) {
        $password1_err = "Please confirm password.";
    } else {
        $password1 = trim($_POST["password1"]);
        if (empty($password_err) && ($password != $password1)) {
            $password1_err = "Passwords do not match.";
        }
    }

    if (empty($fname_err) && empty($lname_err) && empty($emailid_err) && empty($password_err) && empty($password1_err)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user_details (fname, lname, emailid, password) VALUES ('$fname', '$lname', '$emailid', '$password')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registration Successful');</script>";
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Server Down');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Pet Paradise - your online pet store</title>
    <style>
        .logo img {
            height: 80px;
            width: auto;
        }
        .footer-bg iframe {
            display: block;
            margin: 0 auto 10px auto;
        }
        .contact {
            padding: 30px;
            text-align: center;
            margin-top: 20px;
        }
        .marq {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .marq img {
            width: 150px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .marq img:hover {
            transform: scale(1.05);
        }
        @media screen and (max-width: 768px) {
            .mainbox, .marq {
                flex-direction: column;
                align-items: center;
            }
            iframe {
                width: 100% !important;
                height: 300px !important;
            }
            .marq img {
                width: 120px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar background">
    <div class="logo"><img src="img/images.png" alt="logo"></div>
    <ul class="nav-list">
        <li><a href="home">Home</a></li>
        <li><a href="about.html">AboutUs</a></li>
        <li><a href="contact.html">ContactUs</a></li>
        <li><a href="product.html">ProductPage</a></li>
    </ul>
    <div class="rightnav">
        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            echo "<h2 style='color:white; text-align:center; padding:6px;'> Logged In Username:<b style='color:orange;'> {$_SESSION['username']} </b><h5></h5></h2>
    <button style='background-color:#4caf5; color:black; border:solid neon 2px; border-radius:120px; padding:6px;'><a href='logout.php' style='color:black; font-size:18px; text-decoration:none; font-weight:bolder;'>LOG OUT</a></button>";
        } else {
            echo "<center>
    <div class='boom'>
        <button type='button' onclick=\"popup('login-popup')\" id='loggg'>LOGIN</button>
        <button type='button' onclick=\"popup('register-popup')\" id='sig'>REGISTER</button>
    </div>
</center>";
        }
        ?>
        <div class="popup-container" id="login-popup">
            <div class="popup">
                <form method="POST" action="login_register.php">
                    <h2>
                        <span>USER LOGIN</span>
                        <button type="reset" onclick="popup('login-popup')">X</button>
                    </h2>
                    <input type="text" placeholder="Email" name="email_username" required>
                    <input type="password" placeholder="Password" name="password">
                    <button type="submit" class="login-btn" name="login">LOGIN</button>
                </form>
            </div>
        </div>
        <div class="popup-container" id="register-popup">
            <div class="register popup">
                <form method="POST" action="login_register.php">
                   <h2><span>USER REGISTRATION</span>
        <button type="reset" onclick="popup('register-popup')" id="green">X</button>
    </h2>

    <input type="text" placeholder="Full Name" name="fullname" required>
    <input type="text" placeholder="Username" name="username" required>
    <input type="email" placeholder="Email" name="email" required>
    <input type="password" placeholder="Password" name="password" required>
    <input type="password" placeholder="Confirm Password" name="password1" required>

    <button type="submit" class="register-btn" name="register">REGISTER</button>

                </form>
            </div>
        </div>
    </div>
</nav>
<section class="background firstsection">
    <div class="mainbox">
        <div class="firsthalf">
            <p class="text-big">The One Stop Shop For your Pets </p> <br>
            <p class="text-big">"Discover a premier pet shop offering top-notch products, personalized services, and a community-focused environment. Elevate your pet's lifestyle with us – where passion meets quality." </p>
        </div>
        <div class="secondhalf">
            <img src="img/dnc.jfif" alt="Pets">
        </div>
    </div>
    <div><img src="img/deals.webp" alt="doctor" id="frame1"></div>
    <div style="margin-bottom: 150px;"></div>
    <h1 id="txt">Select Your Pet</h1>
    <div class="marq">
        <a href="product.html#dogs"><img src="img/doggs.jfif" id="eit1"></a>
        <a href="product.html#cats"><img src="img/catss.jfif" id="eit2"></a>
        <a href="product.html#birds"><img src="img/birdss.jfif" id="eit3"></a>
        <a href="product.html#others"><img src="img/fishh.jfif" id="eit4"></a>
        <a href="product.html#others"><img src="img/rabbit.jfif" id="eit5"></a>
        <a href="product.html#others"><img src="img/gpig.jfif" id="eit6"></a>
    </div>
    <div style="margin-bottom: 200px;"></div>
    <div><img src="img/middle.webp" id="frame1"></div>
    <div style="margin-bottom: 100px;"></div>
    <h2 id="txt">Best Sellers</h2>
    <div class="marq">
        <a href="product.html#dogfood"><img id="eita" src="img/dfood.jpg" style="margin: 20px;"></a>
        <a href="product.html#catfood"><img id="eitf" src="img/cfood.jpg" style="margin: 50px;"></a>
        <a href="product.html#"><img id="eitgh" src="img/treat.jpg" style="margin: 50px;"></a>
        <a href="product.html#"><img id="eitih" src="img/ctreat.jpg" style="margin: 50px;"></a>
        <a href="product.html#"><img id="eitdc" src="img/par.jpg" style="margin: 50px;"></a>
    </div>
    <div style="margin-bottom: 50px;"></div>
    <div class="footer-bg">
        <div class="col-md-4">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3518.091462249058!2d77.55055827454694!3d12.996291714337463!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae3d8c1188bd8f%3A0x3f666b6358e00f31!2sKLE%20Society's%20S.%20Nijalingappa%20College!5e1!3m2!1sen!2sin!4v1747246850822!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <div style="margin-bottom: 200px;"></div>
    <section class="contact">
        <h1 class="text-center">Contact us <br>phone number: 012345678 <br>email address: petparadise@gmail.com<br>website: petparadise.com</h1>
        <div class="logo"></div>
    </section>
    <center><a href="#"><input type="button" value="Back To Top" id="container"></a></center>
</section>
<script>
    function popup(popup_name) {
        get_popup = document.getElementById(popup_name);
        if (get_popup.style.display == "flex") {
            get_popup.style.display = "none";
        } else {
            get_popup.style.display = "flex";
        }
    }
</script>
</body>
</html>

