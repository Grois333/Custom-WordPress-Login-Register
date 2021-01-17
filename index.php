<?php
// import user object
require_once('core/classes/user.Class.php');

// assig User object to $User variable
$User = new User;

// getting the action
$a = isset($_GET['a']) ? $_GET['a'] : '';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" type="image/png" href="http://localhost/loginregister/assets/images/logo.png"/>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">


    <style>

        /* Form Loading   */
        #status{
            display: flex;
            position: absolute;
            margin-left: 210px;
        }

        .fa-spinner{
            font-size: 40px;
            color:#ff2b4f;
        }

        @media only screen and (max-width: 500px) {

            #status{
                margin-left: 260px !important;
            }
        }

    </style>

 

    

    <title>Login/Register User</title>
</head>
<body>



<?php
switch($a){
    case 'login': {
        echo $User -> LoginForm();
        break;
    }
    case 'register': {
        echo $User -> RegisterForm();
        break;
    }
    case 'dashboard': {
        if($User -> Is_Login())
            echo $User->Dashboard();
        else
            echo "<div style='text-align: center; margin:auto; margin-top: 50px; font-size: 20px; '><p>Session expired!</p><div>";
        break;
    }
    default: {
        echo $User -> LoginForm();
        // echo $User -> RegisterForm();
        break;
    }
}
?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/"
        crossorigin="anonymous"></script>

<script src="script.js"></script>

<script src="form.js"></script>

    
</body>
</html>