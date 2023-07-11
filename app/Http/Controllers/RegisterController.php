<?php

namespace App\Http\Controllers;
use Auth;
use Session;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Crypt;
class RegisterController extends Controller
{
    public function index()
    {
        return view('register.register');
    }
    /**
     * User registration
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        $this->validate($request,[
            'first_name'=> 'required|string|min:3',
            'last_name'=> 'required|string|min:3',
            'user_mob'=> 'required|numeric|digits:10',
            'user_password'=> [
                    'required',
                    'string',
                    'min:5',             // must be at least 5 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    //'regex:/[@$!%*#?&]/', // must contain a special character
                ],
            'email'=> 'required|unique:users|email',
            'terms'=> 'required',
            'user_cpass'=>'required|same:user_password',
        ],
        [
            'user_password.regex' => 'Passwprd must be 5 in lenth with mix of small capital  & number eg Rajdeep123',
        ]);
        $user = User::create([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'mobile'=> $request->user_mob,
            'email'=> $request->email,
            'password'=> Hash::make($request->user_password),
            'created_at'=> Carbon::now(),
        ]);
        $enc_email =  Crypt::encryptString($request->email);
        $to_email = [$request->email];
        $to_name = $request->first_name.' '.$request->last_name;
        $from_name = 'Rajdeep Jomanic';
        $data =['name'=> $to_name,'email'=> $enc_email];
        try {
            Mail::send('emails.verify_email', $data, function ($sendmessage) use ($to_name, $to_email, $from_name) {
              $sendmessage->to($to_email, $to_name)
                ->subject("Verify Email");
            });
           
        } catch (\Exception $e) {
          if ($e) {
            return redirect('/')->with('error',"User Created Successfully, Mail Not Sent");
          }
          }
        return redirect('/')->with('success',"User Created Successfully, Mail Send For verification");
    }
    /**
     * login user  function
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $this->validate($request,[
            'email'=> 'required|email',
            'password'=>'required',
        ]);
        $user_data = User::where('email',$request->email)->first();
        if(!empty($user_data))
        {
            if(!is_null($user_data->email_verified_at) && !empty($user_data->email_verified_at) && ($user_data->email_status == '1'))
            {
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
                {
                    return redirect('home');
                }
                return redirect('/')->with('error',"Pls Enter Valid Password"); 
            }
            return redirect('/')->with('error',"Your mail Verification is Pending, Pls Check Your Register email"); 
        }
        return redirect('/')->with('error',"User Not Exits");
    }
    /**
     * redirect to home if user is logged in
     *
     * @return void
     */
    public function home()
    {
        $data['users'] = Auth::user();
        return view('register.register',$data);
    }
    /**
     * loding loggedin user profile page
     *
     * @param [type] $id
     * @return void
     */
    public function profile($id)
    {
        if(Auth::user()->id == $id)
        {
            $data['users'] = User::find($id);
            return view('users.profile',$data);
        }
        return redirect('/home');
    }
    /**
     * logout function
     *
     * @return void
     */
    public function logout()
    {
        Auth::logout();
        return view('register.register');
    }
    /**
     * update profile function
     *
     * @param Request $request
     * @return void
     */
    public function update_profile(Request $request)
    {
        $valid = 'nullable';
        if(!empty($request->password))
        {
            $valid = [
                'required',
                'string',
                'min:5',             // must be at least 5 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                //'regex:/[@$!%*#?&]/', // must contain a special character
            ];
        }
        
        $this->validate($request,[
            'id'=> 'required',
            'first_name'=> 'required|string|min:3',
            'last_name'=> 'required|string|min:3',
            'mobile'=> 'required|numeric|digits:10',
            'password' => $valid,
        ],
        [
            'password.regex' => 'Passwprd must be 5 in lenth with mix of small capital  & number example Rajdeep123',
        ]);
        $data = [
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'mobile'=> $request->mobile,
            'updated_at'=> Carbon::now(),
        ];
        if(!empty($request->password))
        {
            $data['password'] = Hash::make($request->password);
        }
        $is_update = User::where('id',$request->id)->update($data);
        if($is_update)
        {
            return redirect()->back()->with('success',"profile updated");
        }
        return redirect()->back()->with('error',"profile not updated");
    }
    /**
     * email verify function after register
     *
     * @param [type] $email
     * @return void
     */
    public function mail_verify($email)
    {
        try {
            $decrypted_email = Crypt::decryptString($email);
            if($decrypted_email)
            {
                $data=[
                    'email_status'=> 1,
                    'email_verified_at'=>Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ];
                $is_upadte = User::where('email',$decrypted_email)->update($data);
                if($is_upadte)
                {
                    return redirect('/')->with('success',"email verified successfully, Now login Pls");
                }
            } 
        } catch (\Exception $e) {
          if ($e) {
            return redirect('/')->with('error',"email not verified");
          }
        }
    }
}
