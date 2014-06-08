<?php
	class ticketsnum extends Doctrine_Record {
		public function setTableDefinition(){
			$this->setTableName('TICKETSNUM');
			$this->hasColumn('id','int',11,array('type'=>'integer','length'=>11));
		}
	}
?>