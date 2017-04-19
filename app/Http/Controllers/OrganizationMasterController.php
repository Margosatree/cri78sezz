<?php

namespace App\Http\Controllers;
use App\Organisation_Master;
use Illuminate\Http\Request;
use Auth;
use \App\User_Organisation;
class OrganizationMasterController extends Controller
{
    
    public function __construct(){
//        $this->middleware('auth:admin');
//        $this->middleware('auth');
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
        $Org = Organisation_Master::find($id);
        return view('user.org.show',compact('Org'));
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
//        dd("in edit Valid");
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
        if(request('is_verified')){
            $Org->is_verified = request('is_verified');
        }
        $Org->spoc = request('spoc');
        $Org->save();
        return redirect()->route('org.index');   
        
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
