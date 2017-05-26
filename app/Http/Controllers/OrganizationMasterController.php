<?php

namespace App\Http\Controllers;
use App\Model\OrganisationMaster_model;
use App\Model\UserMaster_model;
use App\Model\UserOrganisation_model;
use Illuminate\Http\Request;
use Auth;
use \App\User_Organisation;
class OrganizationMasterController extends Controller
{
    protected $UserMaster_model;
    protected $OrganisationMaster_model;
    protected $UserOrganisation_model;
    
    public function __construct(){
        $this->middleware('auth:admin',['only'=>['index']]);
        $this->middleware('auth',['except'=>['index']]);
        $this->_initModel();
    }
    
    protected function _initModel(){
        $this->UserMaster_model = new UserMaster_model();
        $this->OrganisationMaster_model = new OrganisationMaster_model();
        $this->UserOrganisation_model = new UserOrganisation_model();
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
        $Orgs = $this->OrganisationMaster_model->getRaw('id,name');
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

        $params = array();
        $params['name'] = $request->name;
        $params['address'] = $request->address;
        $params['city'] = $request->city;
        $params['state'] = $request->state;
        $params['country'] = $request->country;
        $params['pincode'] = $request->pincode;
        $params['business_type'] = $request->business_type;
        $params['business_operation'] = $request->business_operation;
        $params['spoc'] = $request->spoc;
        $params['is_verified'] = 0;
        $Org = $this->OrganisationMaster_model->SaveOrg($params);
        
        unset($params);
        $params = array();
        $params['id'] = Auth::user()->id;
        $params['organization_master_id'] = $request->organization_master_id;
        $params['role'] = 'organizer';
        $User_Org = $this->UserOrganisation_model->SaveUserOrg($params);
        
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
        $Bio = $this->UserMaster_model->getById(Auth::user()->user_master_id);
        $Org = $this->OrganisationMaster_model->getById($id);
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
        $Org = $this->OrganisationMaster_model->getById($id);
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
        
        $params = array();
        $params['id'] = $id;
        $params['name'] = $request->name;
        $params['address'] = $request->address;
        $params['city'] = $request->city;
        $params['state'] = $request->state;
        $params['country'] = $request->country;
        $params['pincode'] = $request->pincode;
        $params['business_type'] = $request->business_type;
        $params['business_operation'] = $request->business_operation;
        $params['spoc'] = $request->spoc;
        $Org = $this->OrganisationMaster_model->SaveOrg($params);
        
        if(Auth::user()->role == "admin"){
            return redirect()->route('org.index');
        }else{
            $Bio = $this->UserMaster_model->getById(Auth::user()->user_master_id);
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
