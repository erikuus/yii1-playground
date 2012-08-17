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
			$lookupTable=Yii::app()->controller->module->lookupTable;

			// create table
			$sql="
				CREATE TABLE $lookupTable
				(
					id serial NOT NULL,
					code integer,
					name_et character varying(256),
					name_en character varying(256),
					type character varying(64),
					position integer,
					CONSTRAINT pk_lookup PRIMARY KEY (id)
				);
			";
			$db->createCommand($sql)->execute();

			// insert into table
			$sql="INSERT INTO $lookupTable (code,name_et,name_en,type,position) VALUES (1,'Ajalooarhiiv','Historical Archive','archive',1);";
			$db->createCommand($sql)->execute();
			$sql="INSERT INTO $lookupTable (code,name_et,name_en,type,position) VALUES (2,'Riigiarhiiv','State Archive','archive',2);";
			$db->createCommand($sql)->execute();
			$sql="INSERT INTO $lookupTable (code,name_et,name_en,type,position) VALUES (3,'Filmiarhiiv','Film Archive','archive',3);";
			$db->createCommand($sql)->execute();
		}
		else
			throw new CException('Database connection is not working!');
	}
}