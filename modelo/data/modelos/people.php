<?php
	class people extends Doctrine_Record {
		public function setTableDefinition(){
			$this->setTableName('PEOPLE');
			$this->hasColumn('id','string',255,array('type'=>'string','length'=>255,'primary'=>true));
			$this->hasColumn('name','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('apppassword','string',255,array('type'=>'string','length'=>255));
		}
	}
?>