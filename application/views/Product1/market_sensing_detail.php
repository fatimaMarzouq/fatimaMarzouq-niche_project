<style type="text/css">
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
  text-align: left;
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
    width: 140px;
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
</style>
<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <!-- <div class="x_title">
         
          
          
        <div class="clearfix"></div>
        </div>  -->
        <div class="x_content">
          <div class="grid-body ">
            <div class="" style="margin-bottom:25px;">
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

                <div class="container">
                  <div class="row">
                    <div class="col-md-2 out_one">Outlet Name:</div>
                    <div class="col-md-3"><?php if($result['outlet_name']) echo $result['outlet_name'];?></div>
                     <div class="col-md-2 out_one1">Region:</div>
                    <div class="col-md-3"><?php if($result['region']) echo $result['region'];?></div>
                    <div class="col-md-2"></div>
                  </div>
                </div>

                <div class="container new_row1">
                  <div class="row">
                    <div class="col-md-2 out_one2">Date:</div>
                    <div class="col-md-3"><?php if($result['date']) echo getNumericDateFormat($result['date']);?></div>
                     <div class="col-md-2"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-2"></div>
                  </div>
                </div>

                
                

<h2 class="ditails_one"> Report</h2>
 <div class="new_scro">
<table>
  <tr>
          <th class="cate_one">Brand</th>

    <th class="cate_one">Activity Type</th>
    <th class="cate_one">Remarks</th>
    <th class="cate_one">Photo</th>

  </tr>
   <?php if($result['add_more_array']){
       $add_more_array = unserialize(base64_decode($result['add_more_array']));
       //echo '<pre>';print_r($add_more_array);
        foreach($add_more_array as $resultm){
            $result = json_decode($resultm,true);
            //echo '<pre>';print_r($add_more_ar);
           
            ?>
  <tr>
          <td><?php if($result['brand']) echo $result['brand'];?></td>
    <td><?php if($result['activity_type']) echo $result['activity_type'];?></td>
    <td><?php if($result['remark']) echo $result['remark'];?></td>
    <td> <?php if($result['images']){
                        $images = explode(',',$result['images']);

            // $add_more_img =unserialize(base64_decode($result['image_array']));
            // echo '<pre>';print_r($add_more_img);
          //  echo $add_more_img[0];
        foreach($images as $resul){
            //echo $resul;
            ?>
       
        <img src="<?php if($resul) echo $resul;?>" height="90" width="90" style="margin-left:5px;"/>
        <?php }} ?>
    </td>

  </tr>
  <?php } } ?>
  <!--<tr>-->
  <!--  <td>Select the Cat.</td>-->
  <!--  <td>Select the Brand</td>-->
  <!--  <td>Select the Model No.</td>-->
  <!--   <td>Tick Box</td>-->
  <!--  <td>Num.input</td>-->
  <!--  <td>Num.input By user</td>-->
  <!--  <td>Num.input By user</td>-->
    
  <!--</tr>-->
  
  
</table>
</div>

<div class="center_one"><a href="<?= base_url() ?>product/market_sensing_list"><button type="button" class="new_button" >Back to Main Menu</button></a></div>



            </div>
          </div>
        
        
        </div>
      </div>
    </div>
  </div>
</div>



