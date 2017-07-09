<?php

namespace App\Http\Controllers\Web\Acl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Permission_model;
use App\Model\Role_model;

class PermissionControllerApi extends Controller
{

    protected $Permission_model;
    protected $Role_model;

    public function __construct(){
        $this->Permission_model = new Permission_model();
        $this->Role_model = new Role_model();
    }

    



}