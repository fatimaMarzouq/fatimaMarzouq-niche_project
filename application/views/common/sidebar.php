 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  

<style type="text/css">

.img-circle.profile_img

{

  width: 70%;

background: #fff;

margin-left: 15%;

z-index: 1000;

position: inherit;

margin-top: 20px;

border: 1px solid rgba(52,73,94,.44);

}
.clear_one
{
  font-size: 20px;
    text-align: center;
    color: #fff;
    font-weight: bold;
}
/*.new_clear
{
  border-top: 1px solid #ccc;
}*/

.profile_info

{

  padding: 35px 0px;

}
.site_title
{
  height: auto ! important;
  background: #fff ! important;
  padding: 7px 10px ! important;
}
.left_col
{
  background-color: #055798 ! important;
}
.nav_title
{
  background-color: #055798 ! important;
}
body .container.body .right_col
{
  background-color: rgb(244,249,255) ! important;
}
.main_container
{
  background-color: #055798 ! important;
}
.nav_menu
{
  background-color: #000 ! important;
  border-bottom: 1px #000 ! important;
  /*background-color: rgb(0,185,249) ! important;
  border-bottom: 1px rgb(0,185,249) ! important;*/
}
.nav.navbar-nav>li>a {
    color: #fff!important;
}
.toggle a i {
    color: #fff ! important;
}
.nav.navbar-nav>li>a:hover
{
  background-color:#055798 ! important;
}
.top_nav .nav .open>a
{
  background-color:#055798 ! important;
}

</style>

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="#" class="site_title">

                
                <img src="<?= site_url()?>images/logo_one.png">

                <!-- <span> Work </span> --></a>

            </div>

            <!-- menu profile quick info -->

            <div class="clearfix"></div>



             <div class="profile clearfix new_clear">
             <!--  <h1 class="clear_one">NICHEFAS</h1> -->

              <div class="profile_pic">


              </div>

             <!--  <div class="profile_info">


              </div> -->

            </div>





            

            <!-- <div class="profile clearfix">

              <div class="profile_pic" >

                <img src="<?=site_url()?>upload/<?php echo $this->session->userdata('image');?>" height="60px" width="60px" style="margin-left: 20px;margin-top: 20px;" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span> Welcome </span>

                <h2><?php //echo $this->session->userdata('username');?></h2>

              </div>

            </div> -->

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

              <div class="menu_section">

                <!-- <h3>General</h3> -->

                <ul class="nav side-menu">

                  <li><a href="<?=site_url('welcome/index')?>"><i class="fa fa-dashboard"></i> Dashboard <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    </ul>

                  </li>

               

                 <?php if($this->session->userdata('role') == 1){ ?>

                <li>
                      <a href="<?=site_url('welcome/customer')?>"><i class="fa fa-bar-chart"></i>Users <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
              <li>
                      <a href="<?=site_url('product/product')?>"><i class="fa fa-bar-chart"></i>Master1 <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                    <li>
                      <a href="<?=site_url('product/master2')?>"><i class="fa fa-bar-chart"></i>Master2 <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                  <li>
                      <a href="<?=site_url('product/master3')?>"><i class="fa fa-bar-chart"></i>Master3 <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                     <li>
                      <a href="<?=site_url('product/outlet_master')?>"><i class="fa fa-bar-chart"></i>Outlet Master <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                   <li><a href="<?=site_url('welcome/roles')?>"><i class="fa fa-bar-chart"></i> Roles <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    </ul>

                  </li>
                  <?php } ?>

                   <li>
                      <a href="<?=site_url('product/sellout_list')?>"><i class="fa fa-bar-chart"></i>Sellout <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                   <li>
                      <a href="<?=site_url('product/stock_out_list')?>"><i class="fa fa-bar-chart"></i>Stock Out<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                   <li>
                      <a href="<?=site_url('product/display_by_model_count_list')?>"><i class="fa fa-bar-chart"></i>Display by Model Count <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                   <li>
                      <a href="<?=site_url('product/display_share_list')?>"><i class="fa fa-bar-chart"></i>Display Share <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                   <li>
                      <a href="<?=site_url('product/special_fixture_count_list')?>"><i class="fa fa-bar-chart"></i>Special Fixture Count <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                   <li>
                      <a href="<?=site_url('product/brand_promoter_count_list')?>"><i class="fa fa-bar-chart"></i>Brand Promoter Count <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                   <li>
                      <a href="<?=site_url('product/price_tracker_list')?>"><i class="fa fa-bar-chart"></i>Price Tracker <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                   <li>
                      <a href="<?=site_url('product/market_sensing_list')?>"><i class="fa fa-bar-chart"></i>Market Sensing <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                   <li>
                      <a href="<?=site_url('product/store_image_list')?>"><i class="fa fa-bar-chart"></i>360 Store Image <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                   <li>
                      <a href="<?=site_url('product/display_and_deployment_tracker_list')?>"><i class="fa fa-bar-chart"></i>Display and Deployment Tracker <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                   <li>
                      <a href="<?=site_url('product/voc_list')?>"><i class="fa fa-bar-chart"></i>VOC <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                   <li>
                      <a href="<?=site_url('product/market_issues_list')?>"><i class="fa fa-bar-chart"></i>Market Issues <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                     <li>
                      <a href="<?=site_url('product/training_tracker_list')?>"><i class="fa fa-bar-chart"></i>Training Tracker<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                    <li>
                      <a href="<?=site_url('product/images_list')?>"><i class="fa fa-bar-chart"></i>Photo<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                     <li>
                      <a href="<?=site_url('welcome/profile')?>"><i class="fa fa-bar-chart"></i>Profile <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                    <li>
                      <a href="<?=site_url('product/journey_plan')?>"><i class="fa fa-bar-chart"></i>Journey Plan <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                   <li>
                      <a href="<?=site_url('welcome/msg_list')?>"><i class="fa fa-bar-chart"></i>Message <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu"></ul>
                  </li>
                  



                </ul>

              </div>

            </div>



             <!--  <div class="sidebar-footer hidden-small">

              <a data-toggle="tooltip" data-placement="top" title="Settings">

                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>

              </a>

              <a data-toggle="tooltip" data-placement="top" title="FullScreen">

                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>

              </a>

              <a data-toggle="tooltip" data-placement="top" title="Lock">

                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>

              </a>

              <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?=base_url('welcome/logout')?>">

                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>

              </a>

            </div> -->

                      </div>

        </div>