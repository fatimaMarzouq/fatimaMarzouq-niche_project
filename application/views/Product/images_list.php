<style type="text/css">
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



<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <!-- <div class="x_title">
         
          
          
        <div class="clearfix"></div>
        </div> --> 
        <div class="x_content">
          <div class="grid-body ">
            <div class="col-sm-12" style="margin-bottom:7px;">
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

                <form class="d-flex justify-content-center" method="get" name ="filter_status_id" id="filter_status_id" action="<?= base_url() ?>product/images_list/">
                        
                          
                           <div class="form-group position-relative mb-0">
                              <div class="search-filters px-2 select2-sm">
                                                             <!--<input type="date" name="date" id="date">-->

                                  <input type="text" autocomplete="off" class="form-control newicon_one" id="" value="<?php if (isset($_GET['search_term'])) echo $_GET['search_term'] ?>" placeholder="<?=lang('workorder_search_fil_title');?>" name="search_term">
                              <button onclick="filter()" class="btn btn-search-icon"><i class="fas fa-search"></i></button>
                              
                                
                              </div>
                               <label for="birthday" class="scend_one">Start Date:
                              <input type="date" id="from_date" value="<?php if (isset($_GET['from_date'])) echo $_GET['from_date'] ?>" name="from_date" class="date_one"></label>

                              <label for="birthday1" class="end_one">End Date:
                              <input type="date" id="to_date" name="to_date" value="<?php if (isset($_GET['to_date'])) echo $_GET['to_date'] ?>" class="to_date"></label>
                              <button type="button" class="go_one"  onclick="filter()">Go</button>

                           </div>
                           
                           
                         
                       
                        </form>
            </div>
          </div>
                     <div style="overflow-x:scroll;width:100%!important">

          <table class="table table-striped table-bordered" id="table_list">
            <thead class="thead-dark">
              <?php $sort_item = (empty($_GET['sort']) ? 'id' : $_GET['sort']);$sort_type = (empty($_GET['by']) ? "desc" : $_GET['by']); ?>
               <tr>
                    <th class="sortable" id="region">Action</th>
                  <th class="sortable" id="outlet_name">Outlet Name </th>
                  <th class="sortable" id="region">Account Name</th>
                  <th class="sortable" id="date">Region<span>
                    <th class="sortable" id="outlet_name">Date</th>
                  <th class="sortable" id="region">User Name</th>
                  <th class="sortable" id="date">SELLOUT_REPORT<span>
                      <th class="sortable" id="outlet_name">SPECIAL_FIXTURE_COUNT</th>
                  <th class="sortable" id="region">MARKET_SENSING</th>
                  <th class="sortable" id="date">360 Store Image<span>
                      <th class="sortable" id="outlet_name">DIPLAY&DEPLOYMENT TRACKER</th>
                  <th class="sortable" id="region">TRAINING_TRACKER</th>

                  
               </tr>
            </thead>
           
             <?php
               if(!empty($result)){
                 foreach($result as  $row){ 
                  $new_data_id = '';
                  // if($row['form_type'] == 'display_and_deployment_tracker'){
                  //   $new_data_id = $row['ddt_main_id'];
                  // }elseif($row['form_type'] == 'sell_out_report'){
                  //   $new_data_id = $row['st_main_id'];
                  // }elseif($row['form_type'] == 'special_fixture_count'){
                  //   $new_data_id = $row['sfc_main_id'];
                  // }elseif($row['form_type'] == 'market_sensing'){
                  //   $new_data_id = $row['ms_main_id'];
                  // }elseif($row['form_type'] == 'training_tracker'){
                  //   $new_data_id = $row['tt_main_id'];
                  // }elseif($row['form_type'] == '300_store_image'){
                  //   $new_data_id = $row['si_main_id'];
                  // }
                  $new_data_id = $row['main_id'];
                  ?>
              
            <tr class="custom-tr">
            <td><a href="<?= base_url(); ?>product/download_all_file/<?=$new_data_id;?>" >Download</a></td>
               <td><?php echo $row['outlet_name'] ? $row['outlet_name']: '-'; ?></td>
               <td><?php echo $row['account_name'] ? $row['account_name'] : '-'; ?></td>
               <td><?php echo $row['region'] ? $row['region']: '-'; ?></td>
               <td><?php if($row['new_date']) echo getNumericDateFormat1($row['new_date']);?></td>
               
               <td><?php echo $row['user'] ? $row['user'] : '-'; ?></td>
              
                <td><?php 
                if(!empty($row['sellout_report'])){
                  
                    $add_more_array = unserialize(base64_decode($row['sellout_report']));
                   
                    foreach($add_more_array as $k=>$resul){
                        ?>
                        <!-- <a href="<?php if($resul) echo $resul;?>" target="_blank"><?php if($resul) echo $resul;?></a> -->
                        
                         <a href="<?= base_url(); ?>product/show_images/sell_out_report/<?=$row['st_main_id']?>" target="_blank" class="btn btn-sm btn-primary text-white">Photos</a>
                        <?php
                        break;
                        // if((count($images)-1) == $k){
                            
                        // }else{
                        //     echo ',';
                        // }
                        
                                                     
                       
                                
                    } 
                            
                        
                }
                    
                    ?>
                    </td>
                     <td><?php 
                if(!empty($row['special_fixture_count'])){
                  
                    $add_more_array = unserialize(base64_decode($row['special_fixture_count']));
                   // echo '<pre>';print_r( $add_more_array);
                    $imag_val = 0;
                    foreach($add_more_array as $resultm){
                        $result1 = json_decode($resultm,true);
                                         //   echo '<pre>';print_r( $result1);

                        if($result1['images'] && $imag_val == 0){
                            $images = explode(',',$result1['images']);
                            foreach($images as $k=>$resul){
                              $imag_val = 1;
                                ?>
                                <!-- <a href="<?php if($resul) echo $resul;?>" target="_blank"><?php if($resul) echo $resul;?></a> -->
                                <a href="<?= base_url(); ?>product/show_images/special_fixture_count/<?=$row['sfc_main_id']?>" target="_blank" class="btn btn-sm btn-primary text-white">Photos</a>
                                
                                <?php
                                break;
                                if((count($images)-1) == $k){
                                    
                                }else{
                                    echo ',';
                                }
                                
                            }
                        }
                                                         
                       
                                
                    } 
                            
                        
                }
                    
                    ?>
                    </td>
                     <td><?php 
                if(!empty($row['market_sensing'])){
                  
                    $add_more_array = unserialize(base64_decode($row['market_sensing']));
                   // echo '<pre>';print_r( $add_more_array);
                    $imag_val1 = 0;
                    foreach($add_more_array as $resultm){
                        $result1 = json_decode($resultm,true);
                                         //   echo '<pre>';print_r( $result1);

                        if($result1['images'] && $imag_val1 == 0){
                            $images = explode(',',$result1['images']);
                            foreach($images as $k=>$resul){
                              $imag_val = 1;
                                ?>
                                <!-- <a href="<?php if($resul) echo $resul;?>" target="_blank"><?php if($resul) echo $resul;?></a>
                                 -->
                                  <a href="<?= base_url(); ?>product/show_images/market_sensing/<?=$row['ms_main_id']?>" target="_blank" class="btn btn-sm btn-primary text-white">Photos</a>
                                
                                <?php
                                 break;
                                if((count($images)-1) == $k){
                                    
                                }else{
                                    echo ',';
                                }
                                
                            }
                        }
                                                         
                       
                                
                    } 
                            
                        
                }
                    
                    ?>
                    </td>
                     <td><?php 
                if(!empty($row['store_image'])){
                  
                    $add_more_array = unserialize(base64_decode($row['store_image']));
                    //echo '<pre>';print_r( $add_more_array);
                    foreach($add_more_array as $resultm){
                        $result1 = json_decode($resultm,true);
                                         //   echo '<pre>';print_r( $result1);

                        if($result1[0]['entrance_images'] || $result1[0]['appliance_images'] || $result1[0]['oppurtunity_images'] || $result1[0]['other_images'] || $result1[0]['fixture_images']){
                           
                                ?>
                               <a href="<?= base_url(); ?>product/show_images/store_image/<?=$row['si_main_id']?>" target="_blank" class="btn btn-sm btn-primary text-white">Photos</a>
                                
                                
                                <?php
                               
                        }
                                                         
                       
                                
                    } 
                            
                        
                }
                    
                    ?>
                    </td>
                     <td>
                         <?php 
                if(!empty($row['display_and_deployment_tracker'])){
                  
                    $add_more_array = unserialize(base64_decode($row['display_and_deployment_tracker']));
                    //echo '<pre>';print_r( $add_more_array);
                    foreach($add_more_array as $resultm){
                        $result1 = json_decode($resultm,true);
                                         //   echo '<pre>';print_r( $result1);

                        if($result1['images_posm_before'] || $result1['images_posm_after']){
                           
                                ?>
                               <a href="<?= base_url(); ?>product/show_images/display_and_deployment_tracker/<?=$row['ddt_main_id']?>" target="_blank" class="btn btn-sm btn-primary text-white">Photos</a>
                                
                                
                                <?php
                               
                        }
                                                         
                       
                                
                    } 
                            
                        
                }
                    
                    ?>
                    
                    
                    </td>
                    
                    <td><?php 
                if(!empty($row['training_tracker'])){
                  
                    $add_more_array = unserialize(base64_decode($row['training_tracker']));
                     //echo 'kkk';
                    // echo '<pre>';print_r( $add_more_array);
                    $imag_val2 = 0;
                    foreach($add_more_array as $resultm){
                        $result1 = json_decode($resultm,true);
                                           // echo '<pre>';print_r( $result1);

                        if($result1['images'] && $imag_val2 == 0){
                            $images = explode(',',$result1['images']);
                            foreach($images as $k=>$resul){
                              $imag_val = 1;
                                ?>
                                <!-- <a href="<?php if($resul) echo $resul;?>" target="_blank"><?php if($resul) echo $resul;?></a> -->
                                
                                <a href="<?= base_url(); ?>product/show_images/training_tracker/<?=$row['tt_main_id']?>" target="_blank" class="btn btn-sm btn-primary text-white">Photos</a>
                                <?php
                                break;
                                if((count($images)-1) == $k){
                                    
                                }else{
                                    echo ',';
                                }
                                
                            }
                        }
                                                         
                       
                                
                    } 
                            
                        
                }
                    
                    ?>
                    </td>
               
            </tr>
             <tr class="hidden">
               <td class="py-1 border-0"></td>
            </tr>
            <form id="filter_status_id" action="<?= base_url() ?>product/stock_out_list/"></form>

            <?php 
               }
               
               } else
               { echo "<tr  class='custom-tr'><td colspan='9'> " . $message. "</td></tr>";
               }
               ?>
         </table>
          <?= empty($pagination)? '' :$pagination; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



   <?php $export = isset($_POST['export'])? $_POST['export'] :""?>
<?php $from_date =  isset($_GET['from_date']) ? $_GET['from_date'] : "";
                $to_date =  isset($_GET['to_date']) ? $_GET['to_date'] : "";
                ?>
<form method="post" id="export_table" action="<?= base_url() ?>product/images_list">
<input type="hidden" name="export" id="export_input" value='<?=$export;?>'>
<input type="hidden" name="export_header" id="export_header" value="">
<input type="hidden" name="sort" value="<?=$sort_item?>">
<input type="hidden" name="by" value="<?=$sort_type?>">
<input type="hidden" name="record_count" value="<?=$record_count?>">

<input type="hidden" name="from_date" value="<?=$from_date?>">
<input type="hidden" name="to_date" value="<?=$to_date?>">
<input type="hidden" name="search_term" value="<?php if(isset($_GET['search_term'])) echo $_GET['search_term']?>">
</form>

<script>
var sort_change = 0;
    var sorting_field= "";
if (window.location.href.indexOf("asc") > -1) {
     
            sort_change = 1;
                
        }else{
            sort_change = 0;
            
        }
 $('.sortable i').on('click', function(event){
        event.stopPropagation();
    });

    $(".sortable").click(function(event){
      
    var sorting       = event.target.id;
    var a = location.search;
    var url =  window.location.search;

    sorting_field = sorting;

    $('<input>').attr({
        type: 'hidden',
        id : 'sort',
        name: 'sort',
        value: sorting

    }).appendTo('#filter_status_id');

    $('<input>').attr({
        type: 'hidden',
        id: 'by', 
        name: 'by'
    }).appendTo('#filter_status_id');

    var uri = "1";
    var current_uri = $('#filter_status_id').attr('action');

    var lastChar = current_uri.slice(-1);
    if(lastChar === '/'){
          var final_uri = current_uri+uri;  
      }else{
        var final_uri = current_uri+'/'+uri; 
      }
    if (window.location.href.indexOf("sort="+sorting) > -1) {
            if( sort_change == 1 ){

                $('#by').val('desc');
               
                }else{
                $('#by').val('asc');
               
            }
        
        }else{
            $('#by').val('asc');

        }     

    $('#filter_status_id').attr('action', final_uri);

    $('#filter_status_id').submit();

});
function filter()
    {
        $('#filter_status_id').submit();
    }

</script>




