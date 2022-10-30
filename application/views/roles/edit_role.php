<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Edit Customer</h2>
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

        <?php foreach ($result as  $value){ $id=$value['id']; } ?>
        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" action="<?=base_url('welcome/save_role/'.$id)?>">

         <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Role<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="role" id="role" required="required" class="form-control col-md-7 col-xs-12" placeholder="Role" value="<?=$value['role']?>">
            </div>
          </div>

         
         

              <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status<span class="required">*</span>

            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">

              <select class="form-control" name="status" required>

                <option value="1"<?php if($value['status']=='1'){echo "selected";} ?>>Active</option>

                <option value="0"<?php if($value['status']=='0'){echo "selected";} ?>>Inactive</option>

              </select>

            </div>

          </div>
            <div class="ln_solid"></div>

            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href="<?=site_url('Welcome/roles')?>">
                <button class="btn btn-primary" type="button">Back</button></a>
                <input type="submit" name="Update" class="btn btn-success"  value="Update">
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>