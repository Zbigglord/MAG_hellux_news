<?php

 /**
  * Created by PhpStorm.
  * User: BBJaga
  * Date: 2017-04-18
  * Time: 13:29
  */
 class Hellux_News_Block_Pager_Pager extends Mage_Page_Block_Html_Pager
 {

  public function __construct()
  {
   parent::__construct();
   $this->setTemplate('news/pager/pager.phtml');
  }


 }