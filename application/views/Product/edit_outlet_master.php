

<div class="right_col" role="main">

<div class="row">

  <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel">

      <div class="x_title">

        <h2>Edit Outlet Master Form </h2>

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

        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" action="<?=base_url('Product/update_outlet_master/'.$id)?>">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Unique Code<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="unique_code" id="unique_code" required="required" class="form-control col-md-7 col-xs-12" readonly placeholder="Enter Unique Code" value="<?php echo $value['unique_code']; ?>" readonly>

            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Outlet Name<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="outlet_name" id="outlet_name" required="required" class="form-control col-md-7 col-xs-12"  placeholder="Enter Outlet Name" value="<?php echo $value['outlet_name']; ?>">

            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Region<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" name="region" id="region" required="required" class="form-control col-md-7 col-xs-12"  placeholder="Enter Region" value="<?php echo $value['region']; ?>">

            </div>
          </div>
                   
                   
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Location Name <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="location_name" id="location_name" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Location Name"  value="<?php echo $value['location_name']; ?>">
            </div>
          </div> 
          
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Latitude <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="latitude" id="latitude" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Latitude"  value="<?php echo $value['latitude']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Longitude <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="longitude" id="longitude" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Longitude"  value="<?php echo $value['longitude']; ?>">
            </div>
          </div>
          
                      <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">GPS<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="gps" required="required" class="form-control col-md-7 col-xs-12">
                <option value="1" <?php if($value['gps']=='1'){echo "selected";} ?>>Yes</option>
                <option value="0" <?php if($value['gps']=='0'){echo "selected";} ?>>No</option>
              </select>
            </div>
          </div>
          
          <div class="ln_solid"></div>

          <div class="form-group">

            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

            <a href="<?=site_url('Product/outlet_master')?>">

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