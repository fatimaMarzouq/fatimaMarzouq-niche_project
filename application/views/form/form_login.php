<!DOCTYPE html>

<html lang="en">

  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    

    <!-- Meta, title, CSS, favicons, etc. -->

    

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="<?= site_url()?>images/logo.jpeg" type="image/ico" />



            <title>NICHEFAS FORM</title>


 <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css">


    

     <script src="<?=site_url()?>vendors/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap -->
<script src="https://adminlte.io/themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!--<script src="<?=site_url()?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>-->
<script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js"></script>

  </head>

  <style type="text/css">
    .login-box-msg
    {
      font-weight: bold ! important;
    }
    .login-page
    {
      background-color: rgb(224,249,255) ! important;
    }
    .newbtn_one
    {
      background-color: #055798 ! important;
    border-color: #055798 ! important;
    }

    .mb-1 a
    {
      color: rgb(0,185,249) ! important;
    }
    .mb-0 a
    {
      color: rgb(0,185,249) ! important;
    }
    .login-box
    {
      margin:100px auto;
    }
    .right_one
    {
      text-align: end;
      margin-bottom: 0px;
    }
    .right_one12
    {
      background-repeat: no-repeat;
    position: relative;
    right: 2px;
    /* right: 312px; */
    top: 3px;
    background: #fff;
    height: 81px;
    width: 228px;
    padding: 7px 10px;
    margin-bottom: 6px;
    }
  </style>

  <style type="text/css">
    @media only screen and (max-width: 768px)
    {
      .login-box
    {
      margin:50px auto;
    }
    .topnav a.active
      {
        width: 30% ! important;
        text-align: left;
      }
      .topnav a
      {
        float: left ! important;
      }
    }
  </style>

<style>
    .topnav {
  overflow: hidden;
  background-color: #055798;
}

.topnav a {
  float: left;
  display: block;
  color: #fff;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  /*background-color: #ddd;*/
  color: #fff;
}

/*.topnav a.active {
  background-color: #2196F3;
  color: white;
  width: 11%;
}*/

.topnav .login-container {
  float: right;
}

.topnav input[type=text] {
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  border: none;
  width:120px;
}

.topnav .login-container button {
  float: right;
  padding: 6px 10px;
  margin-top: 8px;
  margin-right: 16px;
  background-color: #555;
  color: white;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.topnav .login-container button:hover {
  background-color: green;
}

@media screen and (max-width: 600px) {
  .topnav .login-container {
    float: none;
  }
  .topnav a, .topnav input[type=text], .topnav .login-container button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    border: 1px solid #ccc;  
  }
}
                .login-page1, .register-page {
                    background-color: rgb(224,249,255) ! important;
                    /*-webkit-align-items: center;*/
                    /*-ms-flex-align: center;*/
                    /*align-items: center;*/
                    /*background-color: #e9ecef;*/
                    /*display: -webkit-flex;*/
                    /*display: -ms-flexbox;*/
                    /*display: flex;*/
                    /*-webkit-flex-direction: column;*/
                    /*-ms-flex-direction: column;*/
                    /*flex-direction: column;*/
                    /*height: 100vh;*/
                    /*-webkit-justify-content: center;*/
                    /*-ms-flex-pack: center;*/
                    /*justify-content: center;*/
                }
</style>



  <body class="hold-transition login-page1">




<div class="topnav" style="width:100%;">
  <!--<a class="active" href="#home">NICHEFAS</a>-->
  <h1 class="right_one"><img src="http://162.144.65.120/~procopbn/nichefas/images/logo_one.png" class="right_one12"></h1>
  
</div>









    <div class="login-box">
        <div class="login-logo">
          <a href="#"><b></b></a>
        </div>

        <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>



        <div class="col-sm-12" style="margin-bottom:25px;">
                <?php 
                    if(!$this->session->flashdata('msg')==''){  ?>
                       <center>   
                            <div class="alert alert-success alert-dismissable">
                                <a href="" class="close" data-dismiss="alert" aria-label="close">x</a>
                                <h4>  <?php  echo $this->session->flashdata('msg'); ?></h4>
                            </div>
                        </center>
                <?php } ?>
                <?php 
                if(!$this->session->flashdata('error_msg')==''){  ?>
                    <center>   
                        <div class="alert alert-danger alert-dismissable">
                            <a href="" class="close" data-dismiss="alert" aria-label="close">x</a>
                            <h4>  <?php  echo $this->session->flashdata('error_msg'); ?></h4>
                        </div>
                    </center>
                <?php } ?>
            </div> 


      <form action="<?=site_url('form/form_login_check')?>" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" required name="email"  placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <!-- <span class="fas fa-envelope"></span> -->
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" required name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
             <!--  <span class="fas fa-lock"></span> -->
            </div>
          </div>
        </div>
        <div class="row">
              <div class="col-8">
                <!--<div class="icheck-primary">-->
                <!--  <input type="checkbox" id="remember">-->
                <!--  <label for="remember">-->
                <!--    Remember Me-->
                <!--  </label>-->
                <!--</div>-->
              </div>
          <!-- /.col -->
          <div class="col-4">
           <!--  <button type="submit" name="login" class="btn btn-primary  btn-block">Sign In</button> -->
            <input type="submit" name="login" value="Sign In" class="btn btn-primary newbtn_one btn-block">
          </div>
          <!-- /.col -->
        </div>
      </form>

     

      <!--<p class="mb-1">-->
      <!--  <a href="<?=base_url()?>welcome/Forget_Password">I forgot my password</a>-->
      <!--</p>-->
      <!-- <p class="mb-0">
        <a href="<?=base_url()?>welcome/registration" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->


       
  </body>

</html>

