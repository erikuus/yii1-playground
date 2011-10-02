<?php
class InstallController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionCreate()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->createTable();
			$this->render('done');
		}
		else
			throw new CHttpException(400);
	}

	protected function createTable()
	{
		if($db=Yii::app()->db)
		{
			// table name
			$helpTable=Yii::app()->controller->module->helpTable;

			// create table
			$sql="
				CREATE TABLE $helpTable
				(
					id serial NOT NULL,
					code character varying(64),
					title_et character varying(256),
					content_et text,
					title_en character varying(256),
					content_en text,
					CONSTRAINT pk_help PRIMARY KEY (id)
				);
			";
			$db->createCommand($sql)->execute();

			// insert into table
			$sql="
				INSERT INTO $helpTable (code,title_et,content_et,title_en,content_en)
				VALUES ('annotation','Tutvustus','Siia tuleb tutvustus...','Annotation','Here comes annotation...');
			";
			$db->createCommand($sql)->execute();
		}
		else
			throw new CException('Database connection is not working!');
	}
}