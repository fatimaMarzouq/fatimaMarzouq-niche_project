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

        <form method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" action="<?=base_url('welcome/save_customer/'.$result['id'])?>">

         <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
             <input type="text" name="name" id="name" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Name"  value="<?=$result['name']?>">
            </div>
          </div>

          

          <div class="form-group">
            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" readonly name="email" placeholder="Enter Username" value="<?=$result['email']?>">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last_name">Password <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="password" class="form-control" placeholder="Password" name="password"  minlength="6" >

            </div>
          </div>

           <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Role<span class="required">*</span>

            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">

              <select class="form-control" name="role" onchange="show_data(this.value)" id="role" readonly required="required">

                <option style="font-size:10pt" value="">Select Role</option>
             <?php foreach ($roles as $key => $value1) {?>
                <option <?php if ($result['role']==$value1['id']) { echo"selected";}?> value="<?=$value1['id'];?>"><?=$value1['role'];?></option>
                           <?php } ?>         

              </select>

            </div>

          </div>
          
          <div id="mobile_user" style="display:none;">
          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Type<span class="required">*</span>

            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">

              <select class="form-control" name="type" id="type">

                <option value="1" <?php if ($result['type']== 1) { echo"selected";}?>>Promoter</option>

                <option value="2" <?php if ($result['type']== 2) { echo"selected";}?>>Merchandiser</option>

              </select>

            </div>

          </div>
          
          <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Outlet List<span class="required">*</span>

            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">

              <!--<select class="form-control" name="assigned_outlet" id="assigned_outlet">-->

              <!--  <option style="font-size:10pt" value="">Select Outlet</option>-->
              <div class="vertical-scrollable"> 
              <div class="row">
  
                <?php 
                 $assigned_outlet = explode(',',$result['assigned_outlet']);
                foreach ($outlet_list as $key => $value1) {?>
                <!--<option value="<?=$value1['id'];?>"><?=$value1['outlet_name'];?></option>-->
                <div class="col-sm-4">
                 <div class="form-group1">
                  <input type="checkbox" name="assigned_outlet[]" id="<?=$value1['id'];?>" <?php if (in_array($value1['id'],$assigned_outlet)) { echo"checked";}?> value="<?=$value1['id'];?>">
                  <label for="<?=$value1['id'];?>"><?=$value1['outlet_name'];?></label>
                </div>
                </div>
                <?php } ?>  

            </div>
            </div>
              <!--</select>-->
              
              <!--<div class="form-group1">-->
              <!--    <input type="checkbox" id="html">-->
              <!--    <label for="html">HTML</label>-->
              <!--  </div>-->
              <!--  <div class="form-group1">-->
              <!--    <input type="checkbox" id="css">-->
              <!--    <label for="css">CSS</label>-->
              <!--  </div>-->
              <!--  <div class="form-group1">-->
              <!--    <input type="checkbox" id="javascript">-->
              <!--    <label for="javascript">Javascript</label>-->
              <!--  </div>-->

            </div>

          </div>
          
          <div class="form-group" style="margin-top:20px;">

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Form List<span class="required">*</span>

            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">

              <!--<select class="form-control" name="assigned_form" id="assigned_form">-->

              <!-- <option style="font-size:10pt" value="">Select Form</option>-->
               <div class="row" >
             <?php 
              $assigned_form = explode(',',$result['assigned_form']);
             // echo '<pre>';print_r($assigned_form);
              
             foreach ($forms_name as $key => $value1) {
             ?>
                <!--<option value="<?=$value1;?>"><?=$value1;?></option>-->
                <div class="col-sm-6">
                 <div class="form-group1">
                  <input type="checkbox" id="<?=$value1;?>" name="assigned_form[]" <?php if (in_array($value1,$assigned_form)) { echo "checked='checked'";}?> value="<?=$value1;?>">
                  <label for="<?=$value1;?>"><?=$value1;?></label>
                </div>
                </div>
                           <?php } ?>  


              <!--</select>-->
              </div>

            </div>

          </div>
          
          <div class="form-group" >

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Manager<span class="required">*</span>

            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">

              <select class="form-control" name="manager_id" id="manager_id">

                 <option style="font-size:10pt" value="">Select Manager</option>
             <?php foreach ($users_list as $key => $value1) {?>
               <option value="<?=$value1['id'];?>" <?php if ($result['manager_id']== $value1['id']) { echo"selected";}?>><?=$value1['name'];?></option>
                           <?php } ?> 

              </select>

            </div>

          </div>
          
          
             <div class="form-group">
            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Target</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text"  name="target" placeholder="Enter Target" value="<?=$result['target']?>">
            </div>
          </div>
          </div>
          
          
            <div class="ln_solid"></div>

            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href="<?=site_url('Welcome/customer')?>">
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

<script>
    function show_data(val){
     //   alert(val)
        if(val == 2){
            $('#mobile_user').css('display','block');
            $("#type").attr('required', 'required');
             $("#manager_id").attr('required', 'required');
          //  $("#assigned_outlet").attr('required', 'required');
           // $("#assigned_form").attr('required', 'required');
           // $("#manager_id").removeAttr('required');
             //$("#manager_id").val('');

        }else{
            
            
             $('#mobile_user').css('display','none');
             
              $("#type").removeAttr('required');
              $("#manager_id").removeAttr('required');
          //  $("#assigned_outlet").removeAttr('required');
           // $("#assigned_form").removeAttr('required');
            $("#type").val('');
            $("#manager_id").val('');
            $("#assigned_outlet").val('');
            $("#assigned_form").val('');
        }
    }
    
    $(document).ready(function(){
 var role_id = "<?php echo $result['role'];?>";
 
 show_data(role_id);
});
</script>
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
<style>
#role{
    pointer-events:none;
}
</style>