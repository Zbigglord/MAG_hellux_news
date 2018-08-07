<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:48
 */
class Hellux_News_Block_Adminhtml_List_Grid_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct()
    {
        parent::__construct();
        $this->setId('id');
        // $this->setDefaultSort('COLUMN_ID');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('hellux_news/news')->getCollection();
     foreach($collection as $item){
      $item['news_short_content'] = substr($item['news_short_content'], 0, 100);
      $item['news_content'] = substr($item['news_content'], 0, 255);
      if($item['news_archive'] == '0'){

       $item['news_archive'] = 'NIE';

      }else{

       $item['news_archive'] = 'TAK';

      }
     }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

       $this->addColumn('news_id',
           array(
               'header'=> $this->__('ID'),
               'width' => '50px',
               'index' => 'news_id'
           )
       );
        $this->addColumn('news_title',
         array(
          'header'=> $this->__('Tytuł artykułu'),
          'width' => '10%',
          'index' => 'news_title'
         )
        );
     $this->addColumn('news_thumbnail',
     array(
      'header'=> $this->__('Miniaturka (opcjonalnie)'),
      'width' => '10%',
      'index' => 'news_thumbnail',
      'align' => 'center',
      'renderer' => 'hellux_news_block_adminhtml_list_grid_renderer_image'
     )
    );
     $this->addColumn('news_short_content',
      array(
       'header'=> $this->__('Krótki opis (opcjonalnie)'),
       'width' => '20%',
       'index' => 'news_short_content'
      )
     );
     $this->addColumn('news_content',
      array(
       'header'=> $this->__('Treść artykułu'),
       'width' => '50%',
       'height' => '80px',
       'index' => 'news_content'
      )
     );

     $this->addColumn('news_added_date',
      array(
       'header'=> $this->__('Data dodania'),
       'width' => '100%',
       'align' => 'center',
       'index' => 'news_added_date'
      )
     );

     $this->addColumn('news_edited_date',
      array(
       'header'=> $this->__('Data edycji'),
       'width' => '100%',
       'align' => 'center',
       'index' => 'news_edited_date'
      )
     );

     $this->addColumn('news_archive',
      array(
       'header'=> $this->__('Archiwum'),
       'width' => '100%',
       'align' => 'center',
       'index' => 'news_archive'
      )
     );
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
       return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

        protected function _prepareMassaction()
    {
        $modelPk = Mage::getModel('hellux_news/news')->getResource()->getIdFieldName();
        $this->setMassactionIdField($modelPk);
        $this->getMassactionBlock()->setFormFieldName('ids');
        // $this->getMassactionBlock()->setUseSelectAll(false);
        $this->getMassactionBlock()->addItem('delete', array(
             'label'=> $this->__('Usuń'),
             'url'  => $this->getUrl('*/*/massDelete'),
        ));

     $this->getMassactionBlock()->addItem('to_archive', array(
     'label'=> $this->__('Przenieś do archiwum'),
     'url'  => $this->getUrl('*/*/massArchive'),
    ));

     $this->getMassactionBlock()->addItem('from_archive', array(
      'label'=> $this->__('Przywróć z archiwum'),
      'url'  => $this->getUrl('*/*/massFromArchive'),
     ));
        return $this;
    }
    }
