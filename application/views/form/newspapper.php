<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<style type="text/css">
  .new_class
  {
    width: 100% ! important;
  }
</style>



     

          <div class="newspapper_body">
            <h1 class="text-gray"><?= $this->lang->line('newspapper');?></h1>
            <ul class="msgs-list text-gray">
            <?php foreach($user_msgs as $msg){
                echo "<li>".$msg["msg"]."</li>";
            } ?>
            </ul>
            <a class="d-flex jusify-content-end" href="<?=base_url('form/sellout_list')?>"><button class="btn btn-md"><?= $this->lang->line('ok');?></button></a>
          </div>

