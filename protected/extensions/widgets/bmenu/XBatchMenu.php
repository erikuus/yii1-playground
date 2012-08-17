<?php
/**
 * XBatchMenu displays batch process menu for CGridView.
 *
 * XBatchMenu extends XActionMenu.
 * XActionMenu is simplified version of CMenu.
 *
 * The following example shows how to use XBatchMenu for CGridView with ajaxUpdate true:
 * <pre>
 * $this->widget('ext.widgets.bmenu.XBatchMenu', array(
 *     'formId'=>'person-form',
 *     'checkBoxId'=>'person-id',
 *     'ajaxUpdate'=>'person-grid',
 *     'emptyText'=>Yii::t('ui','Please check items you would like to perform this action on!'),
 *     'confirm'=>Yii::t('ui','Are you sure to perform this action on checked items?'),
 *     'items'=>array(
 *         array('label'=>Yii::t('ui','Make something with selected items'),'url'=>array('batchProcess1')),
 *         array('label'=>Yii::t('ui','Make something else with selected items'),'url'=>array('batchProcess2')),
 *     ),
 * ));
 *
 * echo CHtml::beginForm('','post',array('id'=>'person-form'));
 * $this->widget('zii.widgets.grid.CGridView', array(
 *     'id'=>'person-grid',
 *     'dataProvider'=>$model->search(),
 *     'selectableRows'=>2, // multiple rows can be selected
 *     'columns'=>array(
 *         array(
 *             'class'=>'CCheckBoxColumn',
 *             'id'=>'person-id',
 *         ),
 *         'lastname',
 *         'firstname',
 *         'birthyear',
 *     ),
 * ));
 * echo CHtml::endForm();
 * </pre>
 *
 * The is the example of controller action for batch processing:
 * <pre>
 * public function actionBatchProcess()
 * {
 *     // we only allow POST request
 *     if(Yii::app()->request->isPostRequest)
 *     {
 *         $updateIds=implode(',',$_POST['person-id']);
 *         Person::model()->updateCounters(array('birthyear'=>1),"id IN ($updateIds)");
 *
 *         // if AJAX request, we should not redirect the browser
 *         if(!isset($_GET['ajax']))
 *             $this->redirect(array('batch'));
 *     }
 *     else
 *         throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
 * }
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
Yii::import('ext.widgets.amenu.XActionMenu');
class XBatchMenu extends XActionMenu
{
	/**
	 * @var string The id of the form element
	 */
	public $formId;
	/**
	 * @var string The id of the {@link CCheckBoxColumn}
	 */
	public $checkBoxId;
	/**
	 * @var string The message to be displayed when {@link CCheckBoxColumn} does not have any checkbox checked.
	 */
	public $emptyText;
	/**
	 * @var string The confirmation message. Defaults to false, meaning no confrmation is asked.
	 */
	public $confirm=false;
	/**
	 * @var mixed The ID of the gridview whose content may be updated with an AJAX response.
	 * Defaults to false, meaning update will be performed in normal page requests instead of AJAX requests.
	 */
	public $ajaxUpdate=false;

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		$this->registerClientScript();
		$this->renderMenu($this->items);
	}

	/**
	 * Registers necessary client scripts.
	 */
	protected function registerClientScript()
	{
		$id=$this->getId();
		$cs=Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerScript(__CLASS__.'#'.$id, "
			jQuery('#$id a').live('click',function(e) {
				e.preventDefault();
				if($(\"input[name='{$this->checkBoxId}\[\]']:checked\").length==0) {
					alert('{$this->emptyText}');
					return false;
				}
				{$this->renderConfirmation()}
				{$this->renderSubmitScript()}
			});
		");
	}

	/**
	 * Renders the confirmation message to be displayed when a menu link is clicked.
	 */
	protected function renderConfirmation()
	{
		if($this->confirm===false)
			return null;
		else
		{
			return "
				if(!$(this).hasClass('skipConfirm') && !confirm('".$this->confirm."'))
					return false;
			";
		}
	}

	/**
	 * Renders the client script for grid ajax update
	 */
	protected function renderSubmitScript()
	{
		if($this->ajaxUpdate===false)
		{
			return "
				$('#{$this->formId}').attr('action', this.href);
				$('#{$this->formId}').attr('target', this.target=='_blank' ? '_blank' : null);
				$('#{$this->formId}').trigger('submit');
			";
		}
		else
		{
			return "
				$.fn.yiiGridView.update('{$this->ajaxUpdate}', {
					type:'POST',
					url:this.href,
					data:$('#{$this->formId}').serialize(),
					success:function() {
						$.fn.yiiGridView.update('{$this->ajaxUpdate}');
					}
				});
			";
		}
	}
}