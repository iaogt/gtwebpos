<?php
	class products extends Doctrine_Record {
		public function setTableDefinition(){
			$this->setTableName('PRODUCTS');
			$this->hasColumn('id','string',255,array('type'=>'string','length'=>255,'primary'=>true));
			$this->hasColumn('reference','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('code','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('codetype','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('name','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('pricebuy','float');
			$this->hasColumn('pricesell','float');
			$this->hasColumn('category','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('taxcat','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('attributeset_id','string',255,array('type'=>'string','length'=>255));
			$this->hasColumn('stockcost','float');
			$this->hasColumn('stockvolume','float');
			$this->hasColumn('image','blob');
			$this->hasColumn('iscom','boolean');
			$this->hasColumn('isscale','boolean');
			$this->hasColumn('attributes','blob');
		}
	}
?>