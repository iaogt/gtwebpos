<?php
	class closedcash extends Doctrine_Record {
		public function setTableDefinition(){
			$this->setTableName('CLOSEDCASH');
			$this->hasColumn('money','string',255,array('type'=>'string','length'=>255,'primary'=>true));
			$this->hasColumn('host','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('hostsequence','integer',11);
			$this->hasColumn('datestart','date');
			$this->hasColumn('dateend','date');
		}
	}
?>