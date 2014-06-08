<?php
	class taxes extends Doctrine_Record {
		public function setTableDefinition(){
			$this->setTableName('TAXES');
			$this->hasColumn('id','string',255,array('type'=>'string','length'=>255,'primary'=>true));
			$this->hasColumn('name','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('validfrom','date');
			$this->hasColumn('category','string',255);
			$this->hasColumn('custcategory','string',255);
			$this->hasColumn('parentid','string',255);
			$this->hasColumn('rate','float');
			$this->hasColumn('ratecascade','boolean');
			$this->hasColumn('rateorder','integer',11); 
		}
	}
?>