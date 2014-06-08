<?php
	class payments extends Doctrine_Record {
		public function setTableDefinition(){
			$this->setTableName('PAYMENTS');
			$this->hasColumn('id','string',255,array('type'=>'string','length'=>255,'primary'=>true));
			$this->hasColumn('receipt','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('payment','string',255);
			$this->hasColumn('total','float');
			$this->hasColumn('transid','string',255);
			$this->hasColumn('returnmsg','blob'); 
		}
	}
?>