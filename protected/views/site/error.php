<?php $this->pageTitle=Yii::app()->name . ' - ' . $error['code']; ?>

<?php switch($error['code']){
	case 400:
		$title = Yii::t('ui','Bad Request');
		$message = Yii::t('ui','Please do not repeat the request without modifications.');
		$contact = Yii::t('ui','If you think this is a server error, please contact');
		break;
	case 401:
		$title = Yii::t('ui','Access denied');
		$message = Yii::t('ui','You are not allowed to perform this action.');
		$contact = Yii::t('ui','If you think this is a server error, please contact');
		break;
	case 403:
		$title = Yii::t('ui','Unauthorized');
		$message = Yii::t('ui','You do not have the proper credential to access this page.');
		$contact = Yii::t('ui','If you think this is a server error, please contact');
		break;
	case 404:
		$title = Yii::t('ui','Page Not Found');
		$message = Yii::t('ui','Please make sure you entered a correct URL.');
		$contact = Yii::t('ui','If you think this is a server error, please contact');
		break;
	case 500:
		$title = Yii::t('ui','Internal Server Error');
		$message = Yii::t('ui','An internal error occurred while the Web server was processing your request.');
		$contact = Yii::t('ui','Please contact');
		break;
	case 503:
		$title = Yii::t('ui','Service Unavailable');
		$message = Yii::t('ui','Our system is currently under maintenance. Please come back later.');
		$contact = Yii::t('ui','Contact for more information');
		break;
	default:
		$title = Yii::t('ui','Error').' '.$error['code'];
		$message = nl2br(CHtml::encode($error['message']));
		$contact = Yii::t('ui','If you think this is a server error, please contact');
		   break;
} ?>

<h2>
<?php echo $title; ?>
</h2>
<p>
<?php echo $message; ?>
</p>
<p>
<?php echo $contact; ?>
<?php echo CHtml::mailto(Yii::app()->params['adminEmail']); ?>
</p>
<p>
<?php echo CHtml::link(Yii::t('ui', 'Return to homepage'),Yii::app()->homeUrl); ?>
</p>