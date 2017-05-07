<?php

namespace App\Http\Controllers;
use App\Organisation_Master;
use App\User_Master;
use Illuminate\Http\Request;
use Auth;
use \App\User_Organisation;
class OrganizationMasterController extends Controller
{
    
    public function __construct(){
//        $this->middleware('auth:admin');
       $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth',['except'=>['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Orgs = Organisation_Master::all();
        return view('user.org.index',compact('Orgs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
//        dd('in create');
        $Orgs = Organisation_Master::selectRaw('id,name')->get();
        return view('user.org.add',compact('Orgs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
//        $Org_Exists = Organisation_Master::selectRaw('count(id) as count')->where('name')->get()->first();
//        if($Org_Exists->count){
//            
//        }
        $this->validate($request,[
            'name' => 'required',// Organisation Id
//            'orgname' => 'required',//Organisation name
            'address' => 'required',
            'landmark' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
            'business_type' => 'required',
            'business_operation' => 'required',
            'spoc' => 'required',
//            'is_verified' => 'required',
        ]);
        
//        $OrganisationId = 0;
//        if(request('name') == -1 ){
            $Org = new Organisation_Master;
            $Org->name = request('name');
            $Org->address = request('address');
            $Org->city = request('city');
            $Org->state = request('state');
            $Org->country = request('country');
            $Org->pincode = request('pincode');
            $Org->business_type = request('business_type');
            $Org->business_operation = request('business_operation');
            $Org->spoc = request('spoc');
            $Org->is_verified = 0;
            $Org->save();
//            $OrganisationId = $Org->id;
//        }else{
//            $OrganisationId = request('name');
//        }
        $User_Org = User_Organisation::find(Auth::user()->id);
        $User_Org->organization_master_id = $Org->id;
        $User_Org->role = 'organizer';
        $User_Org->save();
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
//        if(Auth::user()->role == "admin"){
//            return redirect()->route('org.index');
//        }
        $Bio = User_Master::find(Auth::user()->user_master_id);
        $Org = Organisation_Master::find($id);
        return view('user.org.show',compact('Org','Bio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Org = Organisation_Master::find($id);
        return view('user.org.edit', compact('Org'));
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
//        dd("in edit");
        $this->validate($request,[
            'name' => 'required|max:191',
            'address' => 'required|max:191',
            'landmark' => 'required|max:191',
            'city' => 'required|max:191',
            'state' => 'required|max:191',
            'country' => 'required|max:191',
            'pincode' => 'required|numeric|digits:6',
            'business_type' => 'required|max:191',
            'business_operation' => 'required|max:191',
            'spoc' => 'required|max:191',
        ]);
//        dd(request()->all());
        $Org = Organisation_Master::find($id);
        $Org->name = request('name');
        $Org->address = request('address');
        $Org->landmark = request('landmark');
        $Org->city = request('city');
        $Org->state = request('state');
        $Org->country = request('country');
        $Org->pincode = request('pincode');
        $Org->business_type = request('business_type');
        $Org->business_operation = request('business_operation');
//        if(request('is_verified')){
        $Org->is_verified = request('is_verified');
//        }else{
//            $Org->is_verified = 0;
//        }
        $Org->spoc = request('spoc');
        $Org->save();
        if(Auth::user()->role == "admin"){
            return redirect()->route('org.index');
        }else{
            $Bio = User_Master::find(Auth::user()->user_master_id);
            return view('user.org.show',compact('Org','Bio'));
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
