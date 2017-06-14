<?php

namespace App\Http\Controllers\Web\CricketDetail\Tournament;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Model\UserMaster_model;
use App\Model\TournamentDetails_model;
use App\Model\TournamentMaster_model;
use App\Model\TournamentRules_model;
use App\Model\OrganisationMaster_model;
class TournamentMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $UserMaster_model;
    protected $OrganisationMaster_model;
    protected $TournamentDetails_model;
    protected $TournamentMaster_model;
    protected $TournamentRules_model;
    
    public function __construct(){
//        $this->middleware('auth:admin',['only'=>['index']]);
//        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    
    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->OrganisationMaster_model = new OrganisationMaster_model();
        $this->TournamentDetails_model = new TournamentDetails_model();
        $this->TournamentMaster_model = new TournamentMaster_model();
        $this->TournamentRules_model = new TournamentRules_model();
    }
    
    public function index()
    {
        $Tournaments = $this->TournamentMaster_model->getTourByOrgId(Auth::user()->organization_master_id);
        return view('user.tourmst.index',compact('Tournaments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.tourmst.add');
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
            'tournament_name' => 'required|max:190',
            'tournament_location' => 'required|max:190',
            'tournament_logo' => 'max:190',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'reg_start_date' => 'required|date|before:end_date',
            'reg_end_date' => 'required|date|after:start_date',
        ]);
        
        $Tournament_Exist = $this->TournamentMaster_model->TourNameExists(
                Auth::user()->organization_master_id,
                $request->tournament_name);
        if($Tournament_Exist){
            dd('Tournament Name Already Exist');
        }
        $params = array();
        $params['tournament_name'] = $request->tournament_name;
        $params['tournament_location'] = $request->tournament_location;
        $params['organization_master_id'] = Auth::user()->organization_master_id;
        $params['start_date'] = $request->start_date;
        $params['end_date'] = $request->end_date;
        $params['reg_start_date'] = $request->reg_start_date;
        $params['reg_end_date'] = $request->reg_end_date;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $data = $_POST['imagedata'];
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $filename = time().'.'.$image->getClientOriginalExtension();
            $data = base64_decode($data);
            file_put_contents(public_path('images/'. $filename), $data);
            $params['tournament_logo'] = $filename;
        }
        $Tournament = $this->TournamentMaster_model->SaveUserBio($params);
        
        return redirect()->route('tourmst.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Tournament = $this->TournamentMaster_model->getById($id);
        return view('user.tourmst.edit',compact('Tournament'));
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
            'tournament_name' => 'required|max:190',
            'tournament_location' => 'required|max:190',
            'tournament_logo' => 'max:190',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'reg_start_date' => 'required|date|before:end_date',
            'reg_end_date' => 'required|date|after:start_date',
        ]);
        
        
        $Tournament_Exist = $this->TournamentMaster_model->TournamentExists(
                Auth::user()->organization_master_id,
                $request->tournament_name);
        if($Tournament_Exist){
            dd('Tournament Name Already Exist');
        }
        
        $params = array();
        $params['id'] = $id;
        $params['tournament_name'] = $request->tournament_name;
        $params['tournament_location'] = $request->tournament_location;
        $params['organization_master_id'] = Auth::user()->organization_master_id;
        $params['start_date'] = $request->start_date;
        $params['end_date'] = $request->end_date;
        $params['reg_start_date'] = $request->reg_start_date;
        $params['reg_end_date'] = $request->reg_end_date;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $data = $_POST['imagedata'];
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $filename = time().'.'.$image->getClientOriginalExtension();
            $data = base64_decode($data);
            file_put_contents(public_path('images/'. $filename), $data);
            $params['tournament_logo'] = $filename;
        }
       $Tournament = $this->TournamentMaster_model->SaveUserBio($params);
        return redirect()->route('tourmst.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Tour_Mast = $this->TournamentMaster_model->getById($id);
        if($Tour_Mast){
            $Tour_Mast->delete();
            $this->TournamentDetails_model->deleteById($id);
        }else{
            dd('Not Exist');
        }
        return redirect()->route('tourmst.index');
        
    }
}
