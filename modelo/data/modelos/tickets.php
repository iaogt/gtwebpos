<?php
	class tickets extends Doctrine_Record {
		public function setTableDefinition(){
			$this->setTableName('TICKETS');
			$this->hasColumn('id','string',255,array('type'=>'string','length'=>255,'primary'=>true));
			$this->hasColumn('tickettype','integer',11,array('type'=>'integer','length'=>11));
			$this->hasColumn('ticketid','integer',11,array('type'=>'integer','length'=>11));
			$this->hasColumn('person','string',255);
			$this->hasColumn('customer','string',255);
			$this->hasColumn('status','integer',11);
		}
		
		public function setUp(){ 
			$this->hasMany('ticketlines as prods',array('local'=>'ticket','foreign'=>'ticket'));
		}
	}
?>