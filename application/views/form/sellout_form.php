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
<form method="post" action="<?=site_url('form/add_sellout')?>">               
          
  <!-- <div class="x_title"> 
<div class="clearfix"></div>
</div>  -->
<div class="x_content">
  <div class="grid-body ">
    <div class="" style="margin-bottom:25px;">

        <div class="container">
          <div class="row">
            <div class="col-md-2 out_one">Outlet Name:</div>
            <div class="col-md-3"><?php if($result['outlet_name']) echo $result['outlet_name'];?><input value="<?php if($result['outlet_name']) echo $result['outlet_name'];?>" type="hidden" class="form-control" name="outlet_name"></div>
              <div class="col-md-2 out_one1">Region:</div>
            <div class="col-md-3"><?php if($result['region']) echo $result['region'];?> <input value="<?php if($result['region']) echo $result['region'];?>" type="hidden" class="form-control" name="region"></div>
            <div class="col-md-2"></div>
          </div>
        </div>
        <input value="<?php if($result['account_name']) echo $result['account_name'];?>" type="hidden" class="form-control" name="account_name">
        <div class="container new_row1">
          <div class="row">
            <div class="col-md-2 out_one2">Date:</div>
            <div class="col-md-3"><?php if($result['date']) echo getNumericDateFormat($result['date']);?></div>
              <div class="col-md-2"></div>
            <div class="col-md-3"></div>
            <div class="col-md-2"></div>
          </div>
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
  <?php for($i=1;$i<=4;$i++){?>
    <tr class="report">
    <td>
      <select class="form-control" name="category-<?php echo $i?>" id="category">
        <option>Choose Category</option>
      <?php 
      if($categories) {
        foreach($categories as $category){
      echo "<option name='".$category."'>".$category."</option>";

        }
      }
    ?>
    </select>
  </td>
    <td>
      <select class="form-control" name="brand-<?php echo $i?>" id="brand">
        <option>Choose Brand</option>
    </select>
  </td>
    <td>
      <select class="form-control" name="model-<?php echo $i?>" id="model">
        <option>Choose Model Number</option>
    </select>
  </td>
    <td><input type="number" class="form-control" min="0" step="1" name="quantity-<?php echo $i?>"></td>
    <td><input type="number" class="form-control" min="0" step="0.01" class="selling_price" name="selling_price-<?php echo $i?>"></td>
    <td><input type="number" class="form-control" min="0" step="0.01" name="offer_price-<?php echo $i?>"></td>
  </tr>
  <?php } ?>
  
</table>
</div>
<h2 class="ditails_one">Customer Details</h2>
               
               <div class="new_scro">
               <table >
                 
                 <tr>
                   <td class="sales_one">Name</td>
                   <td class="sales_two"><input type="text" class="form-control" name="name"></td>
                   
                 </tr>
                 <tr>
                   <td class="sales_one">Contact Number</td>
                   <td class="sales_two"><input type="text" class="form-control" name="contact_number"></td>
                   
                 </tr>
                 <tr>
                   <td class="sales_one">Email</td>
                   <td class="sales_two"><input type="email" class="form-control" name="email"></td>
                  
                 </tr>
                 <tr>
                   <td class="sales_one">Customer feed</td>
                   <td class="sales_two"><input type="text" class="form-control" name="feedback"></td>
                  
                 </tr>
                 <tr>
                   <td class="sales_one">Invoice image</td>
                   <td class="sales_two">
                    <label for="invoice_image">
                    <img src="<?= site_url()?>images/camera-icon.png">
                   <input type="file" class="form-control" name="invoice_image" id="invoice_image" style="display:none">
                  </label>
                   </td>
                  
                 </tr>
                 <tr>
                   <td class="sales_one">User Target</td>
                   <td class="sales_two">
                    <input 
                    type="text"
                     class="form-control" 
                     name="user_target" 
                     id="user_target" 
                     value="<?php if($user_target) echo $user_target;?>"
                     readonly>
                   </td>
                  
                 </tr>
                 <tr>
                   <td class="sales_one">User Sales</td>
                   <td class="sales_two">
                    <input 
                    type="text"
                     class="form-control" 
                     name="user_sale" 
                     id="user_sale" 
                     value=""
                     readonly>
                    </td>
                  
                 </tr>
                 <tr>
                   <td class="sales_one">Sales Analysis</td>
                   <td class="sales_two">
                   <input 
                    type="text"
                     class="form-control" 
                     name="analysis_per" 
                     id="analysis_per" 
                     value=""
                     readonly>
                    </td>
                  
                 </tr>
               </table>
               </div>
               <div class="d-flex justify-content-center">
                  <div class="center_one"><a href="<?= base_url() ?>form/sellout_list"><button type="submit" class="new_button" >Save</button></a></div>
                  <div class="center_one"><a href="<?= base_url() ?>form/sellout_list"><button type="button" class="new_button" >Back to Main Menu</button></a></div>
                </div>

              </form>
            </div>
          </div>
        
        
        </div>
      </div>
    </div>
<script>
      
  $( document ).ready(function() {
    $( ".report" ).each(function(){
      let parent=$(this)
      $(this).find("#category").change(function(){
        let category = $(this).val();
        $.ajax({
            url: "<?= base_url() ?>form/get_brand",
            method: 'POST',
            data: {
                // "_token": $('#csrftoken').val(),
                category: category
            },
            success: function(response) {
              parent.find('#brand').children().remove().end()
                var brands = JSON.parse(response);
                var ss = [];
                Object.keys(brands).forEach(key => {
                  parent.find('#brand').append('<option >' + brands[key]+ '</option>');
                });
            }
        });
      });
      $(this).find("#brand").change(function(){
        let brand = $(this).val();
        $.ajax({
            url: "<?= base_url() ?>form/get_model",
            method: 'POST',
            data: {
                // "_token": $('#csrftoken').val(),
                brand: brand
            },
            success: function(response) {
              parent.find('#model').children().remove().end()
                var models = JSON.parse(response);
                var ss = [];
                Object.keys(models).forEach(key => {
                  parent.find('#model').append('<option >' + models[key]+ '</option>');
                });
            }
        });
      });
    });
    $(".selling_price").change(function() {
  var tot = 0;
  $(".selling_price").each(function() {
    tot += Number($(this).val());
  });
  $('#user_sale').val(tot);
  $("#analysis_per").val(tot/Number($("#user_target").val())) 

});
});
</script>



