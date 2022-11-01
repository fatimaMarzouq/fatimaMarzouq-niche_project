
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
                 <th><?= $this->lang->line('action');?></th>
                  <th class="sortable" id="outlet_name"><?= $this->lang->line('outlet_name');?></th>
                  <th class="sortable" id="region"><?= $this->lang->line('region');?></th>
                  <th class="sortable" id="name"><?= $this->lang->line('name');?></th>
                  <th class="cate_one"><?= $this->lang->line('visit_status');?></th>     
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
              <button type="button" class="btn btn-sm btn-primary text-white"><?= $this->lang->line('detail');?></button>
            </a>
          </td>
              <td><?php echo $row['outlet_name'] ? $row['outlet_name']: '-'; ?></td>
              <td><?php echo $row['region'] ? $row['region'] : '-'; ?></td>
              <td><?php echo $row['account_name']; ?></td>
              <td><?php if($row['visit_status']=="Visited") echo $this->lang->line('visited'); else echo $this->lang->line('pending'); ?></td>
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
// function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
//   var R = 6371; // Radius of the earth in km
//   var dLat = deg2rad(lat2-lat1);  // deg2rad below
//   var dLon = deg2rad(lon2-lon1); 
//   var a = 
//     Math.sin(dLat/2) * Math.sin(dLat/2) +
//     Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
//     Math.sin(dLon/2) * Math.sin(dLon/2)
//     ; 
//   var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
//   var d = R * c; // Distance in km
//   return d;
// }

// function deg2rad(deg) {
//   return deg * (Math.PI/180)
// }
// const successCallback = (position) => {
//   sessionStorage.setItem("latitude", position.coords.latitude);
//   sessionStorage.setItem("longitude", position.coords.longitude);
// // sessionStorage.getItem("lastname");
// };

// const errorCallback = (error) => {
//   console.log(error);
// };

// navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
// $(document).ready(function() {
//     $(".custom-tr").each(function(){
//       let lat =$(this).find("input[name='latitude']").val();
//       let long =$(this).find("input[name='longitude']").val();
//       let status =$(this).find("input[name='status']").val();
//       console.log(lat,long);
//       console.log(sessionStorage.getItem("latitude"),sessionStorage.getItem("longitude"));
//       distance=getDistanceFromLatLonInKm(lat,long,sessionStorage.getItem("latitude"),sessionStorage.getItem("longitude"))
//       console.log(distance);
//       if(distance>10 && status!="Visited"){
//         $(this).find("a button").attr('disabled', true)
//         $(this).find("a").attr('href', "/")
//         $(this).find('#disabled-overlay').css("display","block");
//         $(this).find('#disabled-overlay').on("mouseover", function () {
//         $(this).tooltip({title: 'You are not within the store location radius'}).tooltip('show');
//       });
        
//       }

//     });
//   });
</script>





