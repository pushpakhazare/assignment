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
		
		
		// Code After Facebook Authentication.
        $fb_state = Yii::app()->request->getQuery('state');
        $fb_code = Yii::app()->request->getQuery('code');
        
		if (!empty($fb_state) && !empty($fb_code)) {
            // Code before Facebook Authentication.
			echo "in";

            try {
			echo "in2";
                $fb = Yii::app()->facebook;
                $access_token = Yii::app()->facebook->getAccessToken();
                Yii::app()->facebook->setAccessToken($access_token);
                $user_identifier = Yii::app()->facebook->getUser();
                $userinfo = Yii::app()->facebook->getInfo();
                $results = Yii::app()->facebook->api('/me/friends'); //,array('access_token'=>$my_access_token)
                echo "<pre>"; print_r($results); 
				echo "<pre>"; print_r($results); 
exit;
				if (!empty($userinfo)) {
				echo "userinfo:";	
				print_r($userinfo);exit;
				}
				echo "emoty";exit;
                $results = Yii::app()->facebook->api('/me/friends'); //,array('access_token'=>$my_access_token)
                echo "<pre>"; print_r($results); exit;
                $results = Yii::app()->facebook->api('/'.$results["data"][1]['id']); //,array('access_token'=>$my_access_token)
                echo "<pre>"; print_r($results);
                exit;
                if (!empty($userinfo)) {
                    $user_data = array();
                    $user_data['user_email'] = strtolower(trim($userinfo['email']));
                    $user_data['user_first_name'] = $userinfo['first_name'];
                    $user_data['user_last_name'] = $userinfo['last_name'];
                    $user_data['user_login_identifier'] = $userinfo['id'];
                   } 
            } catch (FacebookApiException $error) {
                Yii::app()->user->setFlash('error', 'There is an error with the Facebook connection. : ' . $error->getMessage());
                $redirect_url = Yii::app()->createUrl("");
            }
			echo "out";

            $this->renderPartial('facebook_return_popup_close', array(),false,true);
            Yii::app()->end();
        }



		
		
		
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
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}