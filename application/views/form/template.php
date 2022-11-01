<?php

$this->lang->load('form_lang',$this->session->userdata('language'));
$this->load->view('form/header');
$this->load->view('form/tophead');
$this->load->view($main);
$this->load->view('form/footer');



?>