<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <a href="<?=base_url('welcome/add_customer')?>">
            <button type="button" class="btn btn-success">Add +</button>
          </a>
          <!-- <a href="<?=base_url('welcome/import_customer')?>">
             <button type="button" class="btn btn-primary">Import Defect list</button>
          </a> -->
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
          <table id="datatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  
              
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php 
                  foreach ($Customers as $value) {
                      $id=$value['id'];
              ?>
              <tr>
                <td><?=ucfirst($value['name']); ?></td>
                <td><?=$value['email']; ?></td>
                <td><?=$value['role_name']; ?></td>
               
              
                <td> 
                   <a href="<?=base_url('welcome/edit_customer/'.$id)?>">
                    <button type="button" class="btn btn-primary">Edit</button>
                  </a>

                  <a href="<?=base_url('welcome/delete_customer/'.$id)?> " onclick="return confirm('are you sure want to delete')">
                    <button type="button"  class="btn btn-danger">Delete</button>
                  </a>
                </td> 
              </tr>
            <?php } ?>

            </tbody>
            <tfoot>
              <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  
              
                  <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<!-- <script type="text/javascript">
$(document).on('click','.status_checks',function(){
      var status = ($(this).hasClass("btn-success")) ? '0' : '1';
      // alert(status)
      var msg = (status=='0')? 'Deactivate' : 'Activate';
      if(confirm("Are you sure to "+ msg)){
        var current_element = $(this);
        url = "<?php echo base_url('Welcome/update_status') ?>";
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
</script>
 -->