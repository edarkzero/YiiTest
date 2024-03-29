<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		if(isset(Yii::app()->user->type) && Yii::app()->user->type === 'social_user')
			$redirectUrl = Yii::app()->session['lastUrl'];

		else
			$redirectUrl = Yii::app()->homeUrl;

		Yii::app()->user->logout();

		$this->redirect($redirectUrl);
	}

	public function actionMap()
	{
		$this->render('map',array(
			'mapOptions' => array(
				'id' => 'map',
				'defaultUI' => json_encode(false),
				'addMarkers' => json_encode(array('enabled' => true,'limit' => 4,'deleteOnClick' => true,'centerOnClick' => true,'traceRoute' => true)),
				'markersData' => json_encode(array(
					'abc' => array(
						'title' => 'hola',
						'x' => '-25.352393',
						'y' => '131.044923',
						'message' => 'que paso!?',
						'image' => Yii::app()->getBaseUrl(true).'/images/site/marker2.png',
						'shape' => array('coord' => array(14,32,17,32,18,18,24,11,24,6,19,0,12,0,7,6,7,11,13,17,14,32),'type' => 'poly')
					),
					'def' => array(
						'title' => 'otro hola',
						'x' => '-25.363882',
						'y' => '131.044922',
						'message' => 'que pasaaaaaaaoooooooo!!',
						'image' => Yii::app()->getBaseUrl(true).'/images/site/marker1.png',
						'shape' => array('coord' => array(13,32,26,20,26,2,0,1,0,20,13,32),'type' => 'poly')
					)
				))
			),
		));
	}

	public function actionSocial()
	{
		$this->render('social');
	}

	public function actionOrder_Array()
	{
		$data = array(array('valor' => 10),array('valor' => 50),array('valor' => 75),array('valor' => 5),array('valor' => 100));
		$dataSorted = ArrayTools::ORDER_ARRAY($data,'valor');
		$dataSortedInv = ArrayTools::ORDER_ARRAY($data,'valor',true);
		$this->render('order_array',array('data' => $data,'dataSorted' => $dataSorted,'dataSortedInv' => $dataSortedInv));
	}

	public function actionFile_uploader()
	{
		$uploaderConfig = array();
		$uploaderConfig['id'] = 'fileupload';
		$uploaderConfig['id_js'] = '#'.$uploaderConfig['id'];
		$uploaderConfig['id_progress'] = 'progress';
		$uploaderConfig['id_js_progress'] = '#'.$uploaderConfig['id_progress'];

		$this->render('file_uploader',array(
			'uploaderConfig' => $uploaderConfig
		));
	}

	public function actionUpload()
	{
		$ds = DIRECTORY_SEPARATOR;
		$storeFolder = 'uploads';
		$fileMaxSize = 10485760; //10MiB
		$fileMaxSizeString = (string)($fileMaxSize/1024/1024).' MiB';

		if (!empty($_FILES)) {

			if($_FILES['file']['type'] != image_type_to_mime_type(IMAGETYPE_JPEG) && $_FILES['file']['type'] != image_type_to_mime_type(IMAGETYPE_PNG))
				throw new CHttpException(415, 'Unsupported Media Type. ('.$_FILES['file']['type'].')');

			if($_FILES['file']['size'] > $fileMaxSize)
				throw new CHttpException(415, 'The file is too large to upload (Max '.$fileMaxSizeString.').');

			$tempFile = $_FILES['file']['tmp_name'];
			$targetPath = Yii::getPathOfAlias('local') . $ds. $storeFolder . $ds;
			$targetFile =  $targetPath. $_FILES['file']['name'];
			if(!file_exists($targetFile))
				move_uploaded_file($tempFile,$targetFile);
			else
				throw new CHttpException(415, 'The file already exist.');
		}

		else
			throw new CHttpException(415, 'Internal problem, sorry.');

		/*Multiples archivos
		 foreach ($_FILES["pictures"]["error"] as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
				$tmp_name = $_FILES["pictures"]["tmp_name"][$key];
				$name = $_FILES["pictures"]["name"][$key];
				move_uploaded_file($tmp_name, "data/$name");
			}
		}*/
	}

	public function actionString_compressor()
	{
		$this->render('string_compressor');
	}

	public function actionIp_tools()
	{
		$this->render('ip_tools');
	}

	public function actionFancybox()
	{
		$this->render('fancybox');
	}

	public function actionTaskbar()
	{
		$this->render('taskbar');
	}
}