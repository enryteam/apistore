<?php
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class mobi extends BaseAction
 {
  public $pc;
	public function __construct()
 	{
 		parent::__construct();
    $this->pc = array('ewb'=>array('ico'=>'','barcode'=>array('android'=>'','ios'=>'','wx'=>'','vpp'=>''),'version'=>'1.0.1612'));

 	}

 	public function index()
 	{
   		returnJson('200','Welcome to apistore.51daniu.cn');

 	}
  public function update()
 	{
   		returnJson('200','Welcome to apistore.51daniu.cn');

 	}

}
?>
