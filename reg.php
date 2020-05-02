<?php
    session_start();
    require "db/dbcon.php";
    $name = "";
    $err_name = "";
    $uname = "";
    $err_uname = "";
    $pass = "";
    $err_pass = "";
    $email = "";
    $err_email = "";
    $pass ="";
    $err_pass = "";
    $cpass = "";
    $err_cpass = "";

    //below function ensures unique username from user
    function isAvailable($uname)
    {
        $query = "SELECT * from profiles where username='$uname'";
        $result = get($query);
        if(mysqli_num_rows($result)>0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //below function automatically logs in the user
    //and redirects him to the homepage
    function autoLogin($uname,$pass)
    {
        $query = "SELECT * FROM profiles WHERE username='$uname' AND pass='$pass'";
        $result=get($query);
        if(mysqli_num_rows($result) > 0)
        {
            $user=mysqli_fetch_assoc($result);
            $_SESSION['user'] = $user;
            unset($_POST['register']);
            header("Location:./");
            
        }
    }
    
    if(isset($_POST['register']))
    {
        $hasNoError = true;
        if(empty($_POST['name']))
        {
            $err_name = "Name can not be empty";
            $hasNoError = false;
        }
        else
        {
            $name = htmlspecialchars($_POST['name']);
            //$name = $_POST['name'];
            //echo $name;
        }
        if(empty($_POST['uname']))
        {
            $err_uname = "Username can not be empty";
            $hasNoError = false;
        }
        else
        {
            $uname = htmlspecialchars($_POST['uname']);
            if(!isAvailable($uname))
            {
                $err_uname = "Opps! username is already taken...";
                $hasNoError = false;
            }
        }
        if(empty($_POST['email']))
        {
            $err_email = "Email can not be empty";
            $hasNoError = false;
        }
        else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {			
            
            $err_email = "Email ID is not valid";
            $hasNoError = false;
        }
        else
        {
            $email = htmlspecialchars($_POST['email']);
        }

        if(empty($_POST['pass']))
        {
            $err_pass = "Password can not be empty";
            $hasNoError = false;
        }
        else
        {
            $pass = htmlspecialchars($_POST['pass']);
        }
        if(empty($_POST['cpass']))
        {
            $err_cpass = "Password can not be empty";
            $hasNoError = false;
        }
        else
        {
            $cpass = htmlspecialchars($_POST['cpass']);
        }
        if(!empty($cpass) and !empty($pass))
        {
            if($cpass!==$pass)
            {
                $err_cpass = "Passwords didn't match";
                $hasNoError = false;
            }
        }

        if($hasNoError)
        {
            $query = "INSERT INTO profiles (username, name, email, pass, plan)
                VALUES ('$uname', '$name', '$email','$pass','0')";
            execute($query);

            autoLogin($uname,$pass);
        }

    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration | NoteFused</title>
    <link rel="stylesheet" href="styles/reg.css">
    <!-- <link rel="stylesheet" href="login.css"> -->
    <link rel="stylesheet" href="styles/form.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body>
    <div class="blur-back">

    </div>
    <div class="form-wrap">
        <form action="" method="post">
            <div class="headingz">
                <div class="title">
                    <a href="index.php" id="ttl">NoteFused</a>
                </div>
                <div><span>&nbsp>&nbsp</span></div>
                <div>
                    Registration
                </div>
            </div>


            <div class="input-sec">
                <input type="text" name="name" id="namebox" value="<?php echo $name ;?>">
                <span data-placeholder="name"></span>
            </div>
            <div class="warn"><?php echo $err_name; ?></div>
            <div class="input-sec">
                <input type="text" name="uname" id="unamebox" value="<?php echo $uname ;?>">
                <span data-placeholder="username"></span>
            </div>
            <div class="warn"><?php echo $err_uname; ?></div>
            <div class="input-sec">
                <input type="text" name="email" id="emailbox" value="<?php echo $email ;?>">
                <span data-placeholder="email"></span>
            </div>
            <div class="warn"><?php echo $err_email; ?></div>
            <div class="input-sec">
                <input type="password" name="pass" id="passbox" value="<?php echo $pass ;?>">
                <span data-placeholder="password"></span>
            </div>
            <div class="warn"><?php echo $err_pass; ?></div>
            <div class="input-sec">
                <input type="password" name="cpass" id="cpassbox" value="<?php echo $cpass ?>">
                <span data-placeholder="confirm password"></span>
            </div>
            <div class="warn"><?php echo $err_cpass; ?></div>
            <div class="button-holder">
                <input type="reset" value="Clear Form" class="resBtn" id="resetButton" onclick="resetForm()">
                <div class="gap"></div>
                <input type="submit" value="Register" class="subBtn" name="register">
            </div>
            <div class="bottomText">
                Already have an account? <a href="login.php">Login Instead</a>
            </div>


        </form>
    </div>

    <script>
        function resetForm() {
            $(".input-sec input").removeClass('focus');
        }
        $(".input-sec input").on("focus", function () {
            $(this).addClass("focus");
        });
        $(".input-sec input").on("blur", function () {
            if ($(this).val() == "") {
                $(this).removeClass('focus');
            }
        });
    </script>
    <?php
            if($name != "")
            {
                echo "<script>
                $('#namebox').addClass('focus');
                </script>";
            }
            if($uname != "")
            {
                echo "<script>
                $('#unamebox').addClass('focus');
                </script>";
            }
            if($email != "")
            {
                echo "<script>
                $('#emailbox').addClass('focus');
                </script>";
            }
            if($pass != "")
            {
                echo "<script>
                $('#passbox').addClass('focus');
                </script>";
            }
            if($pass != "")
            {
                echo "<script>
                $('#cpassbox').addClass('focus');
                </script>";
            }
        ?>
</body>

</html>