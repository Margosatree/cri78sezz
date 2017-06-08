<?php

namespace App\Http\Controllers\Web\Users\Player;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\UserMaster_model;

class UsersBioController extends Controller
{

    protected $UserMaster_model;
    
    public function __construct(){
        $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }

    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User_Bios = $this->getAll();
        return view('user.bio.index',compact('User_Bios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createInfo(){
        return view('user.bio.addinfo');
    }

    public function create()
    {
        return view('user.bio.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeInfo(Request $request){
        $this->validate(request(), [
            'first_name' => 'required|max:50|alpha',
            'middle_name' => 'required|max:50|alpha',
            'last_name' => 'required|max:50|alpha',
            'date_of_birth' => 'required|date|before:'.date('Y-m-d', strtotime('-5 year')),
            'gender' => 'in:female,male',
            'physically_challenged' => 'in:no,yes',
        ]);
        
        $User_Bio = $this->UserMaster_model->SaveUserBio($request);
        return redirect()->route('userBio.create');
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'address' => 'required|max:255',
            'suburb' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
            'country' => 'required|max:255',
            'pin' => 'required|digits:6|numeric',
        ]);
        
        
        $User_Address = $this->UserMaster_model->SaveUserAddress($request);
        return redirect()->route('orgcriProfile.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Bio = User_Master::find($id);
        return view('user.bio.show',compact('Bio'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editInfo($id){
        $Bio = $this->UserMaster_model->getById($id);
        return view('user.bio.editInfo', compact('Bio'));
    }

    public function edit($id){
        $Bio = $this->UserMaster_model->getById($id);
        return view('user.bio.edit', compact('Bio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id){
        $callfrom = "";
        if($request->first_name || $request->middle_name || $request->last_name ||
           $request->date_of_birth || $request->gender || $request->physically_challenged){
            $this->validate(request(), [
                'first_name' => 'required|max:255',
                'middle_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:female,male,others',
                'physically_challenged' => 'required|in:no,yes',
            ]);
            $callfrom = 'info';
        }else{
            $this->validate(request(), [
                'address' => 'required|max:255',
                'suburb' => 'required|max:255',
                'city' => 'required|max:255',
                'state' => 'required|max:255',
                'country' => 'required|max:255',
                'pin' => 'required|digits:6|numeric',
            ]);
        }
        
        $Bio = $this->UserMaster_model->getById($id);
        if($callfrom == 'info'){
            $request->request->add(['update' => 1,'id' => Auth::user()->user_master_id]);
            $User_Bio = $this->UserMaster_model->SaveUserBio($request);
        }else{
            $request->request->add(['update' => 1,'id' => Auth::user()->user_master_id]);
            $User_Address = $this->UserMaster_model->SaveUserAddress($request);
        }
        if(Auth::user()->role == "admin"){
            return redirect()->route('userBio.index');
        }else{
            return view('user.bio.show',compact('Bio'));
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
        dd("i am at destroy");
    }
}
