<?php
// if($this->session->userdata('username')==''){

// redirect(base_url('welcome/logout'));

// }

// else{

// $username=$this->session->userdata('username');        

// }
$language = $this->session->userdata('language');

?>
<!DOCTYPE html>

<html lang="<?= $language ?>" dir="<?php if($language=="ar") echo "rtl"; else echo "ltr"; ?>">

  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    

    <!-- Meta, title, CSS, favicons, etc. -->

    

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="<?= site_url()?>images/logo.jpeg" type="image/ico" />



                <title >NICHEFAS</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">     



    <!-- Bootstrap -->

    <link href="<?=site_url()?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->

    <link href="<?=site_url()?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- NProgress -->

    <link href="<?=site_url()?>vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- iCheck -->

    <link href="<?=site_url()?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">

  

    <!-- bootstrap-progressbar -->

    <link href="<?=site_url()?>/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

    <!-- JQVMap -->

    <link href="<?=site_url()?>vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>

    <!-- bootstrap-daterangepicker -->

    <link href="<?=site_url()?>vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">



    <!-- Custom Theme Style -->

    <link href="<?=site_url()?>build/css/custom.min.css" rel="stylesheet">





    <link href="<?=site_url()?>vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <link href="<?=site_url()?>vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">

    <link href="<?=site_url()?>vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">

    <link href="<?=site_url()?>vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

    <link href="<?=site_url()?>vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap');
  <?php if($language=="ar") echo "body,.morris-hover.morris-default-style,.view p,.tagsinput input,span.tag{font-family: Cairo !important;}"; ?>
   .font-bold{
    font-weight:900 !important;
   }
   .font-cairo{
    font-family:Cairo !important
   }
   .text-black {
    color: black;
}
.gap-2 {
    gap: 1em;
}
.gap-4 {
    gap: 2em;
}
  img#blah {
    cursor: pointer;
}
  	ul.msgs-list {
    font-size: 24px;
    list-style: none;
}
footer {
    position: absolute;
    bottom: 0;
    right: 0;
    left: 0;
}
.nav_menu {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
}
.navbar-nav {
    margin: 7.5px 16px;
    display: flex;
    justify-content: flex-end;
    direction:ltr;
}
.text-gray{
  color: #EDEDED;
}
html, body, .main{
  height: 100%;
}
.newspapper_body {
    padding: 20vw 10vw;
}
.d-flex{
    display: flex;
}
.jusify-content-end {
    justify-content: flex-end;
}
.btn-md {
    padding: 10px 30px;
}
.top-padding {
    padding-top: 60px;
}
.justify-content-center{
  justify-content: center;
}
#disabled-overlay{
  display:none;
    position: absolute;        
    top: 0;
    left: 0;
    bottom:0;
    right: 0;
    opacity: 0;
    height: 100%;
    width: 100%;
}
.new_row1
  {
    margin-top: 16px;
  }
  table {
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: inherit;
  padding: 8px;
}

/*tr:nth-child(even) {
  background-color: #dddddd;
}*/
.sales_one
{
  width: 30% ! important;
}
.sales_two
{
  text-align: center ! important;
}
.ditails_one
{
  margin-top: 25px;
  color: #000;
    font-weight: bold;
}
.out_one
{
  width: 11% ! important;
  color: #000;
    font-size: 15px;
    font-weight: bold;
}

.out_one1
{
  width: 7% ! important;
  color: #000;
    font-size: 15px;
    font-weight: bold;
}

.out_one2
{
  width: 5% ! important;
  color: #000;
    font-size: 15px;
    font-weight: bold;
}
.input_one
{
  border:none ! important;
}
.cate_one
{
  font-size: 14px;
  font-weight: bold;
  color: #000;
}
.new_button
{
background-color: #055798;
    color: #fff;
    height: 33px;
    width: 150px;
    border-radius: 4px;
    border: none;
}
.center_one
{
  text-align: center;
    margin-top: 40px;
}

@media screen and (max-width: 768px)
{
  .out_one
{
  width: 100% ! important;
}

.out_one1
{
  width: 100% ! important;
}

.out_one2
{
  width: 100% ! important;
}
.new_scro
{
  width: 100% !important;
    overflow-x: scroll;
}
}
.newicon_one
  {
    display: initial ! important;
    width: 250px ! important;

  }
  .form-group .btn {
    margin-bottom: 4px ! important;
}
.export_one
{
    background-color: #337ab7 ! important;
    border: #2e6da4 ! important;
    float: right;
    height: 31px;
    width: 60px;
    color: #fff;
    border-radius: 4px;
}
.go_one
{
    margin-left: 19px;
    background-color: #337ab7 ! important;
    border: #2e6da4 ! important;
    height: 25px;
    width: 31px;
    color: #fff;
    border-radius: 4px;
}
.end_one
{
  margin-left: 28px;
  margin-top: 20px;
}
.scend_one
{
  margin-top: 20px;
}
.date_one
{
  padding: 6px 12px;
}
.new_bairth
{
  padding: 6px 12px;
}

@media screen and (max-width: 768px)
{
  .newicon_one
  {
    width: 150px ! important;
    margin-left: 10px
  }
  .scend_one
  {
    margin-left: 10px;
  }
  .end_one
  {
    margin-left: 10px;
  }
  .new_bairth
  {
    margin-left: 6px;
   

  }
}
</style>

  </head>



  <body class="nav-md">
      <div class="main">