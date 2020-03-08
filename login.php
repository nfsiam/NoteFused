<?php
    $uname = "";
    $err_uname = "";
    $pass = "";
    $err_pass = "";
    if(isset($_POST['login']))
    {
        if(empty($_POST['uname']))
        {
            $err_uname = "Username can not be empty";
        }
        else
        {
            $uname = htmlspecialchars($_POST['uname']);
        }

        if(empty($_POST['pass']))
        {
            $err_pass = "Password can not be empty";
        }
        else
        {
            $pass = htmlspecialchars($_POST['pass']);
        }

    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | NoteFused</title>
    <link rel="stylesheet" href="styles/loginpage.css">
    <link rel="stylesheet" href="styles/form.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body>

    </div>
    <div class="form-wrap" id="loginForm">
        <form action="" id="" method="post">
            <div class="wrap">
                <div class="headingz">
                    <div class="title">
                        <a href="index.php">NoteFused</a>
                    </div>
                    <div><span>&nbsp>&nbsp</span></div>
                    <div>
                        Login
                    </div>
                </div>
            </div>
            <div class="input-sec">
                <input type="text" name="uname" id="unamebox" value="<?php echo $uname; ?>">
                <span data-placeholder="username" ></span>
            </div>
            <div class="warn"><?php echo $err_uname; ?></div>
            <div class="input-sec">
                <input type="password" name="pass" id="passbox" value="<?php echo $pass;?>">
                <span data-placeholder="password"></span>
            </div>
            <div class="warn"><?php echo $err_pass; ?></div>
            <div class="button-holder">
                <input type="submit" value="Login" class="subBtn" name="login" >
            </div>
            <div class="bottomText">
                Don't have an account? <a href="reg.php">Register Now</a>
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
        
        /* $("#passbox").addClass('focus'); */
        
    </script>
    <?php
            if($uname != "")
            {
                echo "<script>
                $('#unamebox').addClass('focus');
                </script>";
            }
            if($pass != "")
            {
                echo "<script>
                $('#passbox').addClass('focus');
                </script>";
            }
        ?>
</body>

</html>