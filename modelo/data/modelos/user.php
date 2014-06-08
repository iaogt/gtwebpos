<?php
	/**
	 * Clase que representa un registro recurso en la base de datos
	 * Esta clase es específica para usar con doctrine
	 * */
	class user extends Doctrine_Record {
                public function setTableDefinition(){
			$this->setTableName('usr_user');
			$this->hasColumn('usr_uid', 'string', 20, array(
                                'type'=>'string',
                                'length'=>'20',
                                'primary'=>true
                            )
                        );
			$this->hasColumn('usr_gender', 'string', 10, array(
                                'type'=>'string',
                                'length'=>'20'
                            )
                        );
			$this->hasColumn('usr_country', 'string', 20, array(
                                'type'=>'string',
                                'length'=>'20'
                            )
                        );
			$this->hasColumn('usr_current_country', 'string', 20, array(
                                'type'=>'string',
                                'length'=>'20'
                            )
                        );
			$this->hasColumn('usr_date', 'timestamp', 25, array(
                                'type'=>'timestamp',
                                'length'=>'25'
                            )
                        );
			$this->hasColumn('usr_name_long', 'string', 150, array(
                                'type'=>'string',
                                'length'=>'150'
                            )
                        );
			$this->hasColumn('usr_email', 'string', 150, array(
                                'type'=>'string',
                                'length'=>'150'
                            )
                        );
			$this->hasColumn('usr_ip', 'string', 20, array(
					'type'=>'string',
					'length'=>'20'
							)
						);
			$this->hasColumn('usr_user_agent', 'string', 200, array(
					'type'=>'string',
					'length'=>'200'
							)
						);
			$this->hasColumn('usr_country_code', 'string', 5, array(
					'type'=>'string',
					'length'=>'5'
							)
					);
			$this->hasColumn('usr_country_name', 'string', 25, array(
					'type'=>'string',
					'length'=>'25'
							)
						);
		}
		public function setUp(){
			$this->hasMany('video as videos',array(
					'local'=>'usr_uid',
					'foreign'=>'vid_usr_uid'
			)
			);
			$this->hasOne('form as form',array(
					'local'=>'usr_uid',
					'foreign'=>'frm_usr_uid'
			)
			);
		}
	}
?>