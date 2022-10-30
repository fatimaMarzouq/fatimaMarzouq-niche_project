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

                <form class="d-flex justify-content-center" method="get" name ="filter_status_id" id="filter_status_id" action="<?= base_url() ?>product/special_fixture_count_list/">
                        
                          
                           <div class="form-group position-relative mb-0">
                              <div class="search-filters px-2 select2-sm">
                                                             <!--<input type="date" name="date" id="date">-->

                                  <input type="text" autocomplete="off" class="form-control newicon_one" id="" value="<?php if (isset($_GET['search_term'])) echo $_GET['search_term'] ?>" placeholder="<?=lang('workorder_search_fil_title');?>" name="search_term">
                              <button onclick="filter()" class="btn btn-search-icon"><i class="fas fa-search"></i></button>
                               <button type="button" class="export_one" id="export_id">Export</button>
                                
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
                 
                  <th class="sortable" id="outlet_name">Outlet Name <span>
                     <i class="fas fa-sort-up <?= ($sort_item == 'outlet_name') ? ($sort_type == "desc" ? "text-muted" : "") : "" ?>"></i>
                     <i class="fas fa-sort-down <?= ($sort_item == 'outlet_name') ? ($sort_type == "asc" ? "text-muted" : "") : "" ?>"></i> 
                     </span></th>
                  <th class="sortable" id="region">Region <span>
                     <!-- <i class="fas fa-sort-up <?= ($sort_item == 'region') ? ($sort_type == "desc" ? "text-muted" : "") : "" ?>"></i>
                     <i class="fas fa-sort-down <?= ($sort_item == 'region') ? ($sort_type == "asc" ? "text-muted" : "") : "" ?>"></i> -->
                     </span></th>
                  <th class="sortable" id="date">Date <span>
                     <!-- <i class="fas fa-sort-up <?= ($sort_item == 'date') ? ($sort_type == "desc" ? "text-muted" : "") : "" ?>"></i>
                     <i class="fas fa-sort-down <?= ($sort_item == 'date') ? ($sort_type == "asc" ? "text-muted" : "") : "" ?>"></i> -->
                     </span></th>
                     <?php 
            if(!empty($result)){
             //  echo '<pre>';print_r($result);
                    foreach($result[0] as $k => $r){
                        if($k != 'outlet_name' && $k != 'region' && $k != 'name' &&  $k != 'images'){
                            if($k != 'add_more_array' && $k != 'add_more_array_count'){
                                echo '<th class="sortable" id="name">'.$k.' </th>';
                            }else{
                               
                                if($k == 'add_more_array_count'){
                                   
                                  
                                    for ($x = 0; $x < $max_count; $x++) {
                                     echo  ' <th class="cate_one">Brand</th>
    <th class="cate_one">Type of fixture</th>
    <th class="cate_one">Count</th>
    <th class="cate_one">Condition of fixture</th>
        <th class="cate_one">Remarks</th>';
                                    } 
                                }
                            }
                        }
                    }
                 
            }
                    
                    ?>
                  <th>Action</th>
               </tr>
            </thead>
           
             <?php
               if(!empty($result)){
                 foreach($result as  $row){ ?>
              
            <tr class="custom-tr">
             
               <td><?php echo $row['outlet_name'] ? $row['outlet_name']: '-'; ?></td>
               <td><?php echo $row['region'] ? $row['region'] : '-'; ?></td>
               <td><?php if($row['date']) echo getNumericDateFormat($row['date']);?></td>
               
                <?php 
            if(!empty($row)){
              
               


               
                    foreach($row as $k => $r){
                      //  echo $r.'</br>';
                      
                        if($k != 'outlet_name' && $k != 'region' && $k != 'name' &&  $k != 'image_array'){
                            if($k != 'add_more_array' && $k != 'add_more_array_count'){
                                echo '<td>'.$r.' </td>';
                            }else{
                               
                                if($k == 'add_more_array_count'){
                               
                                    $add_more_array = unserialize(base64_decode($row['add_more_array']));
                                    $total_count = count($add_more_array);
                                    
                                    $max_data_count = 0;
                                    if($max_count != $total_count){
                                        $max_data_count = $max_count - $total_count;
                                        
                                       // echo $max_data_count = $max_data_count + $total_count;
                                    }
                                    //echo 'cxc========'.$max_data_count;

                                    for ($x = 0; $x < $total_count; $x++) {
                                         $result = json_decode($add_more_array[$x],true);
                                         
                                         ?>
                                        
                                                                         <td><?php if($result['brand']) echo $result['brand'];?></td>
                                        <td><?php if($result['type_fixture']) echo $result['type_fixture'];?></td>
                                        <td><?php if($result['count']) echo $result['count'];?></td>
                                         <!--<td><?php// if($result['stock']) echo $result['stock'];?></td>-->
                                        <td><?php if($result['condition_fixture']) echo $result['condition_fixture'];?></td>
                                        <td><?php if($result['remark']) echo $result['remark'];?></td>
                                       
                                    <?php } 
                                     for ($x = 0; $x < $max_data_count; $x++) {

                                         ?>
                                        
                                                                         <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        
                                        
    <?php
                                    } 
                                }
                            }
                        }
                    }
                 
            }
                    
                    ?>
                    
               <td><a href="<?= base_url(); ?>product/special_fixture_count_detail/<?=$row['id']?>"  class="btn btn-sm btn-primary text-white">Detail</a></td>
            </tr>
             <tr class="hidden">
               <td class="py-1 border-0"></td>
            </tr>
            <form id="filter_status_id" action="<?= base_url() ?>product/special_fixture_count_list/"></form>

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
<form method="post" id="export_table" action="<?= base_url() ?>product/special_fixture_count_list">
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




