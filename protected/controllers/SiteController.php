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
                    $user_data['user_login_provider'] = "facebook";
                    
                    // Verify Provider & Identifier with Email adddress.
                    $user = User::model()->find('user_email=:user_email AND user_login_provider = :user_login_provider AND user_login_identifier = :user_login_identifier',
                                                array(':user_email' => trim($user_data['user_email']),
                                                ':user_login_provider' => "facebook",
                                                ':user_login_identifier' => trim($user_data['user_login_identifier'])));
                    if (!empty($user)) {
                        // Set User Login Activity.
                        $identity = new UserIdentity($user->user_email, null);
                        // Validate user input and redirect to the 
                        // next page if valid.
                        if (!empty($user) && Yii::app()->user->login($identity)) {
                            if ($user->role_id == 2) { 
                                $redirect_url = Yii::app()->createUrl();
                                // For PT.
                            }
                            if ($user->role_id == 3) { 
                                // For Client.
                                $redirect_url = Yii::app()->createUrl();
                            }
                        } else {
                            Yii::app()->user->setFlash('error', 'An error has occurred.');
                            $redirect_url = Yii::app()->createUrl();
                        }
                    } else { 
                        // New Facebook User Detail will be displayed 
                        // on Sign Up Screen.
                        // This code is return back code from 
                        // facbook site autentication.
                        // $this->renderPartial('sign_up_facebook_return', array('data' => $user_data),false,true);
                        // Yii::app()->end();
                        
                        $model_user = new User();
                        // Get all parameters from POST.
                        $is_email_exist = $model_user->isEmailRegistered($user_data['user_email'], 0);
                        if ($is_email_exist) {
                            Yii::app()->user->setFlash('error', 'This account already exists on PT Portal. Press Login to access it.');
                            $redirect_url = Yii::app()->createUrl();
                        } else {
                            // Create New Account with FB data
                            $user_data['role_id'] = $user_type == "pt" ? 2 : 3;
                            $user_data["fb_profile_image_url"] = Yii::app()->facebook->getProfilePicture('large');
                            $user_data['user_gender'] = !empty($userinfo['gender']) && $userinfo['gender'] == "male" ? "M" : "F";
                            $user_data['user_birthdate'] = !empty($userinfo["birthday"]) ? date("Y-m-d", strtotime($userinfo["birthday"])) : "";
                            $user_data["user_city"] = "";
                            $user_data["country_id"] = "";
                            if (!empty($userinfo['location']["name"])) {
                                $city_country = explode(",", $userinfo['location']["name"]);
                                $user_data["user_city"] = trim($city_country[0]);
                                $user_data["country_id"] = Country::getcountryId(trim($city_country[1]));
                            }
                            if ($model_user->saveUser($user_data, "Web")) {
                                // Set User Login Activity.
                                $identity = new UserIdentity($user_data['user_email'], null);
                                // Validate user input and redirect
                                // to the next page if valid.
                                if (Yii::app()->user->login($identity)) {
                                    Yii::app()->session['mixpanel'] = 1;
                                    // Success login to dashboard
                                    $redirect_url = PTPortalCommonFunctions::getUserHomePageURL();
                                } else {
                                    Yii::app()->user->setFlash('error', 'Facebook Email Account Registered, But failed while logged in automatically.');
                                    $redirect_url = Yii::app()->createUrl();
                                }
                            } else {
                                Yii::app()->user->setFlash('error', 'Error while creating Facebook registeration.');
                                $redirect_url = Yii::app()->createUrl();
                            }
                        }
                    }
                } else {
                    Yii::app()->user->setFlash('error', 'An error has occurred.');
                    $redirect_url = Yii::app()->createUrl();
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