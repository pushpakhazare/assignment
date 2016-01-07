<?php 
// DB Credentials.
$config['components']['db'] =  array('connectionString' => 'mysql:host=localhost;dbname=ptportal',
                                     'emulatePrepare' => true,
                                     'username' => 'ptportal',
                                     'password' => 'ptportal',
                                     'charset' => 'utf8',
                                     'enableProfiling'=>true,
                                     'enableParamLogging' => true);
// New connection for connecting to the wordpress blog database.
$config['components']['blogdb'] =  array('class' => 'CDbConnection',
                                         'connectionString' => 'mysql:host=localhost;dbname=ptportal_blog',
                                         'emulatePrepare' => true,
                                         'username' => 'root',
                                         'password' => 'password',
                                         'charset' => 'utf8',
                                         'enableProfiling'=>true,
                                         'enableParamLogging' => true);
//CDN Server Setting
// Default CDN URLs.
/*
dev-uimg-default => https://1a0fd6e255957884b363-dfbb0ab3dce218f505b7e3aa1da8deee.ssl.cf3.rackcdn.com
dev-execerise-img => https://bad1093c51546899c1b7-1eb5982b9f8b9138f9965bbaa64e62db.ssl.cf3.rackcdn.com
dev-group-img => https://245da0aa8248e6a22408-235f43851b64b8e927a65acfe35cd65f.ssl.cf3.rackcdn.com
*/
$config['components']['opencloud'] = array('class' => 'ext.OpenCloud.openCloud',
                                           'max_container_size' => 13,
                                           'user_contianer_prfix' => 'dev-uimg-',
                                           'default_container_name' => 'dev-uimg-default',
                                           'execerise_container_name' => 'dev-execerise-img',
                                           'group_container_name' => 'dev-group-img',
                                           'offer_container_name' => 'dev-offer-img',
                                           'default_container_https_url' => 'http://4473fd5400a879815098-dfbb0ab3dce218f505b7e3aa1da8deee.r6.cf3.rackcdn.com',
                                           'execerise_container_https_url' => 'http://61e530df52a543e20a2e-1eb5982b9f8b9138f9965bbaa64e62db.r27.cf3.rackcdn.com',
                                           'group_container_https_url' => 'http://7e74a7ce39a61f0f3d20-235f43851b64b8e927a65acfe35cd65f.r79.cf3.rackcdn.com',
                                           'offer_container_https_url' => 'http://a9ec119fc11f74cd6bac-2f4408cea9cba55ba2ed0f052fa2b4ac.r92.cf3.rackcdn.com',);

//Twitter APP Details
$baseUrl = 'http://'.$_SERVER['HTTP_HOST'].'/';
$config['components']['twitter'] = array(
                                        'class' => 'ext.yiitwitteroauth.YiiTwitter',
                                        'consumer_key' => 'MJf1zSGR7gha0N8pbief4KqQK',
                                        'consumer_secret' => 'lS4tHSd9uIG6xpNo64lMV3DdVEJe4XnXcnUT8h7D2IrI5jbBVT',
                                        'callback' => $baseUrl, // e.g. Site URL http://ptportal.rahulth.com/
                                        );
//Facebook App Details
$config['components']['facebook'] = array(
                                        'class' => 'ext.yii-facebook-opengraph.SFacebook',
                                        'appId' => '1658698911050848',  // needed for JS SDK, Social Plugins and PHP SDK
                                        'secret' => 'f56d64308cb535b3bc1b613203cf8f10',  // needed for the PHP SDK
                                        //'fileUpload'=>false, // needed to support API POST requests which send files
                                        //'trustForwarded'=>false, // trust HTTP_X_FORWARDED_* headers ?
                                        //'locale'=>'en_US', // override locale setting (defaults to en_US)
                                        //'jsSdk'=>true, // don't include JS SDK
                                        //'async'=>true, // load JS SDK asynchronously
                                        //'jsCallback'=>false, // declare if you are going to be inserting any JS callbacks to the async JS SDK loader
                                        //'status'=>true, // JS SDK - check login status
                                        //'cookie'=>true, // JS SDK - enable cookies to allow the server to access the session
                                        //'oauth'=>true,  // JS SDK - enable OAuth 2.0
                                        //'xfbml'=>true,  // JS SDK - parse XFBML / html5 Social Plugins
                                        //'frictionlessRequests'=>true, // JS SDK - enable frictionless requests for request dialogs
                                        //'html5'=>true,  // use html5 Social Plugins instead of XFBML
                                        //'ogTags'=>array(  // set default OG tags
                                        //'og:title'=>'MY_WEBSITE_NAME',
                                        //'og:description'=>'MY_WEBSITE_DESCRIPTION',
                                        //'og:image'=>'URL_TO_WEBSITE_LOGO',
                                        //),
                                        );
$config['components']['mailer'] = array('class' => 'application.extensions.mailer.EMailer',
                                        'pathViews' => 'application.views.email',
                                        'pathLayouts' => 'application.views.email.layouts',
                                        'Hostname' => 'evolvingsols.com',
                                        'Host'=>'172.27.172.202 ',
                                        'SMTPAuth' => false,
                                        'Username' => '',
                                        'Password' => '',
                                        'Port' => '25');
                                        

// Parameter for cdn enabled
$config['params']['cdn_enabled'] = true;
//Constants for Wordpress blog categories (News for PT, News for Client, News for Both).
$config['params']['news_for_pt'] = 5;
$config['params']['news_for_client'] = 6;
$config['params']['news_for_both'] = 7;
// User IDs for inquiry and reminder users.
$config['params']['inquiry_user'] = 2;
$config['params']['reminder_user'] = 3;
// Environment type.
$config['params']['environment'] = 'development';
// FB Application Admin.
$config['params']['facebook_application_admin'] = '585538739';
// FB App used for Facebook Like. 
// (App name: PTPortal Local).
$config['params']['facebook_app_id'] = '1653529981567741';
// FB App used for comment posting through the background. 
// (App name: PTPortal Test User Setting).
$config['params']['fb_offline_post_app_id'] = '335292799908355';
$config['params']['fb_offline_post_secret_key'] = 'bb7b5d5076e68750deaa3bb0862d1f26';
// HSBC Details 
// (Merchant ID, Username, Password and secret for hash generation.)
$config['params']['hsbc_merchant_id'] = 'ptportaltest';
$config['params']['hsbc_username'] = 'recurring';
$config['params']['hsbc_password'] = 'Evie2004';
$config['params']['hsbc_secret'] = '38SnXldOMi';
$config['params']['iris_url'] = 'https://hpp.sandbox.realexpayments.com/pay';
$config['params']['account_type'] = 'website';
// TextMagic API username and password.
$config['params']['text_magic_user'] = 'simon.webster';
$config['params']['text_magic_password'] = 'UZweD4Og5k';
$config['params']['show_google_analytics'] = false;
// Acceptable Mime types and extensions for image upload.
$config['params']['acceptable_img_mime_types'] = array('image/png', 'image/jpeg', 'image/jpg');
$config['params']['acceptable_img_extensions'] = 'jpg,jpeg,png';
//Store
$config['params']['store']['site_url'] = 'http://172.27.134.56:94/';
$config['params']['store']['product_image_url'] = ""; // Product Image base URL 
$config['params']['store']['campaign_url'] = $config['params']['store']['site_url'].'recommendation/campaign/list'; // To Prepare Campaign URL for Send in Email  
$config['params']['store']['product_recommend_url'] = $config['params']['store']['site_url']; // To select Recommended product from store\
$config['params']['store']['wsdl_url'] = $config['params']['store']['site_url'].'index.php/api/v2_soap?wsdl=1'; // To Consume Magento Soap Service URL
$config['params']['store']['wsdl_username'] = 'srinidhid';
$config['params']['store']['wsdl_apiKey'] = '123456';

// Android API key for push notifications
$config['params']['android_api_key'] = 'AIzaSyBWseHTmkmevzvlxkfNgub3N3nS0Ga08oM';
// Port for node.js conversation messages
$config['params']['nodejs_port'] = 4000;
// Secret key for hidden variable hash.
$config['params']['secret_key'] = '8YgM4SbUiWLNAtT22d';
// Download URLs for iPhone and Android
$config['params']['android_download_url'] = 'https://play.google.com/store/apps/details?id=com.ptportal&referrer=utm_source%3Dwww.ptportal.com%26utm_medium%3Dreferral%26utm_campaign%3Dacquisition';
$config['params']['iphone_download_url']  = 'https://itunes.apple.com/app/apple-store/id951765346?pt=117176846&ct=www.ptportal.com&mt=8';
// Parameter for copyright text
$config['params']['copyright_text'] = '&copy; PT Portal '. date("Y");

// Ip address and necessary ecom parameters
$config['params']['ecom_api_allowed_ips'] = array('172.27.134.56' ,'31.222.158.15', '31.222.162.90');
$config['params']['ecom_api_username'] = 'ganesh';
$config['params']['ecom_api_password'] = '123456';

// APNS certificate for ios push notifications.
$config['params']['apns_cert_for_ios_push_noti'] = '/home/rahulth/ptportal/source1/protected/config/pem/apns-staging.pem';
$config['params']['apns_url'] = 'ssl://gateway.sandbox.push.apple.com:2195';
$config['params']['passphrase'] = 'ptportal';

// Mix-panel token ID
$config['params']['mixpanel_token'] = 'dcf4f0eec0c0fb9282f6a9c90659c41d';

// Native In-App Purchase Environment Varible for iOS Premiumapi/makeproios
$config['params']['in_app_purchase_ios_is_sandbox'] = true;

return $config;
?>
