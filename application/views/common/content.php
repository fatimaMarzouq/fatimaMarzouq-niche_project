<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<style type="text/css">
  .new_class
  {
    width: 100% ! important;
  }
</style>



     

        <div class="right_col" role="main">
          <div class="grid-body ">
            <div class="col-sm-12 new_class" style="margin-bottom:25px;">
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
          <div class="row tile_count">

                      	

          
          
           
            <div class="col-md-3 col-sm-4 col-xs-6 ">
                <a href="<?=site_url('Product/sellout_list')?>">
                <div class="dbox dbox--color-1">
                  <div class="dbox__icon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </div>
                  <div class="dbox__body">
                    <span class="dbox__count"><?=$sellout ?></span>
                    <span class="dbox__title">Sellout</span>
                  </div>
                  
                  <div class="dbox__action">
                    <button class="dbox__action__btn"><!-- More Info --></button>
                  </div>     
                  </a>
                </div>
            </div>
            
             <div class="col-md-3 col-sm-4 col-xs-6 ">
                <a href="<?=site_url('Product/display_by_model_count_list')?>">
                <div class="dbox dbox--color-1">
                  <div class="dbox__icon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </div>
                  <div class="dbox__body">
                    <span class="dbox__count"><?=$display_by_model_count ?></span>
                    <span class="dbox__title">Display by Model Count</span>
                  </div>
                  
                  <div class="dbox__action">
                    <button class="dbox__action__btn"><!-- More Info --></button>
                  </div>     
                  </a>
                </div>
            </div>
            
             <div class="col-md-3 col-sm-4 col-xs-6 ">
                <a href="<?=site_url('Product/display_share_list')?>">
                <div class="dbox dbox--color-1">
                  <div class="dbox__icon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </div>
                  <div class="dbox__body">
                    <span class="dbox__count"><?=$display_share ?></span>
                    <span class="dbox__title">Display Share</span>
                  </div>
                  
                  <div class="dbox__action">
                    <button class="dbox__action__btn"><!-- More Info --></button>
                  </div>     
                  </a>
                </div>
            </div>
            
            
             <div class="col-md-3 col-sm-4 col-xs-6 ">
                <a href="<?=site_url('Product/special_fixture_count_list')?>">
                <div class="dbox dbox--color-1">
                  <div class="dbox__icon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </div>
                  <div class="dbox__body">
                    <span class="dbox__count"><?=$special_fixture_count_list ?></span>
                    <span class="dbox__title">Special Fixture Count</span>
                  </div>
                  
                  <div class="dbox__action">
                    <button class="dbox__action__btn"><!-- More Info --></button>
                  </div>     
                  </a>
                </div>
            </div>
            
             <div class="col-md-3 col-sm-4 col-xs-6 ">
                <a href="<?=site_url('Product/brand_promoter_count_list')?>">
                <div class="dbox dbox--color-1">
                  <div class="dbox__icon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </div>
                  <div class="dbox__body">
                    <span class="dbox__count"><?=$brand_promoter_count_list ?></span>
                    <span class="dbox__title">Brand Promoter Count</span>
                  </div>
                  
                  <div class="dbox__action">
                    <button class="dbox__action__btn"><!-- More Info --></button>
                  </div>     
                  </a>
                </div>
            </div>
            
             <div class="col-md-3 col-sm-4 col-xs-6 ">
                <a href="<?=site_url('Product/price_tracker_list')?>">
                <div class="dbox dbox--color-1">
                  <div class="dbox__icon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </div>
                  <div class="dbox__body">
                    <span class="dbox__count"><?=$price_tracker ?></span>
                    <span class="dbox__title">Price Tracker</span>
                  </div>
                  
                  <div class="dbox__action">
                    <button class="dbox__action__btn"><!-- More Info --></button>
                  </div>     
                  </a>
                </div>
            </div>
            
             <div class="col-md-3 col-sm-4 col-xs-6 ">
                <a href="<?=site_url('Product/market_sensing_list')?>">
                <div class="dbox dbox--color-1">
                  <div class="dbox__icon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </div>
                  <div class="dbox__body">
                    <span class="dbox__count"><?=$market_sensing ?></span>
                    <span class="dbox__title">Market Sensing</span>
                  </div>
                  
                  <div class="dbox__action">
                    <button class="dbox__action__btn"><!-- More Info --></button>
                  </div>     
                  </a>
                </div>
            </div>
            
             <div class="col-md-3 col-sm-4 col-xs-6 ">
                <a href="<?=site_url('Product/store_image_list')?>">
                <div class="dbox dbox--color-1">
                  <div class="dbox__icon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </div>
                  <div class="dbox__body">
                    <span class="dbox__count"><?=$store_image ?></span>
                    <span class="dbox__title">300 Store Image</span>
                  </div>
                  
                  <div class="dbox__action">
                    <button class="dbox__action__btn"><!-- More Info --></button>
                  </div>     
                  </a>
                </div>
            </div>
            
             <div class="col-md-3 col-sm-4 col-xs-6 ">
                <a href="<?=site_url('Product/display_and_deployment_tracker_list')?>">
                <div class="dbox dbox--color-1">
                  <div class="dbox__icon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </div>
                  <div class="dbox__body">
                    <span class="dbox__count"><?=$display_and_deployment_tracker ?></span>
                    <span class="dbox__title">Display and Deployment Tracker</span>
                  </div>
                  
                  <div class="dbox__action">
                    <button class="dbox__action__btn"><!-- More Info --></button>
                  </div>     
                  </a>
                </div>
            </div>
            
             <div class="col-md-3 col-sm-4 col-xs-6 ">
                <a href="<?=site_url('Product/voc_list')?>">
                <div class="dbox dbox--color-1">
                  <div class="dbox__icon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </div>
                  <div class="dbox__body">
                    <span class="dbox__count"><?=$voc ?></span>
                    <span class="dbox__title">VOC</span>
                  </div>
                  
                  <div class="dbox__action">
                    <button class="dbox__action__btn"><!-- More Info --></button>
                  </div>     
                  </a>
                </div>
            </div>
            
             <div class="col-md-3 col-sm-4 col-xs-6 ">
                <a href="<?=site_url('Product/market_issues_list')?>">
                <div class="dbox dbox--color-1">
                  <div class="dbox__icon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </div>
                  <div class="dbox__body">
                    <span class="dbox__count"><?=$market_issues ?></span>
                    <span class="dbox__title">Market Issues</span>
                  </div>
                  
                  <div class="dbox__action">
                    <button class="dbox__action__btn"><!-- More Info --></button>
                  </div>     
                  </a>
                </div>
            </div>
            
             <div class="col-md-3 col-sm-4 col-xs-6 ">
                <a href="<?=site_url('Product/training_tracker_list')?>">
                <div class="dbox dbox--color-1">
                  <div class="dbox__icon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </div>
                  <div class="dbox__body">
                    <span class="dbox__count"><?=$training_tracker ?></span>
                    <span class="dbox__title">Training Tracker</span>
                  </div>
                  
                  <div class="dbox__action">
                    <button class="dbox__action__btn"><!-- More Info --></button>
                  </div>     
                  </a>
                </div>
            </div>
            
             <div class="col-md-3 col-sm-4 col-xs-6 ">
                <a href="<?=site_url('Product/stock_out_list')?>">
                <div class="dbox dbox--color-1">
                  <div class="dbox__icon">
                    <i class="glyphicon glyphicon-stats"></i>
                  </div>
                  <div class="dbox__body">
                    <span class="dbox__count"><?=$stock_out ?></span>
                    <span class="dbox__title">Stock Out</span>
                  </div>
                  
                  <div class="dbox__action">
                    <button class="dbox__action__btn"><!-- More Info --></button>
                  </div>     
                  </a>
                </div>
            </div>
            
           
            

         
          
          
          
          
          <!--   <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Customers</span>
              <div class="count"><?=$total_customers?></div>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-film"></i> Movies</span>
              <div class="count"> <?=$total_movies?></div>
            </div>
 -->
            <!--  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Defects Completed</span>
              <div class="count"><?=$comp?></div>
            </div>

             <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Defects Progress</span>
              <div class="count"><?=$inprogress?> </div>
            </div> -->


        
            <!-- <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">

              <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>

              <div class="count">123.50</div>

              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>

            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">

              <span class="count_top"><i class="fa fa-user"></i> Total Males</span>

              <div class="count green">2,500</div>

              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>

            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">

              <span class="count_top"><i class="fa fa-user"></i> Total Females</span>

              <div class="count">4,567</div>

              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>

            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">

              <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>

              <div class="count">2,315</div>

              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>

            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">

              <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>

              <div class="count">7,325</div>

              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>

            </div> -->

          </div>

          <!-- /top tiles -->



          <div class="row">


             <!-- <div class="col-md-12">

              
                <div id="piechart" style="width: 100%; height: 500px;"></div>  
            
            
                  <div class="col-md-8">
                    <div id="map" style="width: 100%; height: 400px;"></div>
                     
                  </div>
                  <div class="col-md-4">
                     <div id="show_marker_detail">
                    <div id="show_title"></div>
                    <div id="show_img_loc"></div>
                    
                    </div>
                  </div>

            </div> -->

           <!--  <div class="col-md-12 col-sm-12 col-xs-12">

              <div class="dashboard_graph">



                <div class="row x_title">

                  <div class="col-md-6">

                    <h3>Network Activities <small>Graph title sub-title</small></h3>

                  </div>

                  <div class="col-md-6">

                    <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">

                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>

                      <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>

                    </div>

                  </div>

                </div>



                <div class="col-md-9 col-sm-9 col-xs-12">

                  <div id="chart_plot_01" class="demo-placeholder"></div>

                </div>

                <div class="col-md-3 col-sm-3 col-xs-12 bg-white">

                  <div class="x_title">

                    <h2>Top Campaign Performance</h2>

                    <div class="clearfix"></div>

                  </div>



                  <div class="col-md-12 col-sm-12 col-xs-6">

                    <div>

                      <p>Facebook Campaign</p>

                      <div class="">

                        <div class="progress progress_sm" style="width: 76%;">

                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80"></div>

                        </div>

                      </div>

                    </div>

                    <div>

                      <p>Twitter Campaign</p>

                      <div class="">

                        <div class="progress progress_sm" style="width: 76%;">

                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="60"></div>

                        </div>

                      </div>

                    </div>

                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-6">

                    <div>

                      <p>Conventional Media</p>

                      <div class="">

                        <div class="progress progress_sm" style="width: 76%;">

                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="40"></div>

                        </div>

                      </div>

                    </div>

                    <div>

                      <p>Bill boards</p>

                      <div class="">

                        <div class="progress progress_sm" style="width: 76%;">

                          <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>

                        </div>

                      </div>

                    </div>

                  </div>



                </div>



                <div class="clearfix"></div>

              </div>

            </div>



          </div>

          <br />



          <div class="row">





            <div class="col-md-4 col-sm-4 col-xs-12">

              <div class="x_panel tile fixed_height_320">

                <div class="x_title">

                  <h2>App Versions</h2>

                  <ul class="nav navbar-right panel_toolbox">

                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                    </li>

                    <li class="dropdown">

                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                      <ul class="dropdown-menu" role="menu">

                        <li><a href="#">Settings 1</a>

                        </li>

                        <li><a href="#">Settings 2</a>

                        </li>

                      </ul>

                    </li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>

                    </li>

                  </ul>

                  <div class="clearfix"></div>

                </div>

                <div class="x_content">

                  <h4>App Usage across versions</h4>

                  <div class="widget_summary">

                    <div class="w_left w_25">

                      <span>0.1.5.2</span>

                    </div>

                    <div class="w_center w_55">

                      <div class="progress">

                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 66%;">

                          <span class="sr-only">60% Complete</span>

                        </div>

                      </div>

                    </div>

                    <div class="w_right w_20">

                      <span>123k</span>

                    </div>

                    <div class="clearfix"></div>

                  </div>



                  <div class="widget_summary">

                    <div class="w_left w_25">

                      <span>0.1.5.3</span>

                    </div>

                    <div class="w_center w_55">

                      <div class="progress">

                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 45%;">

                          <span class="sr-only">60% Complete</span>

                        </div>

                      </div>

                    </div>

                    <div class="w_right w_20">

                      <span>53k</span>

                    </div>

                    <div class="clearfix"></div>

                  </div>

                  <div class="widget_summary">

                    <div class="w_left w_25">

                      <span>0.1.5.4</span>

                    </div>

                    <div class="w_center w_55">

                      <div class="progress">

                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">

                          <span class="sr-only">60% Complete</span>

                        </div>

                      </div>

                    </div>

                    <div class="w_right w_20">

                      <span>23k</span>

                    </div>

                    <div class="clearfix"></div>

                  </div>

                  <div class="widget_summary">

                    <div class="w_left w_25">

                      <span>0.1.5.5</span>

                    </div>

                    <div class="w_center w_55">

                      <div class="progress">

                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 5%;">

                          <span class="sr-only">60% Complete</span>

                        </div>

                      </div>

                    </div>

                    <div class="w_right w_20">

                      <span>3k</span>

                    </div>

                    <div class="clearfix"></div>

                  </div>

                  <div class="widget_summary">

                    <div class="w_left w_25">

                      <span>0.1.5.6</span>

                    </div>

                    <div class="w_center w_55">

                      <div class="progress">

                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 2%;">

                          <span class="sr-only">60% Complete</span>

                        </div>

                      </div>

                    </div>

                    <div class="w_right w_20">

                      <span>1k</span>

                    </div>

                    <div class="clearfix"></div>

                  </div>



                </div>

              </div>

            </div>



            <div class="col-md-4 col-sm-4 col-xs-12">

              <div class="x_panel tile fixed_height_320 overflow_hidden">

                <div class="x_title">

                  <h2>Device Usage</h2>

                  <ul class="nav navbar-right panel_toolbox">

                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                    </li>

                    <li class="dropdown">

                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                      <ul class="dropdown-menu" role="menu">

                        <li><a href="#">Settings 1</a>

                        </li>

                        <li><a href="#">Settings 2</a>

                        </li>

                      </ul>

                    </li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>

                    </li>

                  </ul>

                  <div class="clearfix"></div>

                </div>

                <div class="x_content">

                  <table class="" style="width:100%">

                    <tr>

                      <th style="width:37%;">

                        <p>Top 5</p>

                      </th>

                      <th>

                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">

                          <p class="">Device</p>

                        </div>

                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">

                          <p class="">Progress</p>

                        </div>

                      </th>

                    </tr>

                    <tr>

                      <td>

                        <canvas class="canvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>

                      </td>

                      <td>

                        <table class="tile_info">

                          <tr>

                            <td>

                              <p><i class="fa fa-square blue"></i>IOS </p>

                            </td>

                            <td>30%</td>

                          </tr>

                          <tr>

                            <td>

                              <p><i class="fa fa-square green"></i>Android </p>

                            </td>

                            <td>10%</td>

                          </tr>

                          <tr>

                            <td>

                              <p><i class="fa fa-square purple"></i>Blackberry </p>

                            </td>

                            <td>20%</td>

                          </tr>

                          <tr>

                            <td>

                              <p><i class="fa fa-square aero"></i>Symbian </p>

                            </td>

                            <td>15%</td>

                          </tr>

                          <tr>

                            <td>

                              <p><i class="fa fa-square red"></i>Others </p>

                            </td>

                            <td>30%</td>

                          </tr>

                        </table>

                      </td>

                    </tr>

                  </table>

                </div>

              </div>

            </div>





            <div class="col-md-4 col-sm-4 col-xs-12">

              <div class="x_panel tile fixed_height_320">

                <div class="x_title">

                  <h2>Quick Settings</h2>

                  <ul class="nav navbar-right panel_toolbox">

                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                    </li>

                    <li class="dropdown">

                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                      <ul class="dropdown-menu" role="menu">

                        <li><a href="#">Settings 1</a>

                        </li>

                        <li><a href="#">Settings 2</a>

                        </li>

                      </ul>

                    </li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>

                    </li>

                  </ul>

                  <div class="clearfix"></div>

                </div>

                <div class="x_content">

                  <div class="dashboard-widget-content">

                    <ul class="quick-list">

                      <li><i class="fa fa-calendar-o"></i><a href="#">Settings</a>

                      </li>

                      <li><i class="fa fa-bars"></i><a href="#">Subscription</a>

                      </li>

                      <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>

                      <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>

                      </li>

                      <li><i class="fa fa-bar-chart"></i><a href="#">Auto Renewal</a> </li>

                      <li><i class="fa fa-line-chart"></i><a href="#">Achievements</a>

                      </li>

                      <li><i class="fa fa-area-chart"></i><a href="#">Logout</a>

                      </li>

                    </ul>



                    <div class="sidebar-widget">

                        <h4>Profile Completion</h4>

                        <canvas width="150" height="80" id="chart_gauge_01" class="" style="width: 160px; height: 100px;"></canvas>

                        <div class="goal-wrapper">

                          <span id="gauge-text" class="gauge-value pull-left">0</span>

                          <span class="gauge-value pull-left">%</span>

                          <span id="goal-text" class="goal-value pull-right">100%</span>

                        </div>

                    </div>

                  </div>

                </div>

              </div>

            </div> -->



          </div>

        </div>


 <style type="text/css">
  	
.dbox {
    position: relative;
    background: rgb(255, 86, 65);
    background: -moz-linear-gradient(top, rgba(255, 86, 65, 1) 0%, rgba(253, 50, 97, 1) 100%);
    background: -webkit-linear-gradient(top, rgba(255, 86, 65, 1) 0%, rgba(253, 50, 97, 1) 100%);
    background: linear-gradient(to bottom, rgba(255, 86, 65, 1) 0%, rgba(253, 50, 97, 1) 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#ff5641', endColorstr='#fd3261', GradientType=0);
    border-radius: 4px;
    text-align: center;
    margin: 60px 0 50px;
}
.dbox__icon {
    position: absolute;
    transform: translateY(-50%) translateX(-50%);
    left: 50%;
}
.dbox__icon:before {
    width: 75px;
    height: 75px;
    position: absolute;
    background: #fda299;
    background: rgba(253, 162, 153, 0.34);
    content: '';
    border-radius: 50%;
    left: -17px;
    top: -17px;
    z-index: -2;
}
.dbox__icon:after {
    width: 60px;
    height: 60px;
    position: absolute;
    background: #f79489;
    background: rgba(247, 148, 137, 0.91);
    content: '';
    border-radius: 50%;
    left: -10px;
    top: -10px;
    z-index: -1;
}
.dbox__icon > i {
    background: #ff5444;
    border-radius: 50%;
    line-height: 40px;
    color: #FFF;
    width: 40px;
    height: 40px;
	font-size:22px;
}
.dbox__body {
    padding: 50px 20px;
}
.dbox__count {
    display: block;
    font-size: 30px;
    color: #FFF;
    font-weight: 300;
}
.dbox__title {
    font-size: 13px;
    color: #FFF;
    color: rgba(255, 255, 255, 0.81);
}
.dbox__action {
    transform: translateY(-50%) translateX(-50%);
    position: absolute;
    left: 50%;
}
.dbox__action__btn {
    border: none;
    background: #FFF;
    border-radius: 19px;
    padding: 7px 16px;
    text-transform: uppercase;
    font-weight: 500;
    font-size: 11px;
    letter-spacing: .5px;
    color: #003e85;
    box-shadow: 0 3px 5px #d4d4d4;
}


.dbox--color-2 {
    background: rgb(252, 190, 27);
    background: -moz-linear-gradient(top, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
    background: -webkit-linear-gradient(top, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
    background: linear-gradient(to bottom, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#fcbe1b', endColorstr='#f85648', GradientType=0);
}
.dbox--color-2 .dbox__icon:after {
    background: #fee036;
    background: rgba(254, 224, 54, 0.81);
}
.dbox--color-2 .dbox__icon:before {
    background: #fee036;
    background: rgba(254, 224, 54, 0.64);
}
.dbox--color-2 .dbox__icon > i {
    background: #fb9f28;
}

.dbox--color-3 {
    background: rgb(183,71,247);
    background: -moz-linear-gradient(top, rgba(183,71,247,1) 0%, rgba(108,83,220,1) 100%);
    background: -webkit-linear-gradient(top, rgba(183,71,247,1) 0%,rgba(108,83,220,1) 100%);
    background: linear-gradient(to bottom, rgba(183,71,247,1) 0%,rgba(108,83,220,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b747f7', endColorstr='#6c53dc',GradientType=0 );
}
.dbox--color-3 .dbox__icon:after {
    background: #b446f5;
    background: rgba(180, 70, 245, 0.76);
}
.dbox--color-3 .dbox__icon:before {
    background: #e284ff;
    background: rgba(226, 132, 255, 0.66);
}
.dbox--color-3 .dbox__icon > i {
    background: #8150e4;
}
  </style>