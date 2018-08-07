<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:48
 */
class Hellux_News_Block_Adminhtml_Single_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
    }

    protected function _prepareForm()
    {

        $form   = new Varien_Data_Form(array(
         'id'        => 'edit_form',
         'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
         'method'    => 'post',
         'enctype' => 'multipart/form-data'
        ));

        $fieldset   = $form->addFieldset('base_fieldset', array(
         'legend'    => Mage::helper('hellux_news')->__("Wybierz kategorię i nazwę pliku:"),
         'class'     => 'fieldset-wide',
        ));

     $fieldset->addField('category', 'select', array(
      'label'     => Mage::helper('hellux_news')->__('Kategoria Ceneo: '),
      'class'     => 'required-entry',
      'required'  => true,
      'name'      => 'category',
      'values' => Hellux_Ceneo_Model_Resource_Categories::toOptionArray()
     ));

        $fieldset->addField('file_name', 'text', array(
     'name'      => 'file_name',
     'label'     => Mage::helper('hellux_news')->__('Nazwa pliku:'),
     'title'     => Mage::helper('hellux_news')->__('wpisz nazwę pliku bez rozszerzenia i bez ścieżki.'),
     'required'  => true,
     'value'     => ''
    ));

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();

    }

}
