<?php

namespace App\Http\Controllers;
use App\Model\UserCricketProfile_model;
use App\Model\UserMaster_model;
use Illuminate\Http\Request;
use Auth;
use Image;
use Storage;
use Session;
class UserCricketProfileController extends Controller
{
    protected $UserMaster_model;
    protected $UserCricketProfile_model;

    public function __construct(){
        $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->UserCricketProfile_model = new UserCricketProfile_model();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Cri_Profiles = User_Cricket_Profile::all();
        return view('user.criprofile.index',compact('Cri_Profiles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.criprofile.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request){
       // dd($request->all());
        $this->validate($request,[
            'your_role' => 'required|numeric',
            'batsman_style' => 'required|in:Lefthand,Righthand',
            'batsman_order' => 'required|numeric',
            'bowler_style' => 'required|in:Lefthand,Righthand',
            'player_type' => 'required|max:255',
            'description' => 'required|max:255',
            'image'=>'required|image',
//            'display_img' => 'required|max:255',
//            'is_completed' => 'required|numeric',
        ]);
        
        $params = array();
        $params['user_master_id'] = Auth::user()->user_master_id;
        $params['your_role'] = $request->your_role;
        $params['batsman_style'] = $request->batsman_style;
        $params['batsman_order'] = $request->batsman_order;
        $params['bowler_style'] = $request->bowler_style;
        $params['player_type'] = $request->player_type;
        $params['description'] = $request->description;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $data = $_POST['imagedata'];
            
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $filename = time().'.'.$image->getClientOriginalExtension();
//            $filename = time().base64_encode($User_Cri_Profile->id).'.'.$image->getClientOriginalExtension();
            $data = base64_decode($data);
            file_put_contents(public_path('images/'. $filename), $data);
            $params['display_img'] = $filename;
            $request->session()->put('user_img', $params['display_img']);
        }
        $User_Cri_Profile = $this->UserCricketProfile_model->SaveCriProfile($params);
        
        return redirect()->route('userAchieve.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        dd($id);
        if(!Auth::guard('admin')->check()){
            $id = Auth::user()->user_master_id;
        }else{
            $id = Auth::guard('admin')->user()->user_master_id;
        }
        $User_Exists = $this->UserCricketProfile_model->getCriProfileCountByUserMasterId(Auth::user()->user_master_id);
        if($User_Exists->count){
            $Bio = $this->UserMaster_model->getBioById($id);
            $Cri_Profile = $this->UserCricketProfile_model->getBioByUserMasterId($id);
            return view('user.criprofile.show',compact('Cri_Profile','Bio'));
        }else{
            return view('user.criprofile.add');
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
        $Cri_Profile = User_Cricket_Profile::find($id);
        return view('user.criprofile.edit',compact('Cri_Profile'));
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
        
//        dd(request()->all());
        $this->validate($request,[
            'your_role' => 'required|numeric',
            'batsman_style' => 'required|in:Lefthand,Righthand',
            'batsman_order' => 'required|numeric',
            'bowler_style' => 'required|in:Lefthand,Righthand',
            'player_type' => 'required|max:255',
            'description' => 'required|max:255',
            'image'=>'required|image',
//            'display_img' => 'required|max:255',
//            'is_completed' => 'required|numeric',
        ]);
        $params = array();
        $params['id'] = $id;
        $params['user_master_id'] = Auth::user()->user_master_id;
        $params['your_role'] = $request->your_role;
        $params['batsman_style'] = $request->batsman_style;
        $params['batsman_order'] = $request->batsman_order;
        $params['bowler_style'] = $request->bowler_style;
        $params['player_type'] = $request->player_type;
        $params['description'] = $request->description;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $data = $_POST['imagedata'];
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $filename = time().'.'.$image->getClientOriginalExtension();
//            $filename = time().base64_encode($Cri_Profile->id).'.'.$image->getClientOriginalExtension();
            $data = base64_decode($data);
            file_put_contents(public_path('images/'. $filename), $data);
            $params['display_img'] = $filename;
            $request->session()->put('user_img', $params['display_img']);
        }
        if(Auth::user()->role == "admin"){
            return redirect()->route('criProfile.index');
        }else{
            $Bio = User_Master::find(Auth::User()->user_master_id);
            return view('user.criprofile.show',compact('Cri_Profile','Bio'));
        }
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
