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
              <?php 
              
              $sort_item = (empty($_GET['sort']) ? 'id' : $_GET['sort']);$sort_type = (empty($_GET['by']) ? "desc" : $_GET['by']); ?>
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
              <td>
                <a href="
              <?php if($row['visit_status']=="Visited") 
              echo base_url()."form/sellout_detail/".$row['id'];
              else
              echo base_url()."form/sellout_form/".$row['id'];

              ?>"  
              class="btn btn-sm btn-primary text-white">
              Detail
            </a>
          </td>
              <td><?php echo $row['outlet_name'] ? $row['outlet_name']: '-'; ?></td>
              <td><?php echo $row['region'] ? $row['region'] : '-'; ?></td>
              <td><?php echo $row['account_name']; ?></td>
              <td><?php echo $row['visit_status']; ?></td>
                 
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






