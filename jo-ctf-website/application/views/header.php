<!DOCTYPE html>
<html>
<head>
    <title>Content Mangement System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/application/Assets/css/bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/application/Assets/css/custom.css'); ?>">
    <!-- perhaps the js files may help you win -->
    <script type="text/javascript" src="<?php echo base_url('/application/Assets/js/jquery-3.1.1.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('/application/Assets/js/custom.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('/application/Assets/js/jquery.dotdotdot.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('/application/Assets/js/bootstrap.js'); ?>"></script>
</head>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/">Home</a></li>
                <li><a href="<?php echo base_url('/User/submission/'); ?>">Write</a></li>
<?php
if(isset($userdata['admin'])){
    echo '<li><a href="'.base_url('/admin/index/').'">Approve Posts</a></li>';
}
if(isset($userdata['logged_in'])){
     echo '<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="'.base_url('/User/resetPw/').'">Reset Password</a></li>
            <li><a href="'.base_url('/User/logout/').'">Logout</a></li>
          </ul>
        </li>';
}else {
    echo '<li ><a href = "/User/Login" > Login</a ></li >
                <li ><a href = "/User/Register" > Register</a ></li >';
    }
    ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>