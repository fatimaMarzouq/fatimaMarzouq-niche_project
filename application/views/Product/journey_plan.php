<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <!--<a href="<?=base_url('Product/master3')?>">-->
          <!--  <button type="button" class="btn btn-success">Add Product+</button>-->
          <!--</a>-->
          
        
          
          
          
<!--                    <form class=" w-50 mx-auto" action="<?= base_url(); ?>product/import_save" enctype="multipart/form-data" method="post" name="import_form"  style="margin-top: 0%" id="import_form">-->
                        
<!--                        <div class="row">-->
                           
<!--                            <div class="col-md-8">-->
<!--                                <div class="form-group">-->
                                <!-- <div class="custom-file">
<!--  <input type="file" class="custom-file-input" id="customFile">-->
<!--  <label class="custom-file-label" for="customFile">Choose file</label>-->
<!--</div> -->
                                   
<!--                          <label for="motorcycle_import_title">Import Master</label>             -->
<!--                         <div class="custom-file">-->
<!--                                    <input type="file" class="custom-file-input" tabindex="17" name="fileUpload"  id="fileUpload" accept=".xlsx, .xls, .csv" > -->
<!--                                     <label class="custom-file-label" for="motorcycle_import_title">Import</label> -->
<!--                            </div>-->
<!--                                </div>-->
<!--                                <div class="form-group mb-0">-->
<!--                                    <button class="btn btn-primary rounded-2 d-flex ml-auto mt-4">Import</button>-->
<!--                                </div>-->

                              
<!--                            </div>-->
<!--                        </div>  -->
<!--                        <hr>-->
                              
                      
<!--                    </form>-->
                    
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
           <table>
    <tbody><tr>
        <td>To Date:</td>
        <td><input type="date" id="toDate" data-date-format="yyyy-mm-dd" data-plugin="datepicker" placeholder="To Date" onchange="selectDate()"></td>
    </tr>
    <tr>
        <td>From Date:</td>
        <td><input type="date" id="fromDate" data-date-format="yyyy-mm-dd" data-plugin="datepicker" placeholder="From Date" onchange="selectDate()"></td>
    </tr>
</tbody></table>
            <form>
              <!-- <button type="button" class="btn btn-danger" id="del_btn" style="margin-left:5px;"><b>DELETE</b></button> -->
          <table id="datatable333444555" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <!-- <th><input type="checkbox" class="checkAll"/> </th> -->
                  <th>Outlet Name</th>
                  <th>Account Name</th>
                  <th>Region </th>
                  <th>User </th>
                  <th>Date </th>
                  <th>Visit Status</th>
                 <!--  <th>Action</th> -->
                </tr>
              </thead>
              <tbody>
              <?php 
                  foreach ($Product as $value) {
                      $id=$value['id'];
              ?>
              <tr>
                <!--   <td><input type="checkbox" name="remove[]" value="<?=$value['id']?>" /></td> -->

                <td><?=$value['outlet_name']?></td>
                <td><?=$value['account_name']?></td>
                
                <td><?=$value['region']?></td>
                <td><?=$value['user']?></td>
                <td><?php echo date('Y-m-d',strtotime($value['new_date']));?></td>
                             
                <td><?=$value['visit_status']?></td>
                
              </tr>
            <?php } ?>

            </tbody>
            <tfoot>
              <tr>
                  <th>Outlet Name</th>
                  <th>Account Name</th>
                  <th>Region </th>
                  <th>User </th>
                  <th>Date </th>
                  <th>Visit Status</th>
                </tr>
            </tfoot>
          </table>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).on('click','.status_checks',function(){
      var status = ($(this).hasClass("btn-success")) ? '0' : '1';
      // alert(status)
      var msg = (status=='0')? 'Deactivate' : 'Activate';
      if(confirm("Are you sure to "+ msg)){
        var current_element = $(this);
        url = "<?php echo base_url('Product/update_status') ?>";
        $.ajax({
          type:"POST",
          url: url,
          data: {id:$(current_element).attr('data'),status:status},
          success: function(data)
          {  
            
            location.reload();
          }
        });
      }      
    });
$('#del_btn').click(function () {
    $.post("delete_master3_all", $(this).closest('form').serialize(), function (html) {
      alert(html);
        //$('#msg').html(html);
    });
});
 $(document).on('click','.checkAll', function (e) {
            var table = $(this).closest('table');
            table.find(':checkbox').not(this).prop('checked',this.checked);
             
 
        });
</script>
