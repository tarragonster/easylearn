<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = '/';


    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function login(Request $request)
    {

        $this->validate($request,[
           'email' => 'required|string|email',
           'password' => 'required|alphaNum|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        $preURL = $request->input('preURL');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended($preURL);
        }else{
            return redirect()->back()->with('error','Wrong Login Details');
        }

    }

    public function __construct()
    {
        $this->middleware('guest',['except'=>['logout','userLogout','userAccount','updateAccount','login']]);

    }

    public function userLogout(){

        Auth::guard('web')->logout();

        return redirect('/');
    }

    public function userAccount(){

        $defs=['','','','',''];
        $display='';
        $spelling='';
        $type='';
        $example=['','','','',''];
        $selectOption='E';
        $q ='';
        $n = 0;


        return view('auth.account')->with('defs', $defs)->with('display',$display)
            ->with('spelling',$spelling)->with('type',$type)->with('example',$example)
            ->with('selectOption',$selectOption)->with('q',$q)->with('n',$n);

    }

    public function updateAccount(Request $request){

        $id = $request->input('id');
        $oldFile = DB::table('users')->where('id',$id)->value('user_image');

        $this->validate($request,[
            'email' => 'required|string|email|max:255|unique:users',
            'update_image' => 'image|nullable|max:1999'
        ]);

        //Handle file upload
        if($request->hasFile('update_image')){
            //Get filename with extension
            $fileNameWithExt = $request->file('update_image')->getClientOriginalName();
            //Get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('update_image')->guessClientExtension();
            //Upload image
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $nameToDisplay = '/storage/update_images/'.$fileNameToStore;
            //Upload images
            $path = $request->file('update_image')->storeAs('public/update_images/',$fileNameToStore);

        }elseif($request->input('URLinputBox') !== null){
            $nameToDisplay = $request->input('URLinputBox');
        }else{
            $nameToDisplay = $oldFile;
        }

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->user_image = $nameToDisplay;

        $user->save();

        return redirect('/user/account');
    }
}
