<?php
	class receipts extends Doctrine_Record {
		public function setTableDefinition(){
			$this->setTableName('RECEIPTS');
			$this->hasColumn('id','string',255,array('type'=>'string','length'=>255,'primary'=>true));
			$this->hasColumn('money','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('datenew','date');
			$this->hasColumn('attributes','blob');
		}
	}
?>