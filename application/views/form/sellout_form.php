
    <div class="top-padding">
      <div class="x_panel">       
<form method="post" action="<?=site_url('form/add_sellout')?>" enctype="multipart/form-data">               
          
  <!-- <div class="x_title"> 
<div class="clearfix"></div>
</div>  -->
<div class="x_content">
  <div class="grid-body ">
    <div class="" style="margin-bottom:25px;">
        <input value="<?php if($result['account_name']) echo $result['account_name'];?>" type="hidden" class="form-control" name="account_name">
        <input value="<?php if($result['outlet_name']) echo $result['outlet_name'];?>" type="hidden" class="form-control" name="outlet_name">
        <input value="<?php if($id) echo $id;?>" type="hidden" class="form-control" name="id">
       <?php if($result['region']) echo $result['region'];?> <input value="<?php if($result['region']) echo $result['region'];?>" type="hidden" class="form-control" name="region">
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
  <?php for($i=1;$i<=4;$i++){?>
    <tr class="report">
    <td>
      <select class="form-control" name="category-<?php echo $i?>" id="category">
        <option value="" disabled selected><?= $this->lang->line('choose_category');?></option>
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
        <option value="" disabled selected><?= $this->lang->line('choose_brand');?></option>
    </select>
  </td>
    <td>
      <select class="form-control" name="model-<?php echo $i?>" id="model">
        <option value="" disabled selected><?= $this->lang->line('choose_model_number');?></option>
    </select>
  </td>
    <td><input type="number" class="form-control" min="0" step="1" name="quantity-<?php echo $i?>"></td>
    <td><input type="number" class="form-control selling_price" min="0" step="0.01" name="selling_price-<?php echo $i?>"></td>
    <td><input type="number" class="form-control" min="0" step="0.01" name="offer-<?php echo $i?>"></td>
  </tr>
  <?php } ?>
  
</table>
</div>
<h2 class="ditails_one"><?= $this->lang->line('customer_details');?></h2>
               
               <div class="new_scro">
               <table >
                 
                 <tr>
                   <td class="sales_one"><?= $this->lang->line('name');?></td>
                   <td class="sales_two"><input type="text" class="form-control" name="name"></td>
                   
                 </tr>
                 <tr>
                   <td class="sales_one"><?= $this->lang->line('contact_number');?></td>
                   <td class="sales_two"><input type="text" class="form-control" name="contact_number"></td>
                   
                 </tr>
                 <tr>
                   <td class="sales_one"><?= $this->lang->line('email');?></td>
                   <td class="sales_two"><input type="email" class="form-control" name="email"></td>
                  
                 </tr>
                 <tr>
                   <td class="sales_one"><?= $this->lang->line('customer_feed');?></td>
                   <td class="sales_two"><input type="text" class="form-control" name="feedback"></td>
                  
                 </tr>
                 <tr>
                   <td class="sales_one"><?= $this->lang->line('invoice_image');?></td>
                   <td class="sales_two">
                    <label for="invoice_image">
                    <img id="blah" src="<?= site_url()?>images/camera-icon.png">
                   <input type="file" class="form-control" name="invoice_image" id="invoice_image" style="display:none">
                  </label>
                   </td>
                  
                 </tr>
                 <!-- <tr>
                   <td class="sales_one"><?= $this->lang->line('user_target');?></td>
                   <td class="sales_two"> -->
                    <input 
                    type="hidden"
                     class="form-control" 
                     name="user_target" 
                     id="user_target" 
                     value="<?php if($user_target) echo $user_target;?>"
                     readonly>
                   <!-- </td>
                  
                 </tr> -->
                 <tr>
                   <td class="sales_one"><?= $this->lang->line('user_sales');?></td>
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
                 <!-- <tr>
                   <td class="sales_one"><?= $this->lang->line('sales_analysis');?></td>
                   <td class="sales_two"> -->
                   <input 
                    type="hidden"
                     class="form-control" 
                     name="analysis_per" 
                     id="analysis_per" 
                     value=""
                     readonly>
                    <!-- </td>
                  
                 </tr> -->
               </table>
               </div>
               <div class="d-flex justify-content-center">
                  <div class="center_one"><a href="<?= base_url() ?>form/sellout_list"><button type="submit" class="new_button" ><?= $this->lang->line('save');?></button></a></div>
                  <div class="center_one"><a href="<?= base_url() ?>form/sellout_list"><button type="button" class="new_button" ><?= $this->lang->line('back');?></button></a></div>
                </div>

              </form>
            </div>
          </div>
        
        
        </div>
      </div>
    </div>
<script>
      invoice_image.onchange = evt => {
  const [file] = invoice_image.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
  $("#blah").css("width","224px")
}
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



