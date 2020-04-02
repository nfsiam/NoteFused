<?php
    session_start();
    require "db/dbcon.php";
    
    
    if(isset($_SESSION['loggedUser'])){
        echo "Hello".$_SESSION['loggedUser'];
    }
    


    if(isset($_POST['login']))
    {
        $uname = $_POST['uname'];
        $pass = $_POST['pass'];

        $query = "SELECT * FROM profiles WHERE username='$uname' AND pass='$pass'";
        $result=get($query);
        if(mysqli_num_rows($result) > 0)
        {
            $user=mysqli_fetch_assoc($result);
            $loggedUser = $user['username'];
            $_SESSION['loggedUser'] = $loggedUser;
            // unset($_POST['login']);
        }

    }
    else
    {
    ?>    
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="js/jquery341.js"></script>
            <title>Document</title>
        </head>
        <body>
            <input type="text" name="uname" id="uname">
            <input type="text" name="pass" id="pass">
            <button id="submit">Login</button>
        </body>
        </html>

        <script>

            $('#submit').click(function(){
                let usn  = $('#uname').val();
                let p = $('#pass').val();
                // alert(usn);
                $.ajax({

                    url:'go.php',
                    method:'POST',
                    data:{
                        login: "login",
                        uname: usn,
                        pass:p
                    },
                    success:function(response){
                        //alert(response);
                        console.log("3");
                    }
                    });
                });
        </script>

    <?php
    }
?>
