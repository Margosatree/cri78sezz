<?php

namespace App\Http\Controllers;
use App\User_Cricket_Profile;
use App\User_Master;
use Illuminate\Http\Request;
use Auth;
use Image;
use Storage;
use Session;
class UserCricketProfileController extends Controller
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
//        dd($request->all());
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
        
        $User_Cri_Profile = new User_Cricket_Profile;
        $User_Cri_Profile->user_master_id = Auth::user()->user_master_id;
        $User_Cri_Profile->your_role = request('your_role');
        $User_Cri_Profile->batsman_style = request('batsman_style');
        $User_Cri_Profile->batsman_order = request('batsman_order');
        $User_Cri_Profile->bowler_style = request('bowler_style');
        $User_Cri_Profile->player_type = request('player_type');
        $User_Cri_Profile->description = request('description');
        
        if($request->hasFile('image')){
            $image = $request->file('image');
//            $data = $request->file('imagedata');
            $data = $_POST['imagedata'];
            
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $filename = time().base64_encode($User_Cri_Profile->id).'.'.$image->getClientOriginalExtension();
            $data = base64_decode($data);
//            $imageName = time().'.png';
            file_put_contents(public_path('images/'. $filename), $data);
            
            $User_Cri_Profile->display_img = $filename;
            $request->session()->put('user_img', $User_Cri_Profile->display_img);
//            DD('Add Image');
        }
//        if($request->hasFile('image')){
//            
//            $image = $request->file('image');
//            
//            $filename = time().base64_encode($User_Cri_Profile->id).'.'.$image->getClientOriginalExtension(); 
//            //use encode('png')  instead of getClientOriginalExtension()
//            $location = public_path('images/'. $filename);
//            //you also store in storage_path('app/image/') or assert();
//            Image::make($image)->save($location);
//            $User_Cri_Profile->display_img = $filename;
//            $request->session()->put('user_img', $User_Cri_Profile->display_img);
//        }
        $User_Cri_Profile->save();
        
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
        $User_Exists = User_Cricket_Profile::selectRaw('count(id) as count')->where('user_master_id',Auth::user()->user_master_id)->get()->first();
//        dd($User_Exists->count);
        if($User_Exists->count){
            $Bio = User_Master::find(Auth::user()->user_master_id);
            $Cri_Profile = User_Cricket_Profile::select('*')->where('user_master_id',Auth::user()->user_master_id)->get()->first();
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
        
        $Cri_Profile = User_Cricket_Profile::find($id);
        $Cri_Profile->your_role = request('your_role');
        $Cri_Profile->batsman_style = request('batsman_style');
        $Cri_Profile->batsman_order = request('batsman_order');
        $Cri_Profile->bowler_style = request('bowler_style');
        $Cri_Profile->player_type = request('player_type');
        $Cri_Profile->description = request('description');
        
        if($request->hasFile('image')){
            $image = $request->file('image');
//            $data = $request->file('imagedata');
            $data = $_POST['imagedata'];
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $filename = time().base64_encode($Cri_Profile->id).'.'.$image->getClientOriginalExtension();
            $data = base64_decode($data);
//            $imageName = time().'.png';
            file_put_contents(public_path('images/'. $filename), $data);
            
            $Cri_Profile->display_img = $filename;
            $request->session()->put('user_img', $Cri_Profile->display_img);
        }
//        if($request->hasFile('image')){
//            $image = $request->file('image');
//            $filename = time().base64_encode($User_Cri_Profile->id).'.'.$image->getClientOriginalExtension(); 
//            //use encode('png')  instead of getClientOriginalExtension()
//            $location = public_path('images/'. $filename);
//            //you also store in storage_path('app/image/') or assert();
//            Image::make($image)->resize(128,128)->save($location);
//            $olderFileName = $Cri_Profile->display_img;
//
//            //update in database
//            $Cri_Profile->display_img = $filename;
//            //delete old image
//            Storage::delete($olderFileName);
//            $request->session()->put('user_img', $Cri_Profile->display_img);
//        }
        
        $Cri_Profile->save();
        
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
