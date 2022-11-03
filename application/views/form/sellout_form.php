
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
        <input value="<?php if($result['region']) echo $result['region'];?>" type="hidden" class="form-control" name="region">
            <div class="container w-100 gap-2 d-flex flex-column justify-content-center">
              <div class="d-flex justify-content-around">
                    <div class="d-flex flex-md-column gap-2">
                      <div class="font-bold text-black text-center"><?= $this->lang->line('outlet_name');?>:</div>
                      <div class="text-center"><?php if($result['outlet_name']) echo $result['outlet_name'];?></div>
                    </div>
                    <div class="d-flex flex-md-column gap-2">
                      <div class="font-bold text-black text-center"><?= $this->lang->line('region');?>:</div>
                      <div class="text-center"><?php if($result['region']) echo $result['region'];?></div>
                    </div>
                </div>
                    <div class="d-flex gap-2 flex-md-column justify-content-center">
                      <div class="font-bold text-black text-center"><?= $this->lang->line('date');?>:</div>
                      <div class="text-center"><?php if($result['date']) echo getNumericDateFormat($result['date']);?></div>
                    </div>  
                </div>


<h2 class="ditails_one"><?= $this->lang->line('customer_details');?></h2>
               
               <div class="new_scro">
               <div class="form-div d-flex flex-column gap-2">
                 
                 <div class="d-flex gap-2">
                   <div class=" w-50"><?= $this->lang->line('name');?><input type="text" class="form-control" name="name"></div>
                   <div class=" w-50"><?= $this->lang->line('contact_number');?><input type="text" class="form-control" name="contact_number"></div>
                 </div>
                 
                 <div class="d-flex flex-md-column gap-2">
                    <div class="w-lg-50"><?= $this->lang->line('email');?><input type="email" class="form-control" name="email"></div>
                    <div class="w-lg-50">
                      <?= $this->lang->line('user_sales');?>
                      <input 
                      type="text"
                      class="form-control" 
                      name="user_sale" 
                      id="user_sale" 
                      value=""
                      readonly>
                      </div>
                  </div>
                  <div class="d-flex gap-2 flex-md-column">
                      <div class="w-lg-50">
                        <div class=""><?= $this->lang->line('customer_feed');?></div>
                        <div class=""><textarea class="form-control" name="feedback" style="resize: none;"></textarea></div>
                      </div>
                      <div class="w-lg-50">
                          <label for="invoice_image">
                            <?= $this->lang->line('invoice_image');?>
                            <img id="blah" src="<?= site_url()?>images/camera-icon.png">
                            <input type="file" class="form-control" name="invoice_image" id="invoice_image" style="display:none">
                          </label>
                      </div>
                    </div>
                 <!-- <div>
                   <div class=""><?= $this->lang->line('user_target');?></div>
                   <div class=""> -->
                    <input 
                    type="hidden"
                     class="form-control" 
                     name="user_target" 
                     id="user_target" 
                     value="<?php if($user_target) echo $user_target;?>"
                     readonly>
                   <!-- </div>
                  
                 </div> -->
                 
                 <!-- <div>
                   <div class=""><?= $this->lang->line('sales_analysis');?></div>
                   <div class=""> -->
                   <input 
                    type="hidden"
                     class="form-control" 
                     name="analysis_per" 
                     id="analysis_per" 
                     value=""
                     readonly>
                    <!-- </div>
                  
                 </div> -->
               </div>
               </div>
               <h2 class="ditails_one"><?= $this->lang->line('sellout_report');?></h2>
 <div class="new_scro">
<div class="form-div">
  <div>
    <div class="cate_one"><?= $this->lang->line('category');?></div>
    <div class="cate_one"><?= $this->lang->line('brand');?></div>
    <div class="cate_one"><?= $this->lang->line('model_number');?></div>
    <div class="cate_one"><?= $this->lang->line('quantity');?></div>
    <div class="cate_one"><?= $this->lang->line('selling_price');?></div>
     <div class="cate_one"><?= $this->lang->line('offer_price');?></div>
  </div>
  <?php for($i=1;$i<=4;$i++){?>
    <tr class="report">
    <div>
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
  </div>
    <div>
      <select class="form-control" name="brand-<?php echo $i?>" id="brand">
        <option value="" disabled selected><?= $this->lang->line('choose_brand');?></option>
    </select>
  </div>
    <div>
      <select class="form-control" name="model-<?php echo $i?>" id="model">
        <option value="" disabled selected><?= $this->lang->line('choose_model_number');?></option>
    </select>
  </div>
    <div><input type="number" class="form-control" min="0" step="1" name="quantity-<?php echo $i?>"></div>
    <div><input type="number" class="form-control selling_price" min="0" step="0.01" name="selling_price-<?php echo $i?>"></div>
    <div><input type="number" class="form-control" min="0" step="0.01" name="offer-<?php echo $i?>"></div>
  </div>
  <?php } ?>
  
</div>
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



