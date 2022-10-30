<!DOCTYPE html>

<html lang="en">

  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    

    

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title>Pulp</title>



    <link href="<?=site_url()?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?=site_url()?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <link href="<?=site_url()?>vendors/nprogress/nprogress.css" rel="stylesheet">

    <link href="<?=site_url()?>vendors/animate.css/animate.min.css" rel="stylesheet">



    <link href="<?=site_url()?>build/css/custom.min.css" rel="stylesheet">

  </head>
  <style type="text/css">
      .login
      {
        background-color: rgb(244,249,255) ! important;
      }
      .login_content div .reset_pass
      {
        margin-top: 1px!important;
      }
      .newbtn_one
    {
      background-color: rgb(0,185,249) ! important;
    border-color: rgb(0,185,249) ! important;
    }
    .log_one
    {
        color: rgb(0,185,249) ! important;
    }
    .login_form
    {
      margin-top: 80px;
    }
  </style>
 <style type="text/css">
    @media only screen and (max-width: 768px)
    {
      .login_form
    {
     margin-top: 0px;
    }
    .login_content h1
    {
      font: 400 20px Helvetica,Arial,sans-serif;
    }
    .topnav a.active
      {
        width: 34% ! important;
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



<?php //$this->load->view('msg'); ?>



  <body class="login">
       <div class="topnav" style="width:100%;">
  <a class="active" href="#home">ADMIN LTE</a>
  
</div>


      <a class="hiddenanchor" id="signup"></a>

      <a class="hiddenanchor" id="signin"></a>

       <div class="grid-body " >
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
        </div>

      <div class="login_wrapper">

        <div class="animate form login_form">

          <section class="login_content">

            <form method="post" action="<?=site_url('welcome/password_change')?>">



              <h1>Forgot Password</h1>

              <div>

                <input type="email" class="form-control" name="email" placeholder="Email" required="" />

              </div>



              <div>

               <input type="submit" name="login" value="Send" class="btn btn-primary newbtn_one">

                <a class="reset_pass" href="<?php echo base_url('welcome/login') ?>"><h5 class="log_one">Login</h5></a>

              </div>



              <div class="clearfix"></div>

              <div class="separator">

              </div>

            </form>

          </section>

        </div>

      </div>
      
  </body>

</html>