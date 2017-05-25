<?php

namespace App\Http\Controllers;
use App\Model\OrganisationMaster_model;
use App\Model\UserCricketProfile_model;
use App\Model\UserMaster_model;
use App\Model\UserAchievement_model;
use Auth;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    protected $UserMaster_model;
    protected $OrganisationMaster_model;
    protected $UserCricketProfile_model;
    protected $UserAchievement_model;
    
    public function __construct(){
       $this->middleware('auth',['except'=>['showUser']]);
       $this->middleware('auth:admin',['only'=>['showUser']]);
       $this->_initModel();
    }
    
    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->OrganisationMaster_model = new OrganisationMaster_model();
        $this->UserCricketProfile_model = new UserCricketProfile_model();
        $this->UserAchievement_model = new UserAchievement_model();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "hii";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      // dd($id);
        $data=$this->_show($id);
        return view('user.profile.show', $data);


    }

    public function showUser($id){
      // dd($id);
          $data=$this->_show($id);
          return view('user.profile.show', $data);

    }


    private function _show($id){

        if(!Auth::guard('admin')->check()){
            $user_id = Auth::user();
        }else{
            $user_id= Auth::guard('admin')->user();
        }

        $Sr = 0;
        $Bio = $this->UserMaster_model->getBioById($id);
        $Cri_Profile = $this->UserCricketProfile_model->getCriProfileByUserMasterId($user_id->user_master_id);
        $User_Achieves = $this->UserAchievement_model->getAchievementByUserMasterId($user_id->user_master_id);
        $Org = $this->OrganisationMaster_model->getOrgByOrgMasterId($user_id->organization_master_id);
        $data=['Bio'=> $Bio,'Cri_Profile'=> $Cri_Profile,'User_Achieves'=> $User_Achieves,'Org'=> $Org];
        return $data;
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
