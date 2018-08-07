<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:44
 */


 /*=========================================================================================== NOT NEEDED ==*/
class Hellux_News_Adminhtml_SingleController extends Mage_Adminhtml_Controller_Action {

 public function indexAction()
 {
  $this->_title($this->__('Single'))->_title($this->__('Aktualności'));
  $this->loadLayout();
  $this->_setActiveMenu('hellux/news');
  $this->_addContent($this->getLayout()->createBlock('hellux_news/adminhtml_news_news'));
  $this->renderLayout();
 }


 public function massDeleteAction()
 {
  $ids = $this->getRequest()->getParam('ids');
  if (!is_array($ids)) {
   $this->_getSession()->addError($this->__('Zaznacz aktualność(i).'));
  } else {
   try {
    foreach ($ids as $id) {
     $model = Mage::getSingleton('hellux_news/news')->load($id);
     $model->delete();
    }

    $this->_getSession()->addSuccess(
     $this->__('Total of %d record(s) have been deleted.', count($ids))
    );
   } catch (Mage_Core_Exception $e) {
    $this->_getSession()->addError($e->getMessage());
   } catch (Exception $e) {
    $this->_getSession()->addError(
     Mage::helper('hellux_news')->__('An error occurred while mass deleting items. Please review log and try again.')
    );
    Mage::logException($e);

    return;
   }
  }
  $this->_redirect('*/*/index');
 }

 public function editAction()
 {
  $edit_id = '';
  $ids = $this->getRequest()->getParam('ids');
  $_id = $this->getRequest()->getParam('id');//for save and continue hack
  if(isset($_id)){//if ave and continue

   foreach($path as $p ){
    $a = $p['category_ceneo_name'];
   }
   $this->getRequest()->setParam('path',$a);

  }else{//if just edit and save

   if (!is_array($ids)) {
    $this->_getSession()->addError($this->__('Please select (s).'));
   }elseif(count($ids) > 1){
    $this->_getSession()->addError($this->__('Please select only one template.'));
   }else{
    foreach($ids as $id){
     $edit_id = $id;
    }
   }

  }
  $this->getRequest()->setParam('edit_id',$edit_id);
  $this->_title($this->__('News'))->_title($this->__('Edytuj szablon'));
  $this->loadLayout();
  $this->_setActiveMenu('hellux/news');
  $this->_addContent($this->getLayout()->createBlock('hellux_news/adminhtml_single_edit'));
  $this->renderLayout();
  //var_dump($this->getRequest()->getParam('path'));
 }

 public function newAction()
 {
  $this->_title($this->__('Ceneo'))->_title($this->__('Dodaj ścieżkę kategorii'));
  $this->loadLayout();
  $this->_setActiveMenu('hellux/categories');
  $this->_addContent($this->getLayout()->createBlock('hellux_ceneo/adminhtml_categories_edit'));
  $this->renderLayout();
 }

 public function saveAction()
 {
  $redirectBack = $this->getRequest()->getParam('back', FALSE);
  if ($data = $this->getRequest()->getPost()) {

   $id = $this->getRequest()->getParam('id');
   $model = Mage::getModel('hellux_ceneo/categories');
   if ($id) {
    $model->load($id);
    if (!$model->getId()) {
     $this->_getSession()->addError(
      Mage::helper('hellux_ceneo')->__('This Ceneo no longer exists.')
     );
     $this->_redirect('*/*/index');

     return;
    }
   }

   // save model
   try {
    $model->addData($data);
    $this->_getSession()->setFormData($data);
    $model->save();
    $this->_getSession()->setFormData(FALSE);
    $this->_getSession()->addSuccess(
     Mage::helper('hellux_ceneo')->__('The Ceneo has been saved.')
    );
   } catch (Mage_Core_Exception $e) {
    $this->_getSession()->addError($e->getMessage());
    $redirectBack = TRUE;
   } catch (Exception $e) {
    $this->_getSession()->addError(Mage::helper('hellux_ceneo')->__('Unable to save the Ceneo.'));
    $redirectBack = TRUE;
    Mage::logException($e);
   }

   if ($redirectBack) {
    $this->_redirect('*/*/edit', array('id' => $model->getId()));

    return;
   }
  }
  $this->_redirect('*/*/index');
 }

 public function deleteAction()
 {
  if ($id = $this->getRequest()->getParam('id')) {
   try {
    // init model and delete
    $model = Mage::getModel('hellux_ceneo/categories');
    $model->load($id);
    if (!$model->getId()) {
     Mage::throwException(Mage::helper('hellux_ceneo')->__('Unable to find a Ceneo to delete.'));
    }
    $model->delete();
    // display success message
    $this->_getSession()->addSuccess(
     Mage::helper('hellux_ceneo')->__('The Ceneo has been deleted.')
    );
    // go to grid
    $this->_redirect('*/*/index');

    return;
   } catch (Mage_Core_Exception $e) {
    $this->_getSession()->addError($e->getMessage());
   } catch (Exception $e) {
    $this->_getSession()->addError(
     Mage::helper('hellux_ceneo')->__('An error occurred while deleting Ceneo data. Please review log and try again.')
    );
    Mage::logException($e);
   }
   // redirect to edit form
   $this->_redirect('*/*/edit', array('id' => $id));

   return;
  }
// display error message
  $this->_getSession()->addError(
   Mage::helper('hellux_ceneo')->__('Unable to find a Ceneo to delete.')
  );
// go to grid
  $this->_redirect('*/*/index');
 }
}