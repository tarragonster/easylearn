<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $request = request();

        $this->validate($request,[
            'update_image' => 'image|nullable|max:1999',
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
            $nameToDisplay ='/storage/update_images/default_user.jpg';
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_image' => $nameToDisplay,
        ]);
    }
}
