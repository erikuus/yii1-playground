<?php
/**
 * XHEditorUpload action
 *
 * This action uploads file for XHEditor
 *
 * The following shows how to use XHEditorUpload action.
 *
 * First set up uploadFile action on RequestController actions() method:
 * <pre>
 * return array(
 *     'uploadFile'=>array(
 *         'class'=>'ext.actions.XHEditorUpload',
 *     ),
 * );
 * </pre>
 *
 * And then in the view configure XHEditor widget as follows:
 * <pre>
 * $this->widget('ext.widgets.xheditor.XHeditor',array(
 *     'model'=>$model,
 *     'modelAttribute'=>'content',
 *     'config'=>array(
 *         'id'=>'xheditor_1',
 *         'tools'=>'full', // mini, simple, full
 *         'skin'=>'o2007blue',
 *         'width'=>'740px',
 *         'height'=>'400px',
 *         'upImgUrl'=>$this->createUrl('/request/uploadFile'),
 *         'upImgExt'=>'jpg,jpeg,gif,png',
 *     ),
 * ));
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XHEditorUpload extends CAction
{
	/**
	 * @var file form field name
	 */
	public $inputName='filedata';
	/**
	 * @var upload file path, do not end with /
	 */
	public $attachDir='upload';
	/**
	 * @var directory type: 1- by day, 2- by month, 3- by extension
	 */
	public $dirType=1;
	/**
	 * @var maximum upload size, the default is 2M
	 */
	public $maxAttachSize=2097152;
	/**
	 * @var upload extension
	 */
	public $upExt='pdf,txt,rar,zip,jpg,jpeg,gif,png,swf,wmv,avi,wma,mp3,mid';
	/**
	 * @var return format after upload: 1- only the url, 2- parameter array
	 */
	public $msgType=2;

	/**
	 * Fills treeview based on the current user input.
	 */
	public function run()
	{
		if(!is_dir($this->attachDir))
		{
			@mkdir($this->attachDir);
			@chmod($this->attachDir,0777);
		}

		$immediate=isset($_GET['immediate']) ? $_GET['immediate'] : 0;
		if(isset($_SERVER['HTTP_CONTENT_DISPOSITION']))
		{
			if(preg_match('/attachment;\s+name="(.+?)";\s+filename="(.+?)"/i',$_SERVER['HTTP_CONTENT_DISPOSITION'],$info))
			{
				$temp_name=$this->attachDir.'/'.date("YmdHis").mt_rand(1000,9999).'.tmp';
				file_put_contents($temp_name,file_get_contents("php://input"));
				$size=filesize($temp_name);
				$_FILES[$info[1]]=array('name'=>$info[2],'tmp_name'=>$temp_name,'size'=>$size,'type'=>'','error'=>0);
			}
		}

		$err = "";
		$msg = "''";

		$upfile=@$_FILES[$this->inputName];
		if(!isset($upfile))
			$err='Filename field was not sent.';
		elseif(!empty($upfile['error']))
		{
			switch($upfile['error'])
			{
				case '1':
					$err = 'The file exceeds size limit set in php.ini by upload_max_filesize parameter.';
					break;
				case '2':
					$err = 'The file exceeds size limit set by HTML MAX_FILE_SIZE parameter.';
					break;
				case '3':
					$err = 'An error ocurred while uploading the file.';
					break;
				case '4':
					$err = 'No file selected to be uploaded';
					break;
				case '6':
					$err = 'Could not find temporary folder.';
					break;
				case '7':
					$err = 'Failed to write file.';
					break;
				case '8':
					$err = 'File extension not allowed for upload.';
					break;
				case '999':
				default:
					$err = 'Unknown error.';
			}
		}
		elseif(empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none')
			$err = 'No file uploaded';
		else
		{
			$temppath=$upfile['tmp_name'];
			$fileinfo=pathinfo($upfile['name']);
			$extension=$fileinfo['extension'];
			if(preg_match('/'.str_replace(',','|',$this->upExt).'/i',$extension))
			{
				$bytes=filesize($temppath);
				if($bytes > $this->maxAttachSize)
					$err='The file exceeds size limit '.formatBytes($this->maxAttachSize);
				else
				{
					switch($this->dirType)
					{
						case 1: $attach_subdir = 'day_'.date('ymd'); break;
						case 2: $attach_subdir = 'month_'.date('ym'); break;
						case 3: $attach_subdir = 'ext_'.$extension; break;
					}
					$attach_dir = $this->attachDir.'/'.$attach_subdir;
					if(!is_dir($attach_dir))
					{
						@mkdir($attach_dir);
						@chmod($attach_dir,0777);
						@fclose(fopen($attach_dir.'/index.htm', 'w'));
					}
					PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
					$filename=date("YmdHis").mt_rand(1000,9999).'.'.$extension;
					$target = $attach_dir.'/'.$filename;

					rename($upfile['tmp_name'],$target);
					@chmod($target,0755);
					$target=$this->jsonString($target);
					if($immediate=='1')
						$target='!'.$target;
					if($this->msgType==1)
						$msg="'$target'";
					else
						$msg="{'url':'".Yii::app()->baseUrl.'/'.$target."','localname':'".$this->jsonString($upfile['name'])."','id':'1'}";
				}
			}
			else $err='Allowed extensions are '.$this->upExt;

			@unlink($temppath);
		}
		echo "{'err':'".$this->jsonString($err)."','msg':".$msg."}";
	}

	/**
	 * @param string
	 * @return JSON string
	 */
	protected function jsonString($str)
	{
		return preg_replace("/([\\\\\/'])/",'\\\$1',$str);
	}

	/**
	 * @param bytes
	 * @return filesize in bytes, KB, MB or GB
	 */
	protected function formatBytes($bytes)
	{
		if($bytes >= 1073741824)
			$bytes = round($bytes / 1073741824 * 100) / 100 . 'GB';
		elseif($bytes >= 1048576)
			$bytes = round($bytes / 1048576 * 100) / 100 . 'MB';
		elseif($bytes >= 1024)
			$bytes = round($bytes / 1024 * 100) / 100 . 'KB';
		else
			$bytes = $bytes . 'Bytes';
		return $bytes;
	}
}