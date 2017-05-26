<?php

namespace App\Model;
use App\Model\BasicModel\Permission;

class MatchMaster_model {

	public function __construct(){
		//parent::__construct();
	}

	public function getAll(){
		return Permission::get();
	}

	public function insert($request){
		$createUser = new Permission;
        $createUser->name = $request->name;
        $createUser->slug = $request->slug;
        $createUser->description = $request->description;
        $createUser->save();
        return $createUser;
	}
	
}