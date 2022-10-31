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
<div class="top-padding">
      <div class="x_panel">
        <div class="x_content">
          <div class="grid-body ">
            <div class="" style="margin-bottom:25px;">
            
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

                <h2 class="ditails_one">Customer Details</h2>
               
<div class="new_scro">
<table >
  
  <tr>
    <td class="sales_one">Name</td>
    <td class="sales_two"><?php if($result['name']) echo $result['name'];?></td>
    
  </tr>
  <tr>
    <td class="sales_one">Contact Number</td>
    <td class="sales_two"><?php if($result['number']) echo $result['number'];?></td>
    
  </tr>
  <tr>
    <td class="sales_one">Email</td>
    <td class="sales_two"><?php if($result['email']) echo $result['email'];?></td>
   
  </tr>
  <tr>
    <td class="sales_one">Customer feed</td>
    <td class="sales_two"><?php if($result['customer_feed']) echo $result['customer_feed'];?></td>
   
  </tr>
  <tr>
    <td class="sales_one">Invoice image</td>
    <td class="sales_two">
        <?php if($result['image_array']){
            
             $add_more_img =unserialize(base64_decode($result['image_array']));
            // echo '<pre>';print_r($add_more_img);
          //  echo $add_more_img[0];
        foreach($add_more_img as $resul){
            //echo $resul;
            ?>
       
        <img src="<?php if($resul) echo $resul;?>" height="90" width="90" style="margin-left:5px;"/>
        <?php }} ?>
    </td>
   
  </tr>
  <tr>
    <td class="sales_one">User Target</td>
    <td class="sales_two"><?php if($result['target']) echo $result['target'];?></td>
   
  </tr>
  <tr>
    <td class="sales_one">User Sales</td>
    <td class="sales_two"><?php if($result['user_sale']) echo $result['user_sale'];?></td>
   
  </tr>
  <tr>
    <td class="sales_one">Sales Analysis</td>
    <td class="sales_two"><?php if($result['analysis_per']) echo $result['analysis_per'];?></td>
   
  </tr>
</table>
</div>

<h2 class="ditails_one">Sellout Report</h2>
 <div class="new_scro">
<table>
  <tr>
    <th class="cate_one">Category</th>
    <th class="cate_one">Brand</th>
    <th class="cate_one">Model Number</th>
    <!--<th class="cate_one">Stock</th>-->
    <th class="cate_one">Quantity</th>
    <th class="cate_one">Selling Price</th>
     <th class="cate_one">Offer Price</th>
  </tr>
   <?php if($result['add_more_array']){
       $add_more_array = unserialize(base64_decode($result['add_more_array']));
       //echo '<pre>';print_r($add_more_array);
        foreach($add_more_array as $resultm){
            $result = json_decode($resultm,true);
            //echo '<pre>';print_r($add_more_ar);
           
            ?>
  <tr>
    <td><?php if($result['category']) echo $result['category'];?></td>
    <td><?php if($result['brand']) echo $result['brand'];?></td>
    <td><?php if($result['model']) echo $result['model'];?></td>
     <!--<td><?php// if($result['stock']) echo $result['stock'];?></td>-->
    <td><?php if($result['quantity']) echo $result['quantity'];?></td>
    <td><?php if($result['selling_price']) echo $result['selling_price'];?></td>
    <td><?php if($result['offer']) echo $result['offer'];?></td>
    
  </tr>
  <?php } } ?>
  
  
</table>
</div>

<div class="center_one"><a href="<?= base_url() ?>form/sellout_list"><button type="button" class="new_button" >Back to Main Menu</button></a></div>



            </div>
          </div>
        
        
        </div>
      </div>
    </div>
 


