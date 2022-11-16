
<div class="top-padding">
      <div class="x_panel">
        <div class="x_content">
          <div class="grid-body ">
            <div class="" style="margin-bottom:25px;">
            
                  <div class="container w-100">
                    <div class="d-flex gap-2">
                      <div class="font-bold text-black"><?= $this->lang->line('outlet_name');?>:</div>
                      <div class=""><?php if($result['outlet_name']) echo $result['outlet_name'];?></div>
                    </div>
                    <div class="d-flex gap-2">
                      <div class="font-bold text-black"><?= $this->lang->line('region');?>:</div>
                      <div class=""><?php if($result['region']) echo $result['region'];?></div>
                    </div>
                    <div class="d-flex gap-2">
                      <div class="font-bold text-black"><?= $this->lang->line('date');?>:</div>
                      <div class=""><?php if($result['date']) echo getNumericDateFormat($result['date']);?></div>
                    </div>  
                </div>


                <h2 class="ditails_one"><?= $this->lang->line('customer_details');?></h2>
               
<div class="new_scro">
<table >
  
  <tr>
    <td class="sales_one"><?= $this->lang->line('name');?></td>
    <td class="sales_two"><?php if($result['name']) echo $result['name'];?></td>
    
  </tr>
  <tr>
    <td class="sales_one"><?= $this->lang->line('contact_number');?></td>
    <td class="sales_two"><?php if($result['number']) echo $result['number'];?></td>
    
  </tr>
  <tr>
    <td class="sales_one"><?= $this->lang->line('email');?></td>
    <td class="sales_two"><?php if($result['email']) echo $result['email'];?></td>
   
  </tr>
  <tr>
    <td class="sales_one"><?= $this->lang->line('customer_feed');?></td>
    <td class="sales_two"><?php if($result['customer_feed']) echo $result['customer_feed'];?></td>
   
  </tr>
  <tr>
    <td class="sales_one"><?= $this->lang->line('invoice_image');?></td>
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
  <!-- <tr>
    <td class="sales_one"><?= $this->lang->line('user_target');?></td>
    <td class="sales_two"><?php //if($result['target']) echo $result['target'];?></td>
   
  </tr> -->
  <tr>
    <td class="sales_one"><?= $this->lang->line('user_sales');?></td>
    <td class="sales_two"><?php if($result['user_sale']) echo $result['user_sale'];?></td>
   
  </tr>
  <!-- <tr>
    <td class="sales_one"><?= $this->lang->line('sales_analysis');?></td>
    <td class="sales_two"><?php //if($result['analysis_per']) echo $result['analysis_per'];?></td>
   
  </tr> -->
</table>
</div>

<h2 class="ditails_one"><?= $this->lang->line('sellout_report');?></h2>
 <div class="new_scro">
<table>
  <tr>
    <th class="cate_one"><?= $this->lang->line('category');?></th>
    <th class="cate_one"><?= $this->lang->line('brand');?></th>
    <th class="cate_one"><?= $this->lang->line('model_number');?></th>
    <th class="cate_one"><?= $this->lang->line('quantity');?></th>
    <th class="cate_one"><?= $this->lang->line('selling_price');?></th>
     <th class="cate_one"><?= $this->lang->line('offer_price');?></th>
  </tr>
   <?php if($result['add_more_array']){
    // print_r($result['add_more_array']);
       $add_more_array = unserialize(base64_decode($result['add_more_array']));
      //  echo '<pre>';print_r($add_more_array); echo '</pre>';
        foreach($add_more_array as $result){
            // $result = json_decode($resultm,true);
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

<div class="center_one"><a href="<?= base_url() ?>form/sellout_list"><button type="button" class="new_button" ><?= $this->lang->line('back');?></button></a></div>



            </div>
          </div>
        
        
        </div>
      </div>
    </div>
 


