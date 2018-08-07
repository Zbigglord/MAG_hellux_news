<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:48
 */
class Hellux_News_Block_Adminhtml_List_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
     if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
      $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
     }
    }

    protected function _prepareForm()
    {

     $id = $this->getRequest()->getParam('id');
     $article = Hellux_News_Model_Resource_News::getArticleById($id);
     foreach($article as $item){
      $title = $item['news_title'];
      $short = $item['news_short_content'];
      $long = $item['news_content'];
      $is_archive = $item['news_archive'];
     }

     if(isset($is_archive) && $is_archive != ''){
      //is set so do nothing
     }else{
       $is_archive = '0';
     }


        $form   = new Varien_Data_Form(array(
         'id'        => 'edit_form',
         'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
         'method'    => 'post',
         'enctype' => 'multipart/form-data'
        ));

      if(!isset($id) && $id != ''){

       $fieldset   = $form->addFieldset('base_fieldset', array(
        'legend'    => Mage::helper('hellux_news')->__("Edytuj artykuł"),
        'class'     => 'fieldset-wide',
       ));

      }else{

       $fieldset   = $form->addFieldset('base_fieldset', array(
        'legend'    => Mage::helper('hellux_news')->__("Dodaj artykuł"),
        'class'     => 'fieldset-wide',
       ));

      }

     if(isset($id) && $id != ''){

      $fieldset->addField('news_id', 'hidden', array(
       'name'      => 'news_id',
       'required'  => false,
       'value'     => $id
      ));

     }


        $fieldset->addField('news_title', 'text', array(
         'name'      => 'news_title',
         'label'     => Mage::helper('hellux_news')->__('Tytuł artykułu'),
         'title'     => Mage::helper('hellux_news')->__('Tytuł artykułu'),
         'required'  => true,
         'value'     => $title
        ));

     if(isset($id) && $id != ''){

      $fieldset->addField('news_thumbnail', 'file', array(
       'label'     => Mage::helper('hellux_news')->__('Miniaturka (zostaw puste aby nie zmieniać)'),
       'required'  => false,
       'name'      => 'news_thumbnail',
       'value'     => ''
      ));

     }else{

      $fieldset->addField('news_thumbnail', 'file', array(
       'label'     => Mage::helper('hellux_news')->__('Miniaturka (opcjonalnie)'),
       'required'  => false,
       'name'      => 'news_thumbnail',
       'value'     => ''
      ));

     }

     $fieldset->addField('news_short_content', 'textarea', array(
      'name'      => 'news_short_content',
      'label'     => Mage::helper('hellux_news')->__('Krótki opis'),
      'title'     => Mage::helper('hellux_news')->__('Jeśli pusty - w przeglądzie aktualności (frontend) będzie wykorzystany fragment pobrany z treści'),
      'required'  => false,
      'value'     => $short
     ));

     $fieldset->addField('news_archive', 'select', array(
      'label'     => Mage::helper('hellux_news')->__('Przenieś do archiwum'),
      'required'  => true,
      'name'      => 'news_archive',
      'value'  => $is_archive,
      'values' => array('0' => 'Nie','1' => 'Tak'),
      'disabled' => false,
      'readonly' => false,
      'tabindex' => 1
     ));

     $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config');
     $fieldset->addField('news_content', 'editor', array(
      'name'      => 'news_content',
      'label'     => Mage::helper('hellux_news')->__('Treść artykułu'),
      'title'     => Mage::helper('hellux_news')->__('Treść artykułu'),
      'style'     => 'min-height: 600px;',
      'value'     => $long,
      'wysiwyg'   => true,
      'required'  => true,
      'config'    => $wysiwygConfig
     ));


        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

}
