<?php
/**
 * @project Astra.CMS Free
 * @link http://a-cms.ru/
 * @copyright 2011 "Астра Вебтехнологии"
 * @version 2.07.04
 * @license GNU General Public License
 * @author Vitaly Hohlov <admin@a-cms.ru>
 * @package APanel
 */
/**************************************************************************/

class FilesFiles_Request extends A_Request
{
  function Action($action)
  {
    switch($action)
	{ case "getuploadform": $this->getUploadForm(); break;
	  case "getregisterform": $this->getRegisterForm(); break;
	  case "geteditform": $this->getEditForm(); break;
	}
  }

  function getUploadForm()
  {
    $form = new A_Form("files_files_upload.tpl");
	$form->data['sections']=array();
	A::$DB->query("SELECT * FROM mysite_sections ORDER BY sort");
	while($row=A::$DB->fetchRow())
	$form->data['sections'][$row['id']]=$row['caption'];
	$this->RESULT['html']=$form->getContent();
  }

  function getRegisterForm()
  {
    $form = new A_Form("files_files_register.tpl");
	$form->data['sections']=array();
	A::$DB->query("SELECT * FROM mysite_sections ORDER BY sort");
	while($row=A::$DB->fetchRow())
	$form->data['sections'][$row['id']]=$row['caption'];
	$this->RESULT['html']=$form->getContent();
  }

  function getEditForm()
  {
    $form = new A_Form("files_files_edit.tpl");
	$form->data=A::$DB->getRowById($_POST['id'],"mysite_files");
	if(file_exists($form->data['path']))
	{ $form->data['basename']=basename($form->data['path']);
	  $form->data['realsize']=$form->data['size']==filesize($form->data['path']);

	  $form->data['sections']=array();
	  A::$DB->query("SELECT * FROM mysite_sections ORDER BY sort");
	  while($row=A::$DB->fetchRow())
	  $form->data['sections'][$row['id']]=$row['caption'];

	  $this->RESULT['title']="Файл: ".$form->data['basename'];
	  $this->RESULT['html']=$form->getContent();
	}
	else
    { $this->RESULT['title']="Ошибка";
	  $this->RESULT['html']=AddLabel("Файл не найден на сервере.");
	}
  }
}

A::$REQUEST = new FilesFiles_Request;