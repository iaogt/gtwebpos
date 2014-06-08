<?php
	require_once 'dataLayer.php';
	/**
	 * Esta clase se utiliza para abstraer la data independiente de la capa de datos que se use
	 * Es recomendado utilizarla para que en las p�ginas no se haga referencia directa a las clases que representan el modelo (Doctrine en este caso) 
	 * */
	class Modelo {

		public function countUsers()  {
		 return Doctrine_Query::create()->select("count(*)")->from('user')->execute()->toArray();
                } 
		
		
		public function getAdmin ($uid, $pass) {
			$q = Doctrine_Query::create()
				->select("*")
				->from("admin")
				->where("adm_user = '".$uid."'")
				->andWhere("adm_pass = '".$pass."'");
			return $q->execute(array(), Doctrine::HYDRATE_ARRAY);
		}
		public function getUsersPerDay() {
			$q = Doctrine_Query::create()
			->select('usr_date, count(*) as usr_count')
			->from("user")
			->groupBy("date(usr_date)")
			->orderBy("usr_date asc");
			$obj = $q->execute();
			return $obj;
		}
		public function getUsersPerCountry() {
			$q = Doctrine_Query::create()
			->select('usr_country_name, count(*) as usr_count')
			->from("user")
			->groupBy("usr_country_code")
			->orderBy("usr_country_name");
			$obj = $q->execute();
			return $obj;
		}
		public function getVideosPerDay() {
			$q = Doctrine_Query::create()
			->select('vid_date, count(*) as vid_count')
			->from("video")
			->groupBy("date(vid_date)")
			->orderBy("vid_date asc");
			$obj = $q->execute();
			return $obj;
		}
		public function getVotesPerDay() {
			$q = Doctrine_Query::create()
			->select('vte_date, sum(vte_value) as vte_count')
			->from("vote")
			->groupBy("vte_date")
			->orderBy("vte_date asc");
			$obj = $q->execute();
			return $obj;
		}
		public function getVotesPerDayDetail($date) {
			$q = Doctrine_Query::create()
			->select('*')
			->from("vote")
			->where("vte_date = ?",$date)
			->orderBy("vte_timestamp asc");
			$obj = $q->execute();
			return $obj;
		}
		public function getVotesPerDayDetailResume($date) {
			$q = Doctrine_Query::create()
			->select('vte_vid_id, vte_date, sum(vte_value) as vte_count')
			->from("vote")
			->where("vte_date = ?",$date)
			->groupBy("vte_vid_id")
			->orderBy("vte_date asc");
			$obj = $q->execute();
			return $obj;
		}
		public function getCountryCountVideos($countryCode){
			$q = Doctrine_Query::create()
			->select('count(*) cant')
			->from('video v')
			->leftJoin('v.form f')
			->where('f.frm_country = ?',$countryCode);
			return $q->execute()->getFirst()->cant;
		}
		
		public function getUsersWithoutVideos(){
			$q = Doctrine_Query::create()
			->select('*')
			->from('user u')
			->leftJoin('u.videos v')
			->leftJoin('u.form f')
			->where('v.vid_usr_uid is null')
			->andWhere('(u.usr_name_long != "" && u.usr_email != "") or f.frm_email is not null')
			->groupBy('u.usr_uid');
			return $q->execute();
		}
		
		public function getUsersWithVideos(){
			$q = Doctrine_Query::create()
			->select('*')
			->from('form f')
			->leftJoin('f.videos v')
			->where('v.vid_usr_uid is not null')
			->groupBy('f.frm_email');
			return $q->execute();
		}
		
		public function getReportComment ($limite, $offset) 
		{
			$q = Doctrine_Query::create()
				->select('*')
				->from('comment')
				->where('cmt_reported = "1"')
				->orderBy('cmt_id DESC')
				->limit($limite)
				->offset($offset);
			return $q->execute();
				
		}
		
		
		public function getTotalReportComment () 
		{
			$q = Doctrine_Query::create()
				->select('COUNT(cmt_id) AS total')
				->from('comment')
				->where('cmt_reported = "1"');
			return $q->execute();
		}
		
		
		public function getComentsDel ($limite, $offset) 
		{
			$q = Doctrine_Query::create()
				->select('*')
				->from('comment')
				->where('cmt_visible = "0"')
				->orderBy('cmt_id DESC')
				->limit($limite)
				->offset($offset);
			return $q->execute();
		}
		
		
		public function getTotalComentsDel () 
		{
			$q = Doctrine_Query::create()
				->select('COUNT(cmt_id) AS total')
				->from('comment')
				->where('cmt_visible = "0"');
			return $q->execute();
		}
		
		public function habilitarComment ($cid) {
			$objComment = Doctrine::getTable('comment')->find($cid);
			if ($objComment) {
				$objComment->cmt_visible = '1';
				$objComment->save();
			}
		}
		
		
		public function revokeReportComment ($cid) {
			$objComment = Doctrine::getTable('comment')->find($cid);
			if ($objComment) {
				$objComment->cmt_reported = '0';
				$objComment->save();
			}
		}
		
		
		public function removeComment ($cid) {
			$objComment = Doctrine::getTable('comment')->find($cid);
			if ($objComment) {
				$objComment->cmt_reported	= '0';
				$objComment->cmt_visible	= '0';
				$objComment->save();
			}
		}
		
     
     	public function getTotalAdmins () {
     		$q = Doctrine_Query::create()
     			->select("COUNT(*) as total")
     			->from("admin");
     		return $q->execute(array(), Doctrine::HYDRATE_ARRAY);
     	}
     	
     	
     	public function getAdmins(){
     		$q = Doctrine_Query::create()
     			->select("*")
     			->from("admin")
     			->orderBy("adm_date DESC");
     		return $q->execute(array(), Doctrine::HYDRATE_ARRAY);
     	}
     	
     	
     	public function insertAdmin ($new_u, $new_p) {
	     	$admin = new admin();
	     	$admin->adm_user = $new_u;
	     	$admin->adm_pass = md5($new_p);
			try{
				$admin->save();
			}catch(Exception $e){
				//No se pudo grabar
				if($e->getMessage()!="Couldn't get last insert identifier.")
				{
					return false;
				}
			}
			return true;

     	}
     	
     	
     	public function modificarAdmin ($aid, $new_u) {
     		$admin = Doctrine::getTable('admin')->find($aid);
     		$admin->adm_user = $new_u;
     		try{
				$admin->save();
			}catch(Exception $e){
				//No se pudo grabar
				if($e->getMessage()!="Couldn't get last insert identifier.")
				{
					return false;
				}
			}
			return true;
     	}
     	
     	
     	public function modificaPassword ($aid, $oldP, $newP) {
     		$admin = Doctrine::getTable('admin')->find($aid);
     		if ($admin->adm_pass == md5($oldP)) {
     			$admin->adm_pass = md5($newP);
     			$admin->save();
     			return true;
     		}
     		return false;
     	}
     	
     	
     	public function eliminarAdmin($aid) {
     		$q = Doctrine_Query::create()
     			->delete("admin")
     			->where("adm_id = '".$aid."'");
     		$q->execute();
     		return true;
     	}
		
    public function getConf(){
	$objConf = Doctrine_Query::create()->select('*')
		->from('config')
                ->execute();
        $arrConf = $objConf->toArray();
        $result = array();
        foreach($arrConf as $conf){
            $result[$conf["cfg_name"]]=$conf["cfg_value"];
        }
        return $result;
     }
     
    public function getUsersByPage($page,$cantPag) {
        $paginador = new Doctrine_Pager(
            Doctrine_Query::create()
                ->select('u.*')
                ->from('user u')
                ->orderby('usr_date desc'),
            $page,
            $cantPag
        );
        return $paginador;
    }
    
    public function getTableCount($name_table,$whereStr="") {
        $q = Doctrine_Query::create()
                ->select('COUNT(*) AS total_data')
                ->from($name_table);
        if($whereStr!= ""){
                $q->where($whereStr);
        }
        $arr = $q->execute()->toArray();
        //return $arr[0]["total_data"]+rand(100,1000);
        return $arr[0]["total_data"];
    }
    public function getTable($name_table,$limit=0,$offset=0,$order='',$whereStr="") {
        $q = Doctrine_Query::create()
                ->select('*')
                ->from($name_table)->limit($limit)->offset($offset)
        ->where("1=1");
        if($whereStr!= ""){
                $q->where($whereStr);
        }
        if($order!= ""){
                $q->orderBy($order);
        }
        $obj = $q->execute();
        return $obj;
    }
    public function getTableCountFiltered($name_table,$whereStr="",$typeStr="") {
    	$q = Doctrine_Query::create()
    	->select('COUNT(*) AS total_data')
    	->from($name_table)->where("1=1");
    	if($whereStr!= ""){
    		$q->andwhere($whereStr);
    	}
    	if($typeStr=="pending"){
    		$q->andwhere("vid_visible=1");
    		$q->andwhere("vid_state=0");
    		$q->andwhere("vid_key is null");
    	}else if($typeStr=="pendingYoutube"){
    		$q->andwhere("vid_visible=1");
    		$q->andwhere("vid_state=0");
    		$q->andwhere("vid_key is not null");
    	}else if($typeStr=="approved"){
    		$q->andwhere("vid_visible=1");
    		$q->andwhere("vid_state=1");
    		$q->andwhere("vid_key is not null");
    	}else if($typeStr=="denied"){
    		$q->andwhere("vid_visible=0");
    		//$q->andwhere("vid_state=1");
    		//$q->andwhere("vid_key is not null");
    	}
    	$arr = $q->execute()->toArray();
    	return $arr[0]["total_data"];
    }
    public function getTableFiltered($name_table,$limit=0,$offset=0,$order='',$whereStr="",$typeStr="") {
        $q = Doctrine_Query::create()
                ->select('*')
                ->from($name_table)->limit($limit)->offset($offset)->where("1=1");
        if($whereStr!= ""){
                $q->andwhere($whereStr);
        }
        if($typeStr=="pending"){
        	$q->andwhere("vid_visible=1");
        	$q->andwhere("vid_state=0");
        	$q->andwhere("vid_key is null");
        }else if($typeStr=="pendingYoutube"){
    		$q->andwhere("vid_visible=1");
    		$q->andwhere("vid_state=0");
    		$q->andwhere("vid_key is not null");
    	}else if($typeStr=="approved"){
        	$q->andwhere("vid_visible=1");
        	$q->andwhere("vid_state=1");
        	$q->andwhere("vid_key is not null");
        }else if($typeStr=="denied"){
        	$q->andwhere("vid_visible=0");
        	//$q->andwhere("vid_state=1");
        	//$q->andwhere("vid_key is not null");
        }
        
        if($order!= ""){
                $q->orderBy($order);
        }
        $obj = $q->execute();
        return $obj;
    }
    public function getVotesByVideo($vid) {
    	$q = Doctrine_Query::create()
    	->select('*')
    	->from("vote")
    	->where("vte_vid_id=?",$vid)
    	->orderBy("vte_timestamp desc");
    	$obj = $q->execute();
    	return $obj;
    }
    public function getCountVotesByVideo($vid) {
    	$q = Doctrine_Query::create()
    	->select('count(*) cant')
    	->from("vote")
    	->where("vte_vid_id=?",$vid);
    	$obj = $q->execute();
    	return $obj->cant;
    }
    public function getCountCommentsByVideo($vid) {
    	$q = Doctrine_Query::create()
    	->select('count(*) cant')
    	->from("comment")
    	->where("cmt_vid_id=?",$vid);
    	$obj = $q->execute();
    	return $obj->cant;
    }
    public function getLogByDate($date) {
    	$q = Doctrine_Query::create()
    	->select('*')
    	->from("log")
    	->where("date(lth_date)=?",$date);
    	$obj = $q->execute();
    	return $obj;
    }
    public function getVideo($id) {
        $q = Doctrine::getTable('video')->find($id);
        return $q;
    }
    public function getVideoUser($id) {
    	$q = Doctrine::getTable('video')->find($id);
    	if($q!=null){
    		return $q->form;
    	}else{
    		return null;
    	}
    }
    
    public function hideVideo($id) {                                                                      
    	$video = self::getVideo($id);
    	$video->vid_visible = 0;
    	$video->vid_date_authorized = new Doctrine_Expression('NOW()');
    	$video->save();
     	return true;
    }
    public function showVideo($id) {
    	$video = self::getVideo($id);
    	$video->vid_visible = 1;
    	//$video->vid_date_authorized = new Doctrine_Expression('NOW()');
    	$video->save();
    	return true;
    }
    public function publishVideo($id) {
    	$video = self::getVideo($id);
    	$video->vid_state = 1;
    	//$video->vid_date_authorized = new Doctrine_Expression('NOW()');
    	$video->save();
		$q = Doctrine_Query::create()
    	->select('*')
    	->from("rank r")
    	->where("vid_id = ?",$id);
    	$obj = $q->execute()->getFirst();
		if($obj){
			$obj->vid_visible=1;
			$obj->save();
		}
    	return true;
    }
    public function unpublishVideo($id) {
    	$video = self::getVideo($id);
    	$video->vid_state = 0;
    	$video->save();
		$q = Doctrine_Query::create()
    	->select('*')
    	->from("rank r")
    	->where("vid_id = ?",$id);
    	$obj = $q->execute()->getFirst();
		if($obj){
			$obj->vid_visible=0;
			$obj->save();
		}
    	return true;
    }
    public function setVideoKey($id,$key) {
    	$video = self::getVideo($id);
    	//$video->vid_state = 1;
    	$video->vid_key = $key;
    	$video->vid_date_authorized = new Doctrine_Expression('NOW()');
    	$video->save();
		
		$q = Doctrine_Query::create()
    	->select('*')
    	->from("rank r")
    	->where("vid_id = ?",$id);
    	$obj = $q->execute()->getFirst();
		if($obj){
			$obj->vid_key=$key;
			$obj->save();
		}
    	return $obj;
		
    	return true;
    }
    public function isVideoPublished($id) {
    	$video = self::getVideo($id);
    	return $video->vid_key!=null;
    }
    
    public function deleVotesFrom($id) {
        /*$q = Doctrine_Query::create()
     			->delete("vote")
     			->where("vte_vid_id = ?",$id);
     		$q->execute();*/
     		return true;
    }
    
    public function getTop ($fids, $limite, $offset, $general) {
			if ($general) {
				$q = Doctrine_Query::create()
					->select('COUNT(v.vte_uid) AS puntos, v.vte_img_id, i.img_code AS codigo, i.img_id AS id,i.img_desc as desc,i.img_code as img_code, i.img_date as date')
					->from('vote v')
					->leftJoin('v.images i')
					//->where('v.vte_img_id = i.img_id')
					->groupBy('v.vte_img_id')
					->orderBy('puntos DESC')
					->limit($limite)
					->offset($offset);
			} else {
				$usuarios = implode(',', $fids);
				$q = Doctrine_Query::create()
					->select('COUNT(v.vte_uid) AS puntos, v.vte_img_id, i.img_code AS codigo, i.img_id AS id')
					->from('vote v')
					->leftJoin('v.images i')
					//->where('v.vte_img_id = i.img_id')
					->where('i.img_uid IN ('.$usuarios.')')
					->groupBy('v.vte_img_id')
					->orderBy('puntos DESC')
					->limit($limite)
					->offset($offset);
			}
			return $q->execute();
		}  
		public function addActionToLog ($adm_id, $vid_id, $action) {
			$log = new log();
			$log->lth_adm_id = $adm_id;
			$log->lth_vid_id = $vid_id;
			$log->lth_action = $action;
			$log->lth_date = new Doctrine_Expression('NOW()');
			try{
				$log->save();
			}catch(Exception $e){
				//No se pudo grabar
				if($e->getMessage()!="Couldn't get last insert identifier.")
				{
					return false;
				}
			}
			return true;
		
		} 
		
		public function getLogDates() {
			$q = Doctrine_Query::create()
			->select("date(lth_date) as lthdate")
			->from("log")
			->groupBy("date(lth_date) ");
			return $q->execute();
		}
		public function getLogStatusByDate($date) {
			$q = Doctrine_Query::create()
			->select("*, count(*) as totals")
			->from("log")
			->where("date(lth_date) = ?",$date)
			->groupBy("lth_action");
			return $q->execute();
		}
		public function getCountVideosFrom($date){
			$q = Doctrine_Query::create()
			->select("*")
			->from("video")
			->where("date(vid_date) <= ?",$date);
			return $q->execute();
		}
}		
?>