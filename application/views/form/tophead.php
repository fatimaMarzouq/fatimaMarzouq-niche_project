

<div class="">
<?php
          $language = $this->session->userdata('language');
          $SessionId = $this->session->userdata('id');
          if(empty($SessionId))
          {
            redirect(base_url('form/form_login'));
          }
          $resultSet =  $this->db->query("SELECT * FROM tbl_admin WHERE id = '$SessionId' "); 
          $result = $resultSet->result_array();
          $Image = $result[0]['image'];
          $Username = $result[0]['username'];
          $email = $result[0]['email'];
          $password = $result[0]['password']; 
?>
          <div class="nav_menu">
            <nav>

              <ul class="nav navbar-nav navbar-right">
              <li><a class="font-cairo font-bold" href="<?=site_url('form/switch_language')?>"><?= $this->lang->line('lang');?></a></li>
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php echo $email; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?=site_url('form/form_logout')?>"><i class="fa fa-sign-out pull-right"></i><?= $this->lang->line('logout');?></a></li>
                  </ul>
                </li>
                <!-- <li class="logo_img1"><img src="http://162.144.65.120/~procopbn/nichefas/images/logo_one.png" class="logo_img"></li> -->
            </ul>
              
            </nav>
          </div>
        </div>




