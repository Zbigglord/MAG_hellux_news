<?php

 /**
  * Created by Zbigglord.
  * Date: 2017-04-14
  * Time: 11:28
  */
 class Hellux_News_Block_News extends Mage_Core_Block_Template
 {

  public function __construct()
  {
   parent::__construct();
   $collection = Mage::getModel('hellux_news/news')->getCollection()->setOrder('news_added_date', 'desc');
   $this->setCollection($collection);
  }

  protected function _prepareLayout()
  {
   parent::_prepareLayout();

   $pager = $this->getLayout()->createBlock('hellux_news/pager_pager', 'custom.pager');
   $pager->setAvailableLimit(array(5=>5,10=>10,15=>15,'all'=>'wszystkie'));
   $pager->setCollection($this->getCollection());
   $this->setChild('pager', $pager);
   $this->getCollection()->load();
   return $this;
  }

  public function getPagerHtml()
  {
   return $this->getChildHtml('pager');
  }

 }