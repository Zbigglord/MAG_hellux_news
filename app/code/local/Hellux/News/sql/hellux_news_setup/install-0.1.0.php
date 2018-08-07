<?php
 /**
  * Created by Hellux.
  * User: Zbigglord
  * Date: 2017-01-26
  * Time: 15:41
  */
 /* @var $installer Mage_Core_Model_Resource_Setup */
 $installer = $this;

 $installer->startSetup();

//Hellux aktualnnosci

 $tableName = $installer->getTable('hellux_news/news');
 if ($installer->getConnection()->isTableExists($tableName) !=  TRUE){

  $table = $installer->getConnection()
   ->newTable($tableName)
   ->addColumn('news_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
    array(
     'identity' => true,
     'unsigned' => true,
     'nullable' => false,
     'primary' => true,
    ),
    'News Id'
   )
   ->addColumn('news_title', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
    array(),
    'Tytuł newsa'
   )
   ->addColumn('news_thumbnail', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
    array(),
    'Ścieżka do pliku thumbnail'
   )
   ->addColumn('news_short_content', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
    array(),
    'Krótki opis newsa (dla listy)'
   )
   ->addColumn('news_content', Varien_Db_Ddl_Table::TYPE_LONGVARCHAR,
    array(),
    'Zawartość newsa'
   )
   ->addColumn('news_author', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
    array(),
    'Autor'
   )
   ->addColumn('news_added_date', Varien_Db_Ddl_Table::TYPE_DATE,
    null,
    array(),
    'Data dodania'
   )
  ->addColumn('news_edited_date', Varien_Db_Ddl_Table::TYPE_DATE,
   null,
   array(),
   'Data dodania'
  )
  ->addColumn('news_archive', Varien_Db_Ddl_Table::TYPE_TEXT, 255,
   array(),
   'Archiwum (tak/nie)'
  );

  $installer->getConnection()->createTable($table);

 }//END aktualnosci


 $installer->endSetup();