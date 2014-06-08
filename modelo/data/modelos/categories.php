<?php
	class categories extends Doctrine_Record {
		public function setTableDefinition(){
			$this->setTableName('CATEGORIES');
			$this->hasColumn('id','string',255,array('type'=>'string','length'=>255,'primary'=>true));
			$this->hasColumn('name','string',255,array('type'=>'string','length'=>255));
			}
	}
?>