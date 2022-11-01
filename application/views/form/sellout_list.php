<style type="text/css">
   .newicon_one
  {
    display: initial ! important;
    width: 250px ! important;

  }
  .form-group .btn {
    margin-bottom: 4px ! important;
}
.export_one
{
    background-color: #337ab7 ! important;
    border: #2e6da4 ! important;
    float: right;
    height: 31px;
    width: 60px;
    color: #fff;
    border-radius: 4px;
}
.go_one
{
    margin-left: 19px;
    background-color: #337ab7 ! important;
    border: #2e6da4 ! important;
    height: 25px;
    width: 31px;
    color: #fff;
    border-radius: 4px;
}
.end_one
{
  margin-left: 28px;
  margin-top: 20px;
}
.scend_one
{
  margin-top: 20px;
}
.date_one
{
  padding: 6px 12px;
}
.new_bairth
{
  padding: 6px 12px;
}

@media screen and (max-width: 768px)
{
  .newicon_one
  {
    width: 150px ! important;
    margin-left: 10px
  }
  .scend_one
  {
    margin-left: 10px;
  }
  .end_one
  {
    margin-left: 10px;
  }
  .new_bairth
  {
    margin-left: 6px;
   

  }
}
</style>



    <div class="top-padding">
      <div class="x_panel">
        <!-- <div class="x_title">
         
          
          
        <div class="clearfix"></div>
        </div> --> 
        <div class="x_content">
          
           <div style="overflow-x:scroll;width:100%!important">
        
          <table class="table table-striped table-bordered" id="table_list">
            <thead class="thead-dark">              
               <tr>
                 <th>Action</th>
                  <th class="sortable" id="outlet_name">Outlet Name</th>
                  <th class="sortable" id="region">Region</th>
                  <th class="sortable" id="name">Name</th>
                  <th class="cate_one">Visit Status</th>     
               </tr>
            </thead>
           
             <?php
               if(!empty($result)){
                 foreach($result as  $row){ ?>
              
            <tr class="custom-tr">
              <td style="position:relative">
              <div id="disabled-overlay"></div>
                <a href="<?php if($row['visit_status']=="Visited") 
                echo base_url()."form/sellout_detail/".$row['id'];
              else
              echo base_url()."form/sellout_form/".$row['id'];
              ?>"  
              >
              <button type="button" class="btn btn-sm btn-primary text-white">Detail</button>
            </a>
          </td>
              <td><?php echo $row['outlet_name'] ? $row['outlet_name']: '-'; ?></td>
              <td><?php echo $row['region'] ? $row['region'] : '-'; ?></td>
              <td><?php echo $row['account_name']; ?></td>
              <td><?php echo $row['visit_status']; ?></td>
                 <input type="hidden" name="longitude" value="<?php echo $row['longitude'];?>">
                 <input type="hidden" name="latitude" value="<?php echo $row['latitude'];?>">
                 <input type="hidden" name="status" value="<?php echo $row['visit_status'];?>">
            </tr>
             <tr class="hidden">
               <td class="py-1 border-0"></td>
            </tr>

            <?php 
               }
               
               } else
               { echo "<tr  class='custom-tr'><td colspan='9'> " . $message. "</td></tr>";
               }
               ?>
         </table>
          <?= empty($pagination)? '' :$pagination; ?>
          </div>
        </div>
      </div>
    </div>
</form>
<script>
function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1); 
  var a = 
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon/2) * Math.sin(dLon/2)
    ; 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var d = R * c; // Distance in km
  return d;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}
const successCallback = (position) => {
  sessionStorage.setItem("latitude", position.coords.latitude);
  sessionStorage.setItem("longitude", position.coords.longitude);
// sessionStorage.getItem("lastname");
};

const errorCallback = (error) => {
  console.log(error);
};

navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
$(document).ready(function() {
    $(".custom-tr").each(function(){
      let lat =$(this).find("input[name='latitude']").val();
      let long =$(this).find("input[name='longitude']").val();
      let status =$(this).find("input[name='status']").val();
      console.log(lat,long);
      console.log(sessionStorage.getItem("latitude"),sessionStorage.getItem("longitude"));
      distance=getDistanceFromLatLonInKm(lat,long,sessionStorage.getItem("latitude"),sessionStorage.getItem("longitude"))
      console.log(distance);
      if(distance>10 && status!="Visited"){
        $(this).find("a button").attr('disabled', true)
        $(this).find('#disabled-overlay').on("mouseover", function () {
          console.log($(this));
        $(this).tooltip({title: 'You are not within the store location radius'}).tooltip('show');
      });
        
      }

    });
  });
</script>





