<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use DateTime;
use Session;
use Hash;

class CustomeController extends Controller
{
    //load login screen
    public function index()
    {
        if(Auth::check()){
            return redirect("dashboard");
        }
        return view('login');
    }

    //check login credentials
    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            //logs insert for user
            \LogActivity::addToLog('User Login.');
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }
        return redirect("login")->withSuccess('Login details are not valid');
    }

    // Load Registration Page
    public function registration()
    {
        return view('registration');
    }

    // create users 
    public function customRegistration(Request $request)
    {
        $mindate = date('Y-m-d',strtotime('-18 year'));
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'date_of_birth' => 'required|date|before:'.$mindate,
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'date_of_birth' => date('Y-m-d',strtotime($data['date_of_birth'])),
            'password' => Hash::make($data['password'])
          ]);
         
        return redirect("login");
    }

    //load dashboard
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    //log out
    public function signOut()
    {
        \LogActivity::addToLog('User Log Out.');
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

    //load user profile
    public function profile()
    {
        $user = Auth::user();
        return view('profile',['user' => $user]);
    }

    //update user profile
    public function customupdate(Request $request,$id)
    {
        $mindate = date('Y-m-d',strtotime('-18 year'));
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'. $id,
            'date_of_birth' => 'required|date|before:'.$mindate
        ]);

        $data = $request->all();

        $user = User::find($id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->date_of_birth = $data['date_of_birth'];
        $user->save();

        \LogActivity::addToLog('User Update Profile.');
        return redirect("dashboard")->withSuccess('Profile Updated.');
    }

    //load change password
    public function password()
    {
        $user = Auth::user();
        return view('changepassword',['user' => $user]);
    }

    //update password
    public function passwordupdate(Request $request,$id)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            // Current password and new password same
            return redirect()->back()->with("error","New Password cannot be same as your current password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|min:6',
            'new-password-confirm' => 'same:new-password',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->get('new-password'));
        $user->save();

        \LogActivity::addToLog('User Change Password.');
        return redirect("dashboard")->withSuccess("Password successfully changed!");
    }

    //load user logs
    public function viewlogs()
    {
        //using helper methods fetch logs data
        $logs = \LogActivity::logActivityLists();
        return view('viewlogs',compact('logs'));
    }
}
