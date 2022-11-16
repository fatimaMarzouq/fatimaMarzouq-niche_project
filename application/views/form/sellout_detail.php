
    <?php 
    function random_chars($length = 5)
    {
        $chars      = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $rand_chars = substr( str_shuffle( $chars ), 0, $length );
        return $rand_chars;
    }
    function injectSelectedAttribute($selectedOption, $option_value){
      return strtolower($selectedOption) === strtolower($option_value) ? 'selected="selected"' : '';
    }
    ?>
    <div class="top-padding">
      <div class="x_panel">       
<form method="post" action="<?=site_url('form/update_sellout')?>" enctype="multipart/form-data">               
          
  <!-- <div class="x_title"> 
<div class="clearfix"></div>
</div>  -->
<div class="x_content">
  <div class="grid-body ">
    <div class="" style="margin-bottom:25px;">
        <input value="<?php if($result['account_name']) echo $result['account_name'];?>" type="hidden" class="form-control" name="account_name">
        <input value="<?php if($result['outlet_name']) echo $result['outlet_name'];?>" type="hidden" class="form-control" name="outlet_name">
        <input value="<?php if($id) echo $id;?>" type="hidden" class="form-control" name="id">
        <input value="<?php if($result['id']) echo $result['id'];?>" type="hidden" class="form-control" name="sellout_id">
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
                   <div class=" w-50"><label for="name" class="cate_one"><?= $this->lang->line('name');?> <span class="text-red">*</span></label><input type="text" class="form-control" name="name" id="name" value= "<?php if($result['name']) echo $result['name'];?>" required></div>
                   <div class=" w-50"><label class="cate_one"><?= $this->lang->line('contact_number');?> <span class="text-red">*</span></label><input type="text" class="form-control" name="contact_number" value="<?php if($result['number']) echo $result['number'];?>"  id="contact_number" required></div>
                 </div>
                 
                 <div class="d-flex flex-md-column gap-2">
                    <div class="w-lg-50"><label class="cate_one"><?= $this->lang->line('email');?> <span class="text-red">*</span></label><input type="email" class="form-control" name="email" value="<?php if($result['email']) echo $result['email'];?>" id="email" required></div>
                    <div class="w-lg-50">
                      <label class="cate_one"><?= $this->lang->line('user_sales');?></label>
                      <input 
                      type="text"
                      class="form-control" 
                      name="user_sale" 
                      id="user_sale" 
                      value="<?php if($result['user_sale']) echo $result['user_sale'];?>"
                      readonly>
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
                  <div class="d-flex gap-2 flex-md-column">
                      <div class="w-lg-50">
                        <label  class="cate_one"><?= $this->lang->line('customer_feed');?> <span class="text-red">*</span></label>
                        <div class=""><textarea class="form-control" name="feedback" id="feedback" style="resize: none;" required><?php if($result['customer_feed']) echo $result['customer_feed'];?></textarea></div>
                      </div>
                      <div class="w-lg-50">
                          <label for="invoice_image" class="cate_one">
                            <?= $this->lang->line('invoice_image');?>
                            <span class="text-red">*</span>
                            <?php if($result['image_array']){
                              $add_more_img =unserialize(base64_decode($result['image_array']));
                              foreach($add_more_img as $resul){
                                ?>
                                
                                <img id="blah" src="<?php if($resul) echo $resul;?>" height="90" width="90" style="margin-left:5px;"/>
                                <input type="file" class="form-control" name="invoice_image" id="invoice_image" style="display:none"  accept="image/*" >
                                <?php }} ?>
                          </label>
                          <div class="text-red" id="img-error"></div>
                      </div>
                    </div>
                
               </div>
               </div>
               <h2 class="ditails_one"><?= $this->lang->line('sellout_report');?></h2>
 <div class="new_scro">
<div id="report_container" class="form-div d-flex gap-2 flex-column">
<?php if($result['add_more_array']){
    // print_r($result['add_more_array']);
       $add_more_array = unserialize(base64_decode($result['add_more_array']));
      //  echo '<pre>';print_r($add_more_array); echo '</pre>';
        foreach($add_more_array as $result){
            // $result = json_decode($resultm,true);
            //echo '<pre>';print_r($add_more_ar);
           $rand=random_chars();
            ?>
    <div class="report d-flex gap-2 flex-column" id="report-<?= $rand; ?>">
      <input type="hidden" class="form-control" id="report_id" value="<?= $rand; ?>" name="reports_ids[]">
      <div class="d-flex flex-column gap-2">
        <div class=""><label class="cate_one"><?= $this->lang->line('category');?> <span class="text-red">*</span></label>
          <select class="form-control" name="category-<?= $rand; ?>" id="category" required>
            <option value="" disabled selected><?= $this->lang->line('choose_category');?></option>
          <?php 
          if($categories) {
            foreach($categories as $category){
          echo "<option value='".$category."'".injectSelectedAttribute($result['category'], $category).">".$category."</option>";

            }
          }
          ?>
          </select>
        </div>
        <div class=""><label class="cate_one"><?= $this->lang->line('brand');?> <span class="text-red">*</span></label>
          <select class="form-control" name="brand-<?= $rand?>" id="brand" required>
          <?php if($result['brand']){ 
          echo '<option value="'.$result['brand'].'" selected>'.$result['brand'].'</option>';
          }else{ ?>
          <option value="" disabled selected><?= $this->lang->line('choose_brand');?></option>
          <?php } ?>
          </select>
        </div>
      </div>
      <div class="d-flex gap-2">
        <div class="w-50"><label class="cate_one"><?= $this->lang->line('model_number');?> <span class="text-red">*</span></label>
        <select class="form-control" name="model-<?= $rand ?>" id="model" required>
        <?php if($result['model']){ 
          echo '<option value="'.$result['model'].'" selected>'.$result['model'].'</option>';
          }else{ ?>
          <option value="" disabled selected><?= $this->lang->line('choose_model_number');?></option>
          <?php } ?>
        </select>
        </div>
        <div class="w-50">
          <label class="cate_one"><?= $this->lang->line('quantity');?> <span class="text-red">*</span></label>
          <input type="number" class="form-control" min="0" step="1" name="quantity-<?= $rand; ?>" value="<?php if($result['quantity']) echo $result['quantity'];?>" required>
        </div>
      </div>
      <div class="d-flex gap-2">
        <div class="w-50"><label class="cate_one"><?= $this->lang->line('selling_price');?> <span class="text-red">*</span></label><input type="number" class="form-control selling_price" min="0" step="0.01" name="selling_price-<?= $rand; ?>" value="<?php if($result['selling_price']) echo $result['selling_price'];?>" required></div>
        <div class="w-50"><label class="cate_one"><?= $this->lang->line('offer_price');?></label><input type="number" class="form-control" min="0" step="0.01" name="offer-<?= $rand; ?>" value="<?php if($result['offer']) echo $result['offer'];?>"></div>
      </div>
      <button type="button" class="new_button remove_report"  id="<?= $rand ?>"><?= $this->lang->line('remove');?></button>
    
        </div>
  <?php } } ?>
</div>
<div class="center_one d-flex justify-content-end gap-2"><button type="button" class="new_button" id="add_report"><?= $this->lang->line('add');?></button></div>

</div>
               <div class="d-flex justify-content-center">
                  <div class="center_one"><button type="submit" class="new_button" ><?= $this->lang->line('save');?></button></div>
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
  $("#blah").css("width","auto")
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
  let ele=`<div class="report d-flex gap-2 flex-column" id="report-${id}">
      <input type="hidden" class="form-control" id="report_id" value="${id}" name="reports_ids[]">
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
      <button type="button" class="new_button remove_report"  id="${id}"><?= $this->lang->line('remove');?></button>
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
        let category = parent.find("#category").val();

        $.ajax({
            url: "<?= base_url() ?>form/get_model",
            method: 'POST',
            data: {
                // "_token": $('#csrftoken').val(),
                brand: brand,
                category:category
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
$(".remove_report").click(function(){
    $("#report-"+ $(this).attr("id")).remove();
  });
}
function validateFile() 
        {
            var allowedExtension = ['jpeg', 'jpg', 'png', 'gif'];
            var fileExtension = document.getElementById('invoice_image').value.split('.').pop().toLowerCase();
            var isValidFile = false;

                for(var index in allowedExtension) {

                    if(fileExtension === allowedExtension[index]) {
                        isValidFile = true; 
                        break;
                    }
                }

                if(!isValidFile) {
                    $("#img-error").text('<?= $this->lang->line('allowed_types');?> :*.' + allowedExtension.join(', *.'));
                    $("form").submit(function(e){e.preventDefault();});
                }

                return isValidFile;
        }
  $( document ).ready(function() {
    $("#add_report").click(function(){
    $('#report_container').append( $(create_report()) );
    add_report_events();
  })

  add_report_events();
  $('#invoice_image').on("change", function(){ validateFile(); });
  $("#invoice_image").click(function(){
    $("#img-error").text("");
  });
});

</script>



