<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:48
 */
class Hellux_News_Block_Adminhtml_Single_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup      = 'hellux_news';
        $this->_controller      = 'adminhtml_single';
        $this->_mode            = 'edit';
        $this->_updateButton('save', 'label', Mage::helper('hellux_news')->__("Eksportuj"));


    } //END CONSTR

    protected function _prepareLayout()
    {
        $this->_removeButton('delete');
        $this->_removeButton('reset');
        parent::_prepareLayout();
    }

    public function getHeaderText()
    {

            return Mage::helper('hellux_news')->__("Wybierz kategorię Ceneo i nazwę pliku .xml");

    }

    public function getSaveUrl()
    {
        $this->setData('form_action_url', 'save');
        return $this->getFormActionUrl();
    }

}
