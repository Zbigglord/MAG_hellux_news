<?php
/**
 * Created by PhpStorm.
 * User: BBJaga
 * Date: 2017-04-10
 * Time: 08:42
 */ 
class Hellux_News_Model_Resource_News extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('hellux_news/news', 'news_id');
    }

    public static function checkIfExists($title){

        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $check_query = "SELECT * FROM hellux_news_news WHERE news_title = '$title'";
        $success = $readConnection->query($check_query);
        $found = $success->rowCount();

        if($found > 0){

            return TRUE;

        }else{

            return FALSE;

        }

    }//end checkIfExists($title)


    public static function saveArticle($data){

        $resource = Mage::getSingleton('core/resource');
        $writeConnection = $resource->getConnection('core_write');
        $readConnection = $resource->getConnection('core_read');

        $news_title = $data['news_title'];
        $news_thumbnail = $data['news_thumbnail'];
        $news_short_content = $data['news_short_content'];
        $news_content = $data['news_content'];
        $user = Mage::getSingleton('admin/session');
        $userUsername = $user->getUser()->getUsername();
        $news_author = $userUsername;

        if(isset($data['news_archive'])){

            $news_archive = $data[''];

        }else{

            $news_archive = '0';

        }


        $check_if_exists = self::checkIfExists($news_title);

      if($check_if_exists != TRUE){

        $insert_query = "INSERT INTO hellux_news_news
          (
            news_title,
            news_thumbnail,
            news_short_content,
            news_content,
            news_author,
            news_added_date,
            news_archive
          ) VALUES(
           '$news_title',
           '$news_thumbnail',
           '$news_short_content',
           '$news_content',
           '$news_author',
            NOW(),
           '$news_archive'
          )
       ";

        $success = $writeConnection->query($insert_query);

        if(!$success){

            throw new Exception($success->errorInfo());

        }else{

            Mage::getSingleton('adminhtml/session')->addSuccess('Nowy artykuł został dodany poprawnie.');
        }

      }else{

       Mage::getSingleton('adminhtml/session')->addError('Artykuł o takim tytule już istnieje. Zmień tytuł, lub edytuj istniejący. Artykuł NIE został dodany.');

      }

    }//end saveArticle($data)

 public static function editArticle($data){

  $resource = Mage::getSingleton('core/resource');
  $writeConnection = $resource->getConnection('core_write');

  $news_id = $data['news_id'];
  $news_title = $data['news_title'];
  $news_thumbnail = $data['news_thumbnail'];
  $news_short_content = $data['news_short_content'];
  $news_content = $data['news_content'];

  if(isset($data['news_archive'])){

   $news_archive = $data['news_archive'];

  }else{

   $news_archive = '0';

  }

  if(isset($news_thumbnail) || $news_thumbnail != ''){

   $edit_query = "UPDATE hellux_news_news SET
            news_title = '$news_title',
            news_thumbnail = '$news_thumbnail',
            news_short_content = '$news_short_content',
            news_content = '$news_content',
            news_edited_date = NOW(),
            news_archive = '$news_archive'
            WHERE news_id = '$news_id'
       ";

  }else{

   $edit_query = "UPDATE hellux_news_news SET
            news_title = '$news_title',
            news_short_content = '$news_short_content',
            news_content = '$news_content',
            news_edited_date = NOW(),
            news_archive = '$news_archive'
            WHERE news_id = '$news_id'
       ";

  }

   $success = $writeConnection->query($edit_query);

   if(!$success){

    throw new Exception($success->errorInfo());

   }else{

    Mage::getSingleton('adminhtml/session')->addSuccess('Artykuł wyedytowano poprawnie.');
   }


 }//end saveArticle($data)

    public static function getArticleById($id){

     $resource = Mage::getSingleton('core/resource');
     $readConnection = $resource->getConnection('core_read');
     $check_query = "SELECT * FROM hellux_news_news WHERE news_id = '$id'";
     $success = $readConnection->query($check_query);

     if(!$success){

      throw new Exception($success->errorInfo());

     }else{

      $result = $success->fetchAll();
      return $result;

     }

    }//end getArticleById()

  public static function toArchive($id){

   $resource = Mage::getSingleton('core/resource');
   $writeConnection = $resource->getConnection('core_write');

   $archive_query = "UPDATE hellux_news_news SET news_archive = 1 WHERE news_id = '$id'";

   $success = $writeConnection->query($archive_query);

   if(!$success){

    throw new Exception($success->errorInfo());

   }else{

    //success message wil be printed in controller


   }

  }//end toArchive($id)

 public static function fromArchive($id){

  $resource = Mage::getSingleton('core/resource');
  $writeConnection = $resource->getConnection('core_write');

  $archive_query = "UPDATE hellux_news_news SET news_archive = 0 WHERE news_id = '$id'";

  $success = $writeConnection->query($archive_query);

  if(!$success){

   throw new Exception($success->errorInfo());

  }else{

   //success message wil be printed in controller

  }

 }//end fromArchive($id)


}