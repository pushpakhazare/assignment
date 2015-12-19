<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type = "text/javascript">
$(document).ready(function(){
$("#fb_connect").click(function(){
	url = "<?php echo Yii::app()->facebook->getLoginUrl(array('scope' => 'public_profile,email,user_friends,user_birthday,user_location,user_photos','display' => 'popup', 'redirect_uri' => Yii::app()->getBaseUrl(true))); ?>";
	popup = window.open(url, "facebook_popup","width=620,height=400,status=no,scrollbars=no,resizable=no");
	popup.focus();
});
});

</script>

<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>Congratulations! You have successfully created your Yii application.</p>

<p>You may change the content of this page by modifying the following two files:</p>
<ul>
	<li>View file: <code><?php echo __FILE__; ?></code></li>
	<li>Layout file: <code><?php echo $this->getLayoutFile('main'); ?></code></li>
</ul>
<?php echo CHtml::button("Connect with Facebook", array("id"=>"fb_connect"));?>

<p>For more details on how to further develop this application, please read
the <a href="http://www.yiiframework.com/doc/">documentation</a>.
Feel free to ask in the <a href="http://www.yiiframework.com/forum/">forum</a>,
should you have any questions.</p>
