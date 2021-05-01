<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\support\Facades\Storage;
use App\Models\brand;


class BrandController extends Controller
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
    

    

    public function brands()
    {
        $user =Auth::user();
        $brands =brand::all();
        return view('brands', compact('user', 'brands'));
    }

    public function submit_brand(Request $request)
    {
        $brand = new Brand();
        $brand->name = $request->get('name');
        $brand->description = $request->get('description');

        $brand->save();

        $notification = array(
            'message' => 'Data berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.brands')->with($notification);
    }

    // ajax prosess
    public function getdatabrand($id)
    {
        $brand = Brand::find($id);

        return response()->json($brand);
    }

    // update brand
    public function update_brand(Request $req)
    {
        $brands = Brand::find($req->get('id'));
        $brands->name=$req->get('name');
        $brands->description =$req->get('description');
        $brands->save();
        $notification = array(
            'message' => 'Data Merek berhasil diubah',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.brands')->with($notification);
    }
    
     


    public function delete_brand(Request $req)
    {
        $brand = brand::find($req->id);
        $brand->delete();
     
        $notification = array(
            'message' => 'Data berhasil dihapus',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.brands')->with($notification);

    }
}
