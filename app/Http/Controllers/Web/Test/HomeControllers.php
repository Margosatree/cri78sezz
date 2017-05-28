<?php

namespace App\Http\Controllers\Web\Test;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Model\RoleUser_model;


class HomeControllers extends Controller
{
  protected $RoleUser_model;
    public function test()
    {
      $this->RoleUser_model = new RoleUser_model;

      $is_admin = 0;
      $get_perms = $this->RoleUser_model->getPermissionsByUserId($id=3,$is_admin);
      dd($get_perms);
    }

}
