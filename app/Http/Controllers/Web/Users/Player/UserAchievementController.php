<?php

namespace App\Http\Controllers\Web\Users\Player;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Model\UserMaster_model;
use App\Model\UserAchievement_model;
use App\Model\OrganisationMaster_model;

class UserAchievementController extends Controller
{
    protected $UserMaster_model;
    protected $UserAchievement_model;
    protected $OrganisationMaster_model;
    
    public function __construct(){
        $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    
    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->UserAchievement_model = new UserAchievement_model();
        $this->OrganisationMaster_model = new OrganisationMaster_model();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User_Achieve = $this->UserMaster_model->getAll();
        return view('user.achieve.index',compact('User_Achieve'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Orgs = $this->OrganisationMaster_model->getAllColumnWise('id,name');
        return view('user.achieve.add',compact('Orgs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request,[
            'title' => 'required|max:190',
            'name' => 'required|numeric',
//            'orgname' => 'required|max:190',
            'location' => 'required|max:190',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ]);
        $request->request->add(['user_master_id' => Auth::user()->user_master_id,]);
        $User_Achieve = $this->UserAchievement_model->SaveAchievement($request);
        
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $User_Exists = $this->UserAchievement_model->getCriProfileCountByUserMasterId(Auth::user()->user_master_id);
        if($User_Exists->count){
            $Bio = $this->UserMaster_model->getBioById(Auth::user()->user_master_id);
            $User_Achieve = $this->UserAchievement_model->getCriProfileByUserMasterId(Auth::user()->user_master_id);
            return view('user.achieve.show',compact('User_Achieve','Bio'));
        }else{
            return view('user.achieve.add');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Orgs = $this->OrganisationMaster_model->getAll();
        $User_Achieve = $this->UserAchievement_model->getById($id);
        return view('user.achieve.edit',compact('User_Achieve','Orgs'));
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
        $this->validate($request,[
            'title' => 'required|max:190',
            'name' => 'required|numeric',
//            'orgname' => 'required|max:190',
            'location' => 'required|max:190',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        $request->request->add(['user_master_id' => Auth::user()->user_master_id,'update' => 1,'id' => $id]);
        $User_Achieve = $this->UserAchievement_model->SaveUserBio($request);
        
        if(Auth::user()->role == "admin"){
            return redirect()->route('achieve.index');
        }else{
            $Bio = $this->UserMaster_model->getById(Auth::User()->user_master_id);
            return view('user.achieve.show',compact('User_Achieve','Bio'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $User_Achieve = $this->UserAchievement_model->getById($id);
        $User_Achieve->delete();
        return redirect()->back();
    }
}
