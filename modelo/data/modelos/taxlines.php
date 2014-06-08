<?php
	class taxlines extends Doctrine_Record {
		public function setTableDefinition(){
			$this->setTableName('TAXLINES');
			$this->hasColumn('id','string',255,array('type'=>'string','length'=>255,'primary'=>true));
			$this->hasColumn('receipt','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('taxid','varchar',255);
			$this->hasColumn('base','float');
			$this->hasColumn('amount','float');
		}
	}
?>