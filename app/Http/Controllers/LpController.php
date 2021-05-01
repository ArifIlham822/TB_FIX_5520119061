<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Categorie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;

class LpController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $user = Auth::user();
        $product =  DB::table('products')
        ->join('brands', 'brands.id', '=', 'products.brands_id')
        ->join('categories', 'categories.id', '=', 'products.categories_id')
        ->select(
            'products.name', 
            'products.qty', 
            'brands.name AS bname',
            'categories.name AS cname',
            'products.photo',
            'products.created_at',
            'products.updated_at')
            ->whereRaw('DATE(products.created_at) = DATE(NOW())')
        ->get();

        return view("lp", ['products' => $product]);
    }

    public function submit_product(Request $req){
        $product = new Product;

        $product->name = $req->get('name');
        $product->qty = $req->get('qty');
        $product->brands_id = $req->get('brands_id');
        $product->categories_id = $req->get('categories_id');
        $product->photo = $req->get('photo');
        $product->created_at = $req ->get('created_at');
        $product->updated_at = $req ->get('updated_at');

        if($req->hasFile('photo')){
            $extension = $req->file('photo')->extension();
            $filename = 'photo_product' . time() . '.' . $extension;

            $req->file('photo')->storeAs(
                'public/photo_product', $filename
            );

            $product->photo = $filename;
        }

        $product->save();

        $notification = array(
            'message' => 'Data Produk berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.lp')->with($notification);
    }

    // ajax prosess
    public function getDataProduct($id)
    {
        $product = Product::find($id);

        return response()->json($product);
    }

    // update Product
    public function update_product(Request $req)
    {
        $product = Product::find($req->get('id'));

        $product->name = $req->get('name');
        $product->qty = $req->get('qty');
        $product->brands_id = $req->get('brands_id');
        $product->categories_id = $req->get('categories_id');
        $product->created_at = $req ->get('created_at');
        $product->updated_at = $req ->get('updated_at');

        if($req->hasFile('photo')){
            $extension = $req->file('photo')->extension();
            $filename = 'photo_product'.time().'.'. $extension;

            $req->file('photo')->storeAs(
                'public/photo_product', $filename
            );
            Storage::delete('public/photo_product/'.$req->get('old_product'));
            $product->photo = $filename;
        }

        $product->save();

        $notification = array(
            'message' => 'Data Produk berhasil diubah',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.lp')->with($notification);
    }

    public function delete_product(Request $req)
    {
        $product = Product::find($req->get('id'));

        Storage::delete('public/photo_product/'.$req->get('old_photo'));

        $product->delete();

        $notification = array(
            'message' => 'Data Produk berhasil dihapus',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.lp')->with($notification);
    }

    public function print_Lp()
    {
        $product = Product::all();

        $pdf = PDF::loadview('print_Lp', ['product' => $product]);
        
        return $pdf->download('data_product.pdf');
    }
    
}