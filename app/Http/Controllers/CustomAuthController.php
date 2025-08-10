<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Loginhistory;
use App\Models\User;
use App\Models\UserVerify;
use App\Notifications\NotifyAdmin;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Session;
use Str;

class CustomAuthController extends Controller
{

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {

        return view('auth.login');
    }

    public function customHome()
    {

        // dd("kkk");
        return view('home');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.register');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function customLogin(Request $request)
    {

        if ($request->isMethod('post')) {
            $remember_me = $request->has('remember') ? true : false; // get remember value
            $credentials = $request->only('email', 'password');
            $users       = DB::table('users')
                ->select('*')
                ->where([
                    ['email', '=', $request->input('email')]
                ])
                ->first();
                // ->get();
                $request->validate([
                    'email'    => 'required|string',
                    'password' => 'required|string',
                ]);
                // ================= Start remember
                if ($request->remember === null) {
                    setcookie('login_email', $request->email, 100);
                    setcookie('login_pass', $request->password, 100);
                } else {
                    setcookie('login_email', $request->email, time() + 60 * 60 * 24 * 120);
                    setcookie('login_pass', $request->password, time() + 60 * 60 * 24 * 120);
                }
        //                     $user = User::where('email', $request->email)->first();
        //                     $access_token = $user->createToken($request->email)->accessToken;
        //                     $result = User::where('email', $request->email)->update(['access_token' => $access_token]);

        //  dd($result);
                //  End remember
                if ($users->status == 'active') {
                        if (Auth::attempt($credentials, $remember_me)) {
                            $user = User::where('email', $request->email)->first();
                            $access_token = $user->createToken($request->email)->accessToken;
                            User::where('email', $request->email)->update(['access_token' => $access_token]);
                            Session::put('user_session', $request->email);
                            Session::put('pass_session', $request->password);
                            return redirect()->intended(route('home'))
                                ->withSuccess('Signed in');
                        } else {
                            return redirect("login")->with('error', 'Oppes! You have entered invalid credentials');
                        }
                } else {
                    return redirect("login")->with('error', 'Your account is suspended, or account inactive, please contact Admin.');
                }

                // End if  status


            return redirect("login")->with('error', 'Oppes! You have entered invalid credentials');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function customRegistration(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data       = $request->all();
        $createUser = $this->create($data);
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');

    }



    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if (Auth::check()) {
            return view('home');
        }
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
        $token = Str::random(64);

        return User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role'   => 'user',
            'status' => 'active',
            'access_token' => $token,
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('home');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

}
