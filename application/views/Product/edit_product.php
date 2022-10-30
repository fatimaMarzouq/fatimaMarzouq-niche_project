

<div class="right_col" role="main">

<div class="row">

  <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel">

      <div class="x_title">

        <h2>Edit Product Form </h2>

        <div class="clearfix"></div>

      </div>

      <div class="x_content">

        <div class="grid-body ">

            <div class="col-sm-12" style="margin-bottom:25px;">

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

            </div> 

        </div>

        <br />
         <?php 
                  foreach ($edit_product as $value) {
                      $id=$value['id'];
                      $status = $value['status'];
                    }
              ?>

        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" action="<?=base_url('Product/save_product/'.$id)?>">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product Code<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="productCode" id="productCode" required="required" class="form-control col-md-7 col-xs-12" readonly placeholder="Enter Product Code" value="<?php echo $value['productCode']; ?>">

            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Address<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
    <textarea class="form-control col-md-7 col-xs-12" rows="3" placeholder="Address" name="address" required="required"><?php echo $value['address']; ?></textarea>

            </div>
                   </div>    
                   
                    <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Available From <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="date" name="availableFrom" id="availableFrom" required="required" class="form-control col-md-7 col-xs-12"  value="<?php echo $value['availableFrom']; ?>" placeholder="Enter Available From">
            </div>
          </div>
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Height (meters) <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="height" id="height" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Height"  value="<?php echo $value['height']; ?>">
            </div>
          </div> 
          
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Width (meters) <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="width" id="width" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Width"  value="<?php echo $value['width']; ?>">
            </div>
          </div>
          
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product Type <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                
              <select name="productType" required="required" class="form-control col-md-7 col-xs-12">
                  <option value="1" <?php if($value['productType']=='1'){echo "selected";} ?>>LCD/LED</option>
                <option value="2" <?php if($value['productType']=='2'){echo "selected";} ?>>Normal</option>
                <option value="3" <?php if($value['productType']=='3'){echo "selected";} ?>>Auto</option>
                <option value="4" <?php if($value['productType']=='4'){echo "selected";} ?>>Mail</option>
                <option value="5" <?php if($value['productType']=='5'){echo "selected";} ?>>Others</option>
                
               
              </select>
            </div>
          </div>
          
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Available To </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="date" name="availableTo" id="availableTo"  class="form-control col-md-7 col-xs-12" placeholder="Enter Available To"  value="<?php echo $value['availableTo']; ?>">
            </div>
          </div>
 <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Price (INR.) <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="price" id="price" required="required" value="<?php echo $value['price']; ?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Product Price">
            </div>
          </div>
          
          
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">GSTIN <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="gstin" id="gstin" required="required" value="<?php echo $value['gstin']; ?>" class="form-control col-md-7 col-xs-12" placeholder="Enter GSTIN">
            </div>
          </div>
          
             <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Discount (INR.) </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="discount" id="discount"  class="form-control col-md-7 col-xs-12"  value="<?php echo $value['discount']; ?>" placeholder="Enter Discount">
            </div>
          </div>
          
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Image </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="file" name="image"  class="form-control col-md-7 col-xs-12">
              <img src="<?php echo base_url().'/'.$value['productImage']; ?>" width="150" height="150"/>
            </div>
                </div>
          
                   <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Include Printing </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select name="includePrinting"  class="form-control col-md-7 col-xs-12">
                        <option value="1" <?php if($value['includePrinting']=='1'){echo "selected";} ?>>Yes</option>
                        <option value="0" <?php if($value['includePrinting']=='0'){echo "selected";} ?>>No</option>
                      </select>
                    </div>
                  </div>
                  
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Location </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="location" id="location" value="<?php echo $value['location']; ?>"  class="form-control col-md-7 col-xs-12" placeholder="Enter Location">
              <input type="hidden" name="lat" id="lat" value="<?php echo $value['lat']; ?>"  class="form-control col-md-7 col-xs-12" placeholder="Enter Location">
                                                        <input type="hidden" value="<?php echo $value['lng']; ?>"  name="lng" id="lng" class="form-control col-md-7 col-xs-12" placeholder="Enter Location">
            </div>
          </div>
          
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Other Information </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
             

              <textarea class="form-control col-md-7 col-xs-12" rows="3" placeholder="Enter Other Information" name="otherInformation" id="otherInformation"><?php echo $value['otherInformation']; ?></textarea>
            </div>
          </div>
          

                      <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="status" required="required" class="form-control col-md-7 col-xs-12">
                <option value="1" <?php if($status=='1'){echo "selected";} ?>>Available</option>
                <option value="0" <?php if($status=='0'){echo "selected";} ?>>Not Available</option>
              </select>
            </div>
          </div>
          
          <div class="ln_solid"></div>

          <div class="form-group">

            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

            <a href="<?=site_url('Product/product')?>">

              <button class="btn btn-primary" type="button">Back</button></a>

              <input type="submit" name="Add" value="Update" class="btn btn-success">

            </div>

          </div>



        </form>

      </div>

    </div>

  </div>

</div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCZK_rggG8b6WQdsR8K8KzKftc9-wRb8A&libraries=places"></script>
<script >
// $(document).ready(function () {
//   google.maps.event.addDomListener(window, 'load', initialize);
// });

// function initialize() {
//     var input = document.getElementById('location');
//     var autocomplete = new google.maps.places.Autocomplete(input);
// }

 function initialize() {
          var input = document.getElementById('location');
          var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                document.getElementById('city2').value = place.name;
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('lng').value = place.geometry.location.lng();
            });
        }
          $(document).ready(function () {
        google.maps.event.addDomListener(window, 'load', initialize);
          });
</script>