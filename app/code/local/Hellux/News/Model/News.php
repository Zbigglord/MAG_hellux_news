<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:42
 */

    //decided to use it for frontend - for backend is resource

class Hellux_News_Model_News extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('hellux_news/news');
    }

    public static function getNewsList() {



            $resource = Mage::getSingleton('core/resource');
            $readConnection = $resource->getConnection('core_read');
            $check_query = "SELECT * FROM hellux_news_news ORDER BY news_added_date DESC";
            $success = $readConnection->query($check_query);

            if(!$success){

                throw new Exception($success->errorInfo());

            }else{

                $result = $success->fetchAll();
                return $result;

            }


   }


}//END CLASS