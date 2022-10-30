

<div class="right_col" role="main">

<div class="row">

  <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="x_panel">

      <div class="x_title">

        <h2>Register Form </h2>

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

        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" action="<?=base_url('welcome/save_msg')?>">

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea type="text" name="msg" id="msg" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Message"></textarea>
            </div>
          </div>

          
        
         
         
          
          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Users List<span class="required">*</span>

            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">

              <!--<select class="form-control" name="assigned_outlet" id="assigned_outlet">-->

              <!--  <option style="font-size:10pt" value="">Select Outlet</option>-->
              <div > 
              <div class="row">
  
                <?php foreach ($user_list as $key => $value1) {?>
                <!--<option value="<?=$value1['id'];?>"><?=$value1['name'];?></option>-->
                <div class="col-sm-4">
                 <div class="form-group1">
                  <input type="checkbox" name="sending_msg_user[]" id="<?=$value1['id'];?>" value="<?=$value1['id'];?>">
                  <label for="<?=$value1['id'];?>"><?=$value1['name'];?></label>
                </div>
                </div>
                <?php } ?>  

            </div>
            </div>
             
            </div>

          </div>
          
         
        
          
          
          
          <div class="ln_solid"></div>

          <div class="form-group">

            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

              <a href="<?=site_url('Welcome/msg_list')?>">

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

<style>
    /* This css is for normalizing styles. You can skip this. */
*, *:before, *:after {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}




.new {
  padding: 50px;
}

.form-group1 {
  display: block;
  margin-bottom: 15px;
}

.form-group1 input {
  padding: 0;
  height: initial;
  width: initial;
  margin-bottom: 0;
  display: none;
  cursor: pointer;
}

.form-group1 label {
  position: relative;
  cursor: pointer;
}

.form-group1 label:before {
  content:'';
  -webkit-appearance: none;
  background-color: transparent;
  border: 2px solid #0079bf;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
  padding: 10px;
  display: inline-block;
  position: relative;
  vertical-align: middle;
  cursor: pointer;
  margin-right: 5px;
}

.form-group1 input:checked + label:after {
  content: '';
  display: block;
  position: absolute;
  top: 2px;
  left: 9px;
  width: 6px;
  height: 14px;
  border: solid #0079bf;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

 .vertical-scrollable{
           height:300px;
  overflow-y: scroll;
  overflow-x: hidden;
        }
</style>