<?php
	class ticketlines extends Doctrine_Record {
		public function setTableDefinition(){
			$this->setTableName('TICKETLINES');
			$this->hasColumn('ticket','string',255,array('type'=>'string','length'=>255,'primary'=>true));
			$this->hasColumn('line','int',11,array('type'=>'integer','length'=>11,'primary'=>true));
			$this->hasColumn('product','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('attributesetinstance_id','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('units','float');
			$this->hasColumn('price','float');
			$this->hasColumn('taxid','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('attributes','blob');
		}
		
		public function setUp(){
			$this->hasOne('tickets',array('local'=>'ticket','foreign'=>'ticket'));
		}
	}
?> 