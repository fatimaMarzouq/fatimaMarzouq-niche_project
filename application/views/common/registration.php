<!DOCTYPE html>

<html lang="en">

  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    

    <!-- Meta, title, CSS, favicons, etc. -->

    

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="<?= site_url()?>images/logo.jpeg" type="image/ico" />



    <title>Work </title>


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
    .register-page
    {
      background-color: rgb(244,249,255) ! important;
    }
    .input-group-text
    {
      padding: 0.375rem 0.1rem ! important;
    }
    .icheck-primary a
    {
       color: rgb(0,185,249) ! important;
    }
    .text-center
    {
      color: rgb(0,185,249) ! important;
    }
    .newbtn_one
    {
      background-color: rgb(0,185,249) ! important;
    border-color: rgb(0,185,249) ! important;
    }
    .register-box
    {
      margin: 25px auto;

    }
    .register-logo
    {
      font-size: 1.9rem;
    }
  </style>

<style type="text/css">
    @media only screen and (max-width: 768px)
    {
      .topnav a.active
      {
        width: 30% ! important;
        text-align: left;
      }
    }
  </style>
<style>
    .topnav {
  overflow: hidden;
  background-color: rgb(0,185,249);
}

.topnav a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #2196F3;
  color: white;
  width: 11%;
}

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
                .login-page1, .register-page1 {
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


  <body class="hold-transition register-page1">
      
      <div class="topnav" style="width:100%;">
  <a class="active" href="#home">ADMIN LTE</a>
  
</div>

<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="<?=site_url('welcome/put_register')?>" method="post">
        <div class="input-group mb-3">
          <input type="number" class="form-control" name="gstin"  placeholder="GSTIN" >
          <div class="input-group-append">
            <div class="input-group-text">
             <!--  <span class="fas fa-user"></span> -->
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="companyName"  placeholder="Company Name" >
          <div class="input-group-append">
            <div class="input-group-text">
              <!-- <span class="fas fa-user"></span> -->
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" required>
          <div class="input-group-append">
            <div class="input-group-text">
             <!--  <span class="fas fa-envelope"></span> -->
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password"  minlength="8" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <!-- <span class="fas fa-lock"></span> -->
            </div>
          </div>
        </div>
         <div class="input-group mb-3">
          <input type="text" class="form-control" name="phoneNumber" pattern="[1-9]{1}[0-9]{9}" title="Enter 10 digit mobile number" required placeholder="Phone Number" required> 

          <div class="input-group-append">
            <div class="input-group-text">
              <!-- <span class="fas fa-user"></span> -->
            </div>
          </div>
          <button class="btn btn-primary" type="button" >Verify</button>
        </div>
        <!--<div class="input-group mb-3">-->
        <!--<select class="form-control" name="numberVerified" required placeholder="Number Verified">-->
        <!--    <option>Select Option</option>-->
        <!--  <option value="1">Yes</option>-->
        <!--  <option value="2">No</option>-->
        <!--</select>-->
        <!--</div>-->
         <div class="input-group mb-3">
         <textarea class="form-control" rows="3" placeholder="Address" name="address"></textarea>
          <div class="input-group-append">
            <div class="input-group-text">
             <!--  <span class="fas fa-user"></span> -->
            </div>
          </div>
        </div>
        <!-- <div class="input-group mb-3">-->
        <!--  <input type="number" class="form-control" name="total_business" required placeholder="Total Business">-->
        <!--  <div class="input-group-append">-->
        <!--    <div class="input-group-text">-->
             <!--  <span class="fas fa-user"></span> -->
        <!--    </div>-->
        <!--  </div>-->
        <!--</div>-->
        <!-- <div class="input-group mb-3">-->
        <!--  <input type="number" class="form-control" name="total_products" required placeholder="Total Products">-->
        <!--  <div class="input-group-append">-->
        <!--    <div class="input-group-text">-->
             <!--  <span class="fas fa-user"></span> -->
        <!--    </div>-->
        <!--  </div>-->
        <!--</div>-->
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
              <label for="agreeTerms">
               I agree to the <a href="#">Terms & Conditions</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary newbtn_one btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!--<div class="social-auth-links text-center">-->
      <!--  <p>- OR -</p>-->
      <!--  <a href="#" class="btn btn-block btn-primary">-->
      <!--    <i class="fab fa-facebook mr-2"></i>-->
      <!--    Sign up using Facebook-->
      <!--  </a>-->
      <!--  <a href="#" class="btn btn-block btn-danger">-->
      <!--    <i class="fab fa-google-plus mr-2"></i>-->
      <!--    Sign up using Google+-->
      <!--  </a>-->
      <!--</div>-->

      <a href="<?=base_url()?>welcome/login" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->


       
  </body>

</html>

