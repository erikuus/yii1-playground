<?php
/**
 * XFlagColumn
 *
 * Allows to display Y/N links in CGridView column.
 * @author Alexander Makarov
 * @version 1.1
 *
 * The following shows how to use XFlagColumn.
 *
 * In view:
 * $this->widget('zii.widgets.grid.CGridView', array(
 *    'id'=>'person-grid',
 *    'dataProvider'=>$model->search(),
 *    'filter'=>$model,
 *    'columns'=>array(
 *        'first_name',
 *        'last_name',
 *        array(
 *            'class' => 'ext.widgets.grid.flagcolumn.XFlagColumn',
 *            'name' => 'active',
 *        ),
 *    ),
 * ));
 *
 * In controller:
 * public function actionFlag($pk, $name, $value){
 *    $model = $this->loadModel($pk);
 *    $model->{$name} = $value;
 *    $model->save(false);
 *    if(!Yii::app()->request->isAjaxRequest)
 *        $this->redirect('admin');
 * }
*/

class XFlagColumn extends CGridColumn
{
	public $name;
	public $sortable=true;
	public $callbackUrl = array('flag');
	private $_flagClass = "flag_link";

	public function init()
	{
		parent::init();
		$cs=Yii::app()->getClientScript();
		$gridId = $this->grid->getId();
		$script = <<<SCRIPT
		jQuery(".{$this->_flagClass}").live("click", function(e){
			e.preventDefault();
			var link = this;
			$.ajax({
				dataType: "json",
				cache: false,
				url: link.href,
				success: function(data){
					$('#$gridId').yiiGridView.update('$gridId');
				}
			});
		});
SCRIPT;
		$cs->registerScript(__CLASS__.$gridId.'#flag_link', $script);
	}

	protected function renderDataCellContent($row, $data)
	{
		$value=CHtml::value($data,$this->name);

		$this->callbackUrl['pk'] = $data->primaryKey;
		$this->callbackUrl['name'] = urlencode($this->name);
		$this->callbackUrl['value'] = (int)empty($value);

		$link = CHtml::normalizeUrl($this->callbackUrl);

		echo CHtml::link(!empty($value) ? 'Y' : 'N', $link, array(
			'class' => $this->_flagClass,
		));
	}

	protected function renderHeaderCellContent()
	{
		if($this->grid->enableSorting && $this->sortable && $this->name!==null)
			echo $this->grid->dataProvider->getSort()->link($this->name,$this->header);
		else if($this->name!==null && $this->header===null)
		{
			if($this->grid->dataProvider instanceof CActiveDataProvider)
				echo CHtml::encode($this->grid->dataProvider->model->getAttributeLabel($this->name));
			else
				echo CHtml::encode($this->name);
		}
		else
			parent::renderHeaderCellContent();
	}
}
