<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 09:28
 */
class Hellux_News_Adminhtml_ListController extends Mage_Adminhtml_Controller_Action {


 public function indexAction()
 {
  $this->_title($this->__('News'))->_title($this->__('Lista aktualności'));
  $this->loadLayout();
  $this->_setActiveMenu('cms/news');
  $this->_addContent($this->getLayout()->createBlock('hellux_news/adminhtml_list_list'));
  $this->renderLayout();
 }

 public function newAction(){
  $this->_title($this->__('News'))->_title($this->__('Dodaj nowy artykuł'));
  $this->loadLayout();
  $this->_setActiveMenu('cms/news');
  $this->_addContent($this->getLayout()->createBlock('hellux_news/adminhtml_list_edit'));
  $this->renderLayout();
 }

 public function editAction()
 {

  //$id = $this->getRequest()->getParam('id');

  $this->_title($this->__('News'))->_title($this->__('Edytuj artykuł'));
  $this->loadLayout();
  $this->_setActiveMenu('cms/news');
  $this->_addContent($this->getLayout()->createBlock('hellux_news/adminhtml_list_edit'));
  $this->renderLayout();
 }


 public function saveAction()
 {

  $article = $this->getRequest()->getPost();

  if(isset($_FILES['news_thumbnail']['name']) and (file_exists($_FILES['news_thumbnail']['tmp_name']))){

   try {

    $uploader = new Varien_File_Uploader('news_thumbnail');
    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything


    $uploader->setAllowRenameFiles(false);

    // setAllowRenameFiles(true) -> move your file in a folder the magento way
    // setAllowRenameFiles(true) -> move your file directly in the $path folder
    $uploader->setFilesDispersion(false);

    $path = Mage::getBaseDir('skin') . DS . 'frontend' . DS . 'hellux' . DS . 'default' . DS . 'images' . DS .'news' . DS ;

    if (!is_dir($path)) {
     mkdir($path, 0775);
    }

    $uploader->save($path, $_FILES['news_thumbnail']['name']);

    $article['news_thumbnail'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend' . DS . 'hellux' . DS . 'default' . DS . 'images' . DS .'news' . DS . $_FILES['news_thumbnail']['name'];

   }catch(Exception $e) {
    Mage::getSingleton('adminhtml/session')->addError($e);
   }

  }

  $id = $this->getRequest()->getParam('id');

  if(isset($id)){

   Hellux_News_Model_Resource_News::editArticle($article);

  }else{

   Hellux_News_Model_Resource_News::saveArticle($article);

  }

  $this->_title($this->__('News'))->_title($this->__('Lista artykułów'));
  $this->loadLayout();
  $this->_setActiveMenu('cms/news');
  $this->_addContent($this->getLayout()->createBlock('hellux_news/adminhtml_list_list'));
  $this->renderLayout();

 }//end sve action

 public function massDeleteAction()
 {
  $ids = $this->getRequest()->getParam('ids');
  if (!is_array($ids)) {
   $this->_getSession()->addError($this->__('Nie wybrano artykułów do usunięcia.'));
  } else {
   try {
    foreach ($ids as $id) {
     $model = Mage::getSingleton('hellux_news/news')->load($id);
     $model->delete();
    }

    $this->_getSession()->addSuccess(
     $this->__('Usunięto %d artykułów.', count($ids))
    );
   } catch (Mage_Core_Exception $e) {
    $this->_getSession()->addError($e->getMessage());
   } catch (Exception $e) {
    $this->_getSession()->addError(
     Mage::helper('hellux_news')->__('Wystąpił błąd podczas usuwania artykułu(ów).')
    );
    Mage::logException($e);

    return;
   }
  }
  $this->_redirect('*/*/index');
 }//END mass deleteAction

 public function massArchiveAction()
 {
  $ids = $this->getRequest()->getParam('ids');
  if (!is_array($ids)) {
   $this->_getSession()->addError($this->__('Nie wybrano artykułów do przeniesienia.'));
  } else {
   try {
    foreach ($ids as $id) {
     //$model = Mage::getSingleton('hellux_news/news')->load($id);
     //$model->delete();
      Hellux_News_Model_Resource_News::toArchive($id);
    }

    $this->_getSession()->addSuccess(
     $this->__(' %d artykułów przeniesiono do archiwum.', count($ids))
    );
   } catch (Mage_Core_Exception $e) {
    $this->_getSession()->addError($e->getMessage());
   } catch (Exception $e) {
    $this->_getSession()->addError(
     Mage::helper('hellux_news')->__('Wystąpił błąd podczas przenoszenia artykułu(ów).')
    );
    Mage::logException($e);

    return;
   }
  }

  $this->_redirect('*/*/index');
 }//END mass archiveAction

 public function massFromArchiveAction()
 {
  $ids = $this->getRequest()->getParam('ids');
  if (!is_array($ids)) {
   $this->_getSession()->addError($this->__('Nie wybrano artykułów.'));
  } else {
   try {
    foreach ($ids as $id) {
     //$model = Mage::getSingleton('hellux_news/news')->load($id);
     //$model->delete();
     Hellux_News_Model_Resource_News::fromArchive($id);
    }

    $this->_getSession()->addSuccess(
     $this->__(' %d artykułów przywrócono archiwum.', count($ids))
    );
   } catch (Mage_Core_Exception $e) {
    $this->_getSession()->addError($e->getMessage());
   } catch (Exception $e) {
    $this->_getSession()->addError(
     Mage::helper('hellux_news')->__('Wystąpił błąd podczas przywracania artykułu(ów).')
    );
    Mage::logException($e);

    return;
   }
  }

  $this->_redirect('*/*/index');
 }//END mass archiveAction

}