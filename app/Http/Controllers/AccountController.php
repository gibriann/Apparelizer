<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;
use App\Models\StatusUser;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class AccountController extends Controller
{
    public function adminAccount() 
    {
        return view('pages.admin-new.dashboard-account');
    }

    public function adminList()
    {
        $admins = User::where('role_id', 1)->get();
        return view('pages.admin-new.dashboard-admins', compact('admins'));
    }

    public function customerList()
    {
        $customers = User::where('role_id', 3)->get();
        return view('pages.admin-new.dashboard-customers', compact('customers'));
    }

    public function adminCreate()
    {
        return view('pages.admin-new.dashboard-admins-add');
    }

    public function adminStore(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email',
        ];
        
        $customMessage = [
            'required' => 'Silahkan masukan :attribute',
            'unique' => ':attribute telah digunakan'
        ];
        
        $attributeName = [
            'name' => 'Nama',
            'email' => 'Email',
        ];

        $this->validate($request, $rules, $customMessage, $attributeName);

        User::create([
            'name' => $request->name,
            'role_id' => 1,
            'user_status_id' => 1,
            'email' => $request->email,
            'password' => Hash::make(123456),
        ]);

        Alert::success('Berhasil','Admin berhasil ditambahkan');
        return redirect(route('dashboard-admins'));
    }

    public function adminUpdate(Request $request, $id)
    {
        $user = User::find($id);
        $rules = [
            'name' => 'required|max:255',
            'email' => "required|unique:users,email,$user->id",
        ];
        
        $customMessage = [
            'required' => 'Silahkan masukan :attribute',
            'unique' => ':attribute telah digunakan'
        ];
        
        $attributeName = [
            'name' => 'Nama',
            'email' => 'Email',
        ];

        $this->validate($request, $rules, $customMessage, $attributeName);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        Alert::success('Berhasil','Admin berhasil diubah');
        return redirect(route('dashboard-admins'));
    }

    public function updateStatusUser($id)
    {
        $user = User::find($id);
        if ($user->user_status_id == 1) {
            $user->update([
                'user_status_id' => 2,
            ]);
            Alert::success('Berhasil','Admin dinon-aktifkan');
        }elseif ($user->user_status_id == 2) {
            $user->update([
                'user_status_id' => 1,
            ]);
            Alert::success('Berhasil','Admin diaktifkan');
        }
        if ($user->role_id == 1) {
            return redirect(route('dashboard-admins'));
        } else {
            return redirect(route('dashboard-customers'));
        }
        
    }

    /**
     * Store an uploaded avatar (public/avatars/xxx.ext) and return its path.
     * Returns null when no file was uploaded.
     */
    protected function storeAvatar(Request $request, User $user): ?string
    {
        if (!$request->hasFile('avatar')) {
            return null;
        }

			$folder = 'avatars';
			$file = $request->file('avatar');
			$extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
			$imageName = Str::random(30) . '.' . $extension;

			// Remove previous uploaded avatar so files don't pile up.
			if ($user->hasCustomAvatar()) {
				$oldRelative = str_replace('public/', '', $user->avatar);
				if (Storage::disk('public')->exists($oldRelative)) {
					Storage::disk('public')->delete($oldRelative);
				}
			}

			if (!Storage::disk('public')->exists($folder)) {
				Storage::disk('public')->makeDirectory($folder);
			}

			$manager = new ImageManager(new Driver());
			$image = $manager->read($file->getRealPath());

			// The picker already crops to a square, but a square image is
			// enforced here too so a direct upload can never come out oval.
			// cover() centre-crops the shortest side.
			$image->cover(width: 512, height: 512);

			$image->save(Storage::disk('public')->path($folder . '/' . $imageName));

			return 'public/' . $folder . '/' . $imageName;
		}

    public function account() 
    {
        $addresses = Address::where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->orderByDesc('created_at')
            ->get();

        return view('pages.account', compact('addresses'));
    }

    protected function update(Request $request)
    {
        $user= User::where('id', Auth::user()->id)->first();
        $userId= $user->id;


        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 ){
            $rules = [
                'name' => 'required|max:255',
                'email' => "required|max:255|unique:users,email,$userId",
                'avatar' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
            ];
        }elseif (Auth::user()->role_id == 3) {
            $rules = [
                'name' => 'required|max:255',
                'email' => "required|max:255|unique:users,email,$userId",
                'avatar' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
            ];
        }
        
        $customMessage = [
            'required' => 'Silahkan Masukan :attribute',
            'unique' => ':attribute Telah Digunakan',
            'min' => ':attribute minimal :min',
            'max' => ':attribute maksimal :max',
            'mimes' => 'Format :attribute harus png, jpg, jpeg, atau webp',
        ];
        
        $attributeName = [
            'name' => 'Nama',
            'email' => 'Email',
            'avatar' => 'Foto Profil',
        ];

        $this->validate($request, $rules, $customMessage, $attributeName);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $this->storeAvatar($request, $user) ?? $user->avatar,
        ]);

        Alert::success('Berhasil','Data akun telah diperbaharui');
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
            return redirect(route('dashboard-account'));
        }elseif (Auth::user()->role_id == 3) {
            return redirect(route('account'));
        }
    }

    /**
     * Validate a saved address payload (shared by store/update).
     */
    protected function validateAddress(Request $request): array
    {
        return $request->validate([
            'label' => 'required|max:255',
            'recipient_name' => 'required|max:255',
            'phone_number' => 'required|min:10|max:15',
            'address' => 'required|max:1000',
            'rajaongkir_destination_id' => 'required|integer|min:1',
            'province' => 'nullable|max:255',
            'city' => 'nullable|max:255',
            'district' => 'nullable|max:255',
            'subdistrict' => 'nullable|max:255',
            'postal_code' => 'nullable|max:10',
        ], [
            'required' => 'Silahkan masukan :attribute',
            'min' => ':attribute minimal :min karakter',
            'max' => ':attribute maksimal :max karakter',
            'integer' => ':attribute tidak valid',
        ], [
            'label' => 'Label alamat',
            'recipient_name' => 'Nama penerima',
            'phone_number' => 'Nomor telepon',
            'address' => 'Alamat lengkap',
            'rajaongkir_destination_id' => 'Kota/Kecamatan tujuan',
            'postal_code' => 'Kode POS',
        ]);
    }

    protected function ownedAddress(int $id): Address
    {
        return Address::where('user_id', Auth::id())->findOrFail($id);
    }

    public function addressStore(Request $request)
    {
        $data = $this->validateAddress($request);
        $isFirst = !Address::where('user_id', Auth::id())->exists();

        $address = Address::create($data + [
            'user_id' => Auth::id(),
            'is_default' => $isFirst,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Alamat berhasil ditambahkan',
                'address' => $address,
                'html' => $this->addressCardHtml($request, $address),
            ], 201);
        }

        Alert::success('Berhasil', 'Alamat berhasil ditambahkan');
        return redirect()->back();
    }

    public function addressUpdate(Request $request, int $id)
    {
        $address = $this->ownedAddress($id);
        $address->update($this->validateAddress($request));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Alamat berhasil diperbaharui',
                'address' => $address,
                'html' => $this->addressCardHtml($request, $address),
            ]);
        }

        Alert::success('Berhasil', 'Alamat berhasil diperbaharui');
        return redirect()->back();
    }

    protected function addressCardHtml(Request $request, Address $address): string
    {
        $selectable = $request->input('context') === 'shipping';

        return view('pages.partials.address-card-account', compact('address', 'selectable'))->render();
    }

    public function addressDestroy(int $id)
    {
        $address = $this->ownedAddress($id);

        if (Address::where('user_id', Auth::id())->count() <= 1) {
            Alert::error('Gagal', 'Minimal satu alamat harus tersimpan');
            return redirect()->back();
        }

        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            Address::where('user_id', Auth::id())
                ->orderByDesc('created_at')
                ->first()
                ?->update(['is_default' => true]);
        }

        Alert::success('Berhasil', 'Alamat berhasil dihapus');
        return redirect()->back();
    }

    public function addressSetDefault(int $id)
    {
        $address = $this->ownedAddress($id);

        Address::where('user_id', Auth::id())->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        Alert::success('Berhasil', 'Alamat utama berhasil diubah');
        return redirect()->back();
    }
}
