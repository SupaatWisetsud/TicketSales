<?php 
    session_start();
    if(isset( $_SESSION["user_id"])) header("location:index.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ticket Sales</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link rel="stylesheet" href="node_modules\@fortawesome\fontawesome-free\css\all.min.css">
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- custom.css -->
        <link href="css/Custom.css" rel="stylesheet" type="text/css" />


    </head>
    <body class="skin-black">

        <div class="sidenav">
            <div class="login-main-text">
                <h1 class="title-logo">Ticket Sales</h1>
                <h2 class="sub-title-logo">Login Page</h2>
                <p>Login from here to access.</p>
            </div>
        </div>
        <div class="main">
            <div class="col-md-6 col-sm-12">
                <div class="login-form">
                <form action="action/action_login.php" method="POST">
                    <div class="form-group">
                        <label >Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" min="8" class="form-control rounded" placeholder="Password" required>
                    </div>
                    <button type="submit" name="login_submit" class="btn btn-success">Login</button>
                </form>
                </div>
            </div>
        </div>



        
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>