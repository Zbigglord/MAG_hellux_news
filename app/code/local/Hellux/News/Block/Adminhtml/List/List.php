<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:48
 */
class Hellux_News_Block_Adminhtml_List_List extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct(){
        $this->_blockGroup = 'hellux_news';
        $this->_controller = 'adminhtml_list_grid';
        $this->_headerText = Mage::helper('hellux_news')->__('Lista aktualności');
        $this->_addButton('new_news', array(
        'label' => $this->__('Nowy artykuł'),
        'onclick' => "setLocation('{$this->getUrl('*/list/new')}')",
        ));
        parent::__construct();
    }

    protected function _prepareLayout()//Need to override this function to add remove button otherwise it just does not work
    {
        $this->_removeButton('add');

        return parent::_prepareLayout();
    }

}

