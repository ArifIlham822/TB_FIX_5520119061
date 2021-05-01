<?php

namespace App\Http\Controllers;
use Illuminate\support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        return view('home', compact('user'));
    }

    public function users()
    {
        $user =Auth::user();
        $users =user::all();
        return view('users', compact('user', 'users'));
    }

    public function submit_user(Request $request)
    {
        $users = new User();
        $users->name = $request->get('name');
        $users->username = $request->get('username');
        $users->email = $request->get('email');
        $users->password = bcrypt($request->get('password'));
        $users->photo = $request->get('photo');
        $users->roles_id = 2;
        
        if($request->hasFile('photo')){
            $extension = $request->file('photo')->extension();
            $filename = 'photo_user' . time() . '.' . $extension;

            $request->file('photo')->storeAs(
                'public/photo_user', $filename
            );

            $users->photo = $filename;
        }
        $users->save();

        $notification = array(
            'message' => 'Data berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.users')->with($notification);
    }


    // ajax prosess
    public function getDataUser($id)
    {
        $users = User::find($id);

        return response()->json($users);
    }

    public function update_user(Request $request)
    {
        $users = User::find($request->get('id'));
        $users->name = $request->get('name');
        $users->username =$request->get('username');
        $users->email=$request->get('email');
        $users->password=bcrypt($request->get('password'));
        $users->photo=$request->get('photo');
        
      
        if($request->hasFile('photo')){
            $extension = $request->file('photo')->extension();
            $filename = 'photo_user'.time().'.'. $extension;

            $request->file('photo')->storeAs(
                'public/photo_user', $filename
            );
            Storage::delete('public/photo_user/'.$request->get('old_user'));
            $users->photo = $filename;
        }

        $users->save();

        $notification = array(
            'message' => 'Data berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.users')->with($notification);
    }

    public function delete_user(Request $req)
    {
        $users = User::find($req->get('id'));

        Storage::delete('public/photo_user/'.$req->get('old_photo'));

        $users->delete();

        $notification = array(
            'message' => 'Data Produk berhasil dihapus',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.users')->with($notification);
    }

}
