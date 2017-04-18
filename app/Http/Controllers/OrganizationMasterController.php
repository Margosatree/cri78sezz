<?php

namespace App\Http\Controllers;
use App\Organisation_Master;
use Illuminate\Http\Request;
use Auth;
use \App\User_Organisation;
class OrganizationMasterController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('user.organisation');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        $this->validate($request,[
            'name' => 'required',
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
        $Org = new Organisation_Master;
        $Org->fill($request->all());
        $Org->save();
        return redirect()->to('/verify');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Auth::user()->organization_master_id;
        $User_Org = User_Organisation::find($id);
//        dd($User_Org);
//        if($User_Org == null){
//            return view('user.organisationshow');
//        }else{
        return view('user.organisationshow', compact('User_Org'));
//        }
        
//        return view('user.organisationshow');
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
//        dd("DASDAS");
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
        
        $id = Auth::user()->organization_master_id;
        $Org = Organisation_Master::find($id);
//        dd($User_Org);
        if($Org != null){
            $Org->name = request('name');
            $Org->address = request('address');
            $Org->landmark = request('landmark');
            $Org->city = request('city');
            $Org->state = request('state');
            $Org->country = request('country');
            $Org->pincode = request('pincode');
            $Org->business_type = request('business_type');
            $Org->business_operation = request('business_operation');
            $Org->spoc = request('spoc');
            $Org->save();
        }else{
            $Org = new Organisation_Master;
            $Org->name = request('name');
            $Org->address = request('address');
            $Org->landmark = request('landmark');
            $Org->city = request('city');
            $Org->state = request('state');
            $Org->country = request('country');
            $Org->pincode = request('pincode');
            $Org->business_type = request('business_type');
            $Org->business_operation = request('business_operation');
            $Org->spoc = request('spoc');
            $Org->save();
            
            $User_Org = User_Organisation::find(Auth::user()->id);
            $User_Org->organization_master_id = $Org->id;
            $User_Org->save();
        }
        
        
        return redirect()->route('home');
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
