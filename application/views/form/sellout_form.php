
    <?php 
    function random_chars($length = 5)
    {
        $chars      = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $rand_chars = substr( str_shuffle( $chars ), 0, $length );
        return $rand_chars;
    }
    ?>
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
                   <div class=" w-50"><label for="name" class="cate_one"><?= $this->lang->line('name');?> <span class="text-red">*</span></label><input type="text" class="form-control" name="name" id="name" required></div>
                   <div class=" w-50"><label class="cate_one"><?= $this->lang->line('contact_number');?> <span class="text-red">*</span></label><input type="text" class="form-control" name="contact_number"  id="contact_number" required></div>
                 </div>
                 
                 <div class="d-flex flex-md-column gap-2">
                    <div class="w-lg-50"><label class="cate_one"><?= $this->lang->line('email');?> <span class="text-red">*</span></label><input type="email" class="form-control" name="email" id="email" required></div>
                    <div class="w-lg-50">
                      <label class="cate_one"><?= $this->lang->line('user_sales');?></label>
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
                        <label  class="cate_one"><?= $this->lang->line('customer_feed');?> <span class="text-red">*</span></label>
                        <div class=""><textarea class="form-control" name="feedback" id="feedback" style="resize: none;" required></textarea></div>
                      </div>
                      <div class="w-lg-50">
                          <label for="invoice_image" class="cate_one">
                            <?= $this->lang->line('invoice_image');?>
                            <span class="text-red">*</span>
                            <img id="blah" src="<?= site_url()?>images/camera-icon.png">
                            <input type="file" class="form-control" name="invoice_image" id="invoice_image" style="display:none" required>
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
<div id="report_container" class="form-div d-flex gap-2 flex-column">
<?php $rand=random_chars(); ?>
    
    <div class="report d-flex gap-2 flex-column" id="report">
      <input type="hidden" class="form-control" value="<?= $rand; ?>" name="reports_ids[]">
      <div class="d-flex flex-column gap-2">
      <div class=""><label class="cate_one"><?= $this->lang->line('category');?> <span class="text-red">*</span></label>
      <select class="form-control" name="category-<?= $rand; ?>" id="category" required>
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
      <div class=""><label class="cate_one"><?= $this->lang->line('brand');?> <span class="text-red">*</span></label>
      <select class="form-control" name="brand-<?= $rand?>" id="brand" required>
        <option value="" disabled selected><?= $this->lang->line('choose_brand');?></option>
      </select>
      </div>
      </div>
      <div class="d-flex gap-2">
      <div class="w-50"><label class="cate_one"><?= $this->lang->line('model_number');?> <span class="text-red">*</span></label>
      <select class="form-control" name="model-<?= $rand ?>" id="model" required>
        <option value="" disabled selected><?= $this->lang->line('choose_model_number');?></option>
      </select>
      </div>
  
  
      <div class="w-50"><label class="cate_one"><?= $this->lang->line('quantity');?> <span class="text-red">*</span></label><input type="number" class="form-control" min="0" step="1" name="quantity-<?= $rand; ?>" required></div>
      </div>
      <div class="d-flex gap-2">
      <div class="w-50"><label class="cate_one"><?= $this->lang->line('selling_price');?> <span class="text-red">*</span></label><input type="number" class="form-control selling_price" min="0" step="0.01" name="selling_price-<?= $rand; ?>" required></div>
      <div class="w-50"><label class="cate_one"><?= $this->lang->line('offer_price');?></label><input type="number" class="form-control" min="0" step="0.01" name="offer-<?= $rand; ?>"></div>
      </div>
  </div>
  
</div>
<div class="center_one d-flex justify-content-end gap-2"><button type="button" class="new_button" id="add_report"><?= $this->lang->line('add');?></button></div>

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
function makeid(length=5) {
    var result           = '';
    var characters       = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}
function create_report(){
  let id=makeid();
  let ele=`<div class="report d-flex gap-2 flex-column" id="report">
      <input type="hidden" class="form-control" value="${id}" name="reports_ids[]">
      <div class="d-flex flex-column gap-2">
      <div class=""><label class="cate_one"><?= $this->lang->line('category');?> <span class="text-red">*</span></label>
      <select class="form-control" name="category-${id}" id="category" required>
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
      <div class=""><label class="cate_one"><?= $this->lang->line('brand');?> <span class="text-red">*</span></label>
      <select class="form-control" name="brand-${id}" id="brand" required>
        <option value="" disabled selected><?= $this->lang->line('choose_brand');?></option>
      </select>
      </div>
      </div>
      <div class="d-flex gap-2">
      <div class="w-50"><label class="cate_one"><?= $this->lang->line('model_number');?> <span class="text-red">*</span></label>
      <select class="form-control" name="model-${id}" id="model" required>
        <option value="" disabled selected><?= $this->lang->line('choose_model_number');?></option>
      </select>
      </div>
  
  
      <div class="w-50"><label class="cate_one"><?= $this->lang->line('quantity');?> <span class="text-red">*</span></label><input type="number" class="form-control" min="0" step="1" name="quantity-${id}" required></div>
      </div>
      <div class="d-flex gap-2">
      <div class="w-50"><label class="cate_one"><?= $this->lang->line('selling_price');?> <span class="text-red">*</span></label><input type="number" class="form-control selling_price" min="0" step="0.01" name="selling_price-${id}" required></div>
      <div class="w-50"><label class="cate_one"><?= $this->lang->line('offer_price');?></label><input type="number" class="form-control" min="0" step="0.01" name="offer-${id}"></div>
      </div>
  </div>`
  return ele;
}
function add_report_events(){
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
              parent.find('#model').children().remove().end()
                var brands = JSON.parse(response)["brands"];
                Object.keys(brands).forEach(key => {
                  parent.find('#brand').append('<option >' + brands[key]+ '</option>');
                });
                var models = JSON.parse(response)["models"];
                Object.keys(models).forEach(key => {
                  parent.find('#model').append('<option >' + models[key]+ '</option>');
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
}
  $( document ).ready(function() {
    $("#add_report").click(function(){
    $('#report_container').append( $(create_report()) );
    add_report_events();
  })

  add_report_events();
});
</script>



