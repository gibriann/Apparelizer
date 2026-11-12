<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


class DashboardProductController extends Controller
{
    private function imageManager(): ImageManager
    {
        return new ImageManager(new Driver());
    }

    private function deleteOldImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        // Uploaded via admin: "public/foto_produk/xxx.png"
        $relative = str_replace('public/', '', $path);
        if (Storage::disk('public')->exists($relative)) {
            Storage::disk('public')->delete($relative);
            return;
        }

        // Legacy / seeder path in public/
        $legacy = public_path($path);
        if (is_file($legacy)) {
            @unlink($legacy);
        }
    }

    public function index()
    {
        $products = Product::paginate(8);
        return view('pages.admin-new.dashboard-products', compact('products'));
    }

    public function details($id)
    {
        $product = Product::find($id);
        return view('pages.admin-new.dashboard-products-detail', compact('product'));
    }

    public function add()
    {
        return view('pages.admin-new.dashboard-products-add');
        
    }

    public function store(Request $request) {
        // return $request;
        $rules = [
            'product_name' => 'required|max:255',
            'product_image' => 'required|mimes:png,jpg,jpeg,webp',
            'product_price' => 'required|max:255',
            'product_weight' => 'required',
            'product_description' => 'required'
        ];

        $customMessage = [
            'required' => 'Silahkan masukan :attribute',
            'mimes' => 'Format file harus png, jpg, jpeg, atau webp'
        ];
        
        $attributeName = [
            'product_name' => 'nama produk',
            'product_image' => 'gambar produk',
            'product_price' => 'harga',
            'product_weight' => 'berat',
            'product_description' => 'deskripsi',
        ];

        $this->validate($request, $rules, $customMessage, $attributeName);

        $uploadFolder = 'foto_produk';
        $imageFile = $request->file('product_image');
        $ogImage = $imageFile->getClientOriginalName();
        $imageExtension = pathinfo($ogImage, PATHINFO_EXTENSION);
        $imageName = Str::random(30);
        $image_path = 'public/' . $uploadFolder . '/' . $imageName . '.' . $imageExtension;

        if (!Storage::disk('public')->exists($uploadFolder)) {
            Storage::disk('public')->makeDirectory($uploadFolder);
        }

        $targetPath = Storage::disk('public')->path($uploadFolder . '/' . $imageName . '.' . $imageExtension);
        $this->imageManager()
            ->read($imageFile->getRealPath())
            ->scaleDown(width: 1280)
            ->save($targetPath);

        $slug = Str::of($request->product_name)->slug('-');

        Product::create([
            'product_name' => $request->product_name,
            'product_image' => $image_path,
            'product_price' => $request->product_price,
            'product_weight' => $request->product_weight,
            'product_description' => $request->product_description,
            'slug' => $slug,
        ]);

        Alert::success('Berhasil');
        return redirect(route('dashboard-products'));
    }

    public function update(Request $request, $id) {
        $product = Product::find($id);

        $rules = [
            'product_name' => 'required|max:255',
            'product_price' => 'required|max:255',
            'product_weight' => 'required',
            'product_description' => 'required'
        ];

        
        $customMessage = [
            'required' => 'Silahkan masukan :attribute',
        ];
        
        $attributeName = [
            'product_name' => 'nama produk',
            'product_price' => 'harga',
            'product_weight' => 'berat',
            'product_description' => 'deskripsi',
        ];

        $this->validate($request, $rules, $customMessage, $attributeName);

        $slug = Str::of($request->product_name)->slug('-');

        $product->update([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_weight' => $request->product_weight,
            'product_description' => $request->product_description,
            'slug' => $slug,
        ]);

        if ($request->hasFile('product_image')) {
            $rules = [
                'product_image' => 'required|mimes:png,jpg,jpeg,webp',
            ];

            $customMessage = [
                'required' => 'Silahkan masukan :attribute',
                'mimes' => 'Format file harus png, jpg, jpeg, atau webp',
            ];

            $attributeName = [
                'product_image' => 'gambar produk',
            ];

            $this->validate($request, $rules, $customMessage, $attributeName);

            $this->deleteOldImage($product->product_image);

            $uploadFolder = 'foto_produk';
            $imageFile = $request->file('product_image');
            $ogImage = $imageFile->getClientOriginalName();
            $imageExtension = pathinfo($ogImage, PATHINFO_EXTENSION);
            $imageName = Str::random(30);
            $image_path = 'public/' . $uploadFolder . '/' . $imageName . '.' . $imageExtension;

            if (!Storage::disk('public')->exists($uploadFolder)) {
                Storage::disk('public')->makeDirectory($uploadFolder);
            }

            $targetPath = Storage::disk('public')->path($uploadFolder . '/' . $imageName . '.' . $imageExtension);
            $this->imageManager()
                ->read($imageFile->getRealPath())
                ->scaleDown(width: 1280)
                ->save($targetPath);

            $product->update([
                'product_image' => $image_path,
            ]);
        }

        Alert::success('Berhasil memperbarui produk');
        return redirect(route('dashboard-products'));
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if ($product) {
            $this->deleteOldImage($product->product_image);
            $product->delete();
            Alert::success('Success!', 'Produk telah berhasil dihapus');
        } else {
            Alert::toast('Produk tidak ditemukan', 'error');
        }
        return redirect(route('dashboard-products'));
    }
}
