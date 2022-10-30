

<div class="right_col" role="main">

<div class="row">

  <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel">

      <div class="x_title">

        <h2>Product Form </h2>

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
$n=10;
function getName($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
  
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
  
    return $randomString;
}

?>
        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" action="<?=base_url('Product/save_product')?>">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product Code<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="productCode" id="productCode" readonly required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Product Code" value="<?php echo 'MOHO'.getName(6);?>">
            </div>
                   </div>

            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Address<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                         <textarea class="form-control col-md-7 col-xs-12" rows="3" placeholder="Address" name="address" required="required"></textarea>

            </div>
                   </div>       
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Available From <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="date" name="availableFrom" id="availableFrom" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Available From">
            </div>
          </div>
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Height (meters) <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="height" id="height" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Height">
            </div>
          </div>
          
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Width (meters) <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="width" id="width" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Width">
            </div>
          </div>
                   
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Product Type <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="productType" required="required" class="form-control col-md-7 col-xs-12">
                <option value="1">LCD/LED</option>
                <option value="2">Normal</option>
                <option value="3">Auto</option>
                <option value="4">Mail</option>
                <option value="5">Others</option>
              </select>
            </div>
          </div>
          
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Available To </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="date" name="availableTo" id="availableTo"  class="form-control col-md-7 col-xs-12" placeholder="Enter Available To">
            </div>
          </div>


              <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Price (INR.) <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="price" id="price" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Price">
            </div>
          </div>
          
          
              <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">GSTIN <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="gstin" id="gstin" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter GSTIN">
            </div>
          </div>
          
             <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Discount (INR.)</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="discount" id="discount"  class="form-control col-md-7 col-xs-12" placeholder="Enter Discount">
            </div>
          </div>
          
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Image </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="file" name="image"  class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Include Printing </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="includePrinting"  class="form-control col-md-7 col-xs-12">
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>
          </div>
          
          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Location</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="location" id="location" class="form-control col-md-7 col-xs-12" placeholder="Enter Location">
                            <input type="hidden" name="lat" id="lat" class="form-control col-md-7 col-xs-12" placeholder="Enter Location">
                                                        <input type="hidden" name="lng" id="lng" class="form-control col-md-7 col-xs-12" placeholder="Enter Location">


            </div>
          </div>
          
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Other Information</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              

              <textarea class="form-control col-md-7 col-xs-12" rows="3" placeholder="Enter Other Information" name="otherInformation" id="otherInformation"></textarea>
            </div>
          </div>
          
          
                      <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="status" required="required" class="form-control col-md-7 col-xs-12">
                <option value="1">Available</option>
                <option value="0"> Not Available</option>
              </select>
            </div>
          </div>
          
          <div class="ln_solid"></div>

          <div class="form-group">

            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

              <a href="<?=site_url('Product/product')?>">

              <button class="btn btn-primary" type="button">Back</button></a>

              <input type="submit" name="Add" value="Add" class="btn btn-success">

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
                //document.getElementById('city2').value = place.name;
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('lng').value = place.geometry.location.lng();
            });
        }
        $(document).ready(function () {
        google.maps.event.addDomListener(window, 'load', initialize);
        });
</script>