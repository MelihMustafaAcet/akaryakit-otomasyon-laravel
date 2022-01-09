<?php

namespace App\Http\Controllers;

use App\Models\Prices;
use App\Models\Process;
use App\Models\Sales;
use App\Models\Settings;
use App\Models\Tanks;
use App\Models\User;
use Carbon\Carbon;
use Hamcrest\Core\Set;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use PHPHtmlParser\Dom;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function getSomething(string $type = 'all')
    {
        if ($type == 'all') {
            $users = User::all()->toArray();
            $tanks = Tanks::all()->toArray();
            $sales = Sales::all()->toArray();
            $process = Process::all()->toArray();

            return array_merge($users, $tanks, $sales, $process);
        } elseif ($type == 'user') {

            return User::all();
        } elseif ($type == 'tanks') {

            return Tanks::all();
        } elseif ($type == 'sales') {

            return Sales::all();
        } elseif ($type == 'process') {

            return Process::all();
        } elseif ($type == 'istatistik') {
            $usercount = count(User::all()->toArray());
            $salescount = count(Sales::whereBetween('created_at',[Carbon::yesterday(),Carbon::now()])->get()->toArray());

            $ciro = Sales::whereBetween('created_at',[Carbon::yesterday(),Carbon::now()])->get()->toArray();
            $ciroTotal = 0;
            foreach ($ciro as $item) {
                $ciroTotal += $item['total_price'];
            }

            $collection = [
                'usercount' => $usercount,
                'salescount' => $salescount,
                'ciro' => $ciroTotal
            ];

            return $collection;
        }
    }

    public function getPrice()
    {
        $dom = new Dom;

        $dom->loadFromUrl('https://www.tppd.com.tr/tr/akaryakit-fiyatlari');

        $benzinTemp = $dom->find('td', 1);
        $benzin = str_replace(' ', '', $benzinTemp->text);

        $motorinTemp = $dom->find('td', 4);
        $motorin = str_replace(' ', '', $motorinTemp->text);

        $motorin2Temp = $dom->find('td', 3);
        $motorin2 = str_replace(' ', '', $motorin2Temp->text);

        $lpgTemp = $dom->find('td', 8);
        $lpg = str_replace(' ', '', $lpgTemp->text);

        if (Settings::find(1)->isPriceOnline) {
            $collection = [
                'benzin' => str_replace(',', '.', $benzin),
                'motorin' => str_replace(',', '.', $motorin),
                'motorin2' => str_replace(',', '.', $motorin2),
                'lpg' => str_replace(',', '.', $lpg)
            ];
        } else {
            $collection = [
                'benzin' => Prices::find(2)->price,
                'motorin' => Prices::find(1)->price,
                'motorin2' => Prices::find(4)->price,
                'lpg' => Prices::find(3)->price
            ];
        }

        return $collection;
    }

    public function login()
    {

        return view('login');
    }

    public function logout()
    {
        Auth::logout();
        Alert::alert('Başarılı', 'Çıkış yaptınız...', 'success');

        return redirect()->intended(route('login'));
    }

    public function loginAttempt(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            Alert::alert('Başarılı', 'Giriş yaptınız...', 'success');

            if (Auth::user()->permission_level == 'admin') {

                return redirect()->intended(route('admin.dashboard'));
            } else {

                return redirect()->intended(route('user.dashboard'));
            }
        } else {
            Alert::alert('Hata', 'Bilgileriniz hatalı...', 'error');

            return redirect()->route('login');
        }
    }

    public function index()
    {
        $capasity = $this->getSomething('tanks');
        $istatistik = $this->getSomething('istatistik');
        return view('admin.dashboard')->with('capasity', $capasity)->with('istatistik', $istatistik);
    }

    public function tankDetail()
    {
        $tanks = $this->getSomething('tanks');

        return view('admin.tanks')->with('tanks', $tanks);
    }

    public function tankFilling($id)
    {
        $tank = Tanks::where('id', $id)->first();

        return view('admin.tankfilling')->with('tank', $tank);
    }

    public function tankUnload($id)
    {
        $tank = Tanks::where('id', $id)->first();

        return view('admin.tankunload')->with('tank', $tank);
    }

    public function tankFillingRequest(Request $request, $id)
    {
        $request->validate([
            'miktar' => 'required|gt:0'
        ]);
        $tank = Tanks::where('id', $id)->first();
        if ($request->miktar > ($tank->capasity - $tank->current_fullnes)) {
            Alert::alert('Hata', 'Dolum yapmak istediğiniz miktar, tankın kapasitesinden fazladır', 'error');

            return back();
        } else {
            $tankTemp = Tanks::find($id);
            $tankTemp->current_fullnes = $request->miktar + $tank->current_fullnes;

            if ($tankTemp->save()) {
                $processSaver = new Process();
                $processSaver->plate = 'Yönetici';
                $processSaver->user_id = 1;
                $processSaver->tank_id = $id;
                $processSaver->fuel_amount = $request->miktar;
                $processSaver->type = 'Dolum';
                $processSaver->save();

                Alert::alert('Başarılı', 'Dolum yapıldı', 'success');

                return back();
            }
            else{
                Alert::alert('Hata','Dolum yapılamadı','error');

                return back();
            }
        }

    }

    public function tankUnloadRequest(Request $request, $id)
    {
        $request->validate([
            'miktar' => 'required|gt:0'
        ]);
        $tank = Tanks::where('id', $id)->first();
        if ($request->miktar > $tank->current_fullnes) {
            Alert::alert('Hata', 'Boşaltım yapmak istediğiniz miktar, mevcut doluluktan fazladır.', 'error');

            return back();
        } else {
            $tankTemp = Tanks::find($id);
            $tankTemp->current_fullnes = $tank->current_fullnes - $request->miktar;

            if ($tankTemp->save()) {
                $processSaver = new Process();
                $processSaver->plate = 'Yönetici';
                $processSaver->user_id = Auth::user()->id;
                $processSaver->tank_id = $id;
                $processSaver->fuel_amount = $request->miktar;
                $processSaver->type = 'Boşaltım';
                $processSaver->save();

                Alert::alert('Başarılı', 'Boşaltım yapıldı', 'success');

                return back();
            }
            else{
                Alert::alert('Hata', 'Boşaltım yapılamadı', 'error');

                return back();
            }
        }

    }

    public function userManagement()
    {
        $users = $this->getSomething('user');

        return view('admin.usermanagement')->with('users', $users);
    }

    public function userRegisterRequest(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'permission_level' => 'required',
                'password' => 'required'
            ]
        );

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->permission_level = $request->permission_level;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            Alert::alert('Başarılı', 'Kullanıcıyı başarıyla eklediniz', 'success');

            return back();
        } else {
            Alert::alert('Hata', 'Bir hata oluştu, kullanıcı eklenemedi', 'error');

            return back();
        }

    }

    public function userDelete($id)
    {
        $user = User::find($id);
        if ($user->delete()) {
            Alert::alert('Başarılı', 'Kullanıcıyı başarıyla sildiniz', 'success');
        } else {
            Alert::alert('Hata', 'Bir hata oluştu, kullanıcı silinemedi', 'error');
        }
        return back();
    }

    public function userEdit($id)
    {
        $user = User::find($id);

        return view('admin.useredit')->with('user', $user);
    }

    public function userEditaction(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'permission_level' => 'required',

            ]
        );
        $user = User::find($id);
        if ($request->filled('password')) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->permission_level = $request->permission_level;
            $user->password = Hash::make($request->password);
        } else {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->permission_level = $request->permission_level;

        }

        if ($user->save()) {
            Alert::alert('Başarılı', 'Kullanıcıyı başarıyla güncellediniz', 'success');
        } else {
            Alert::alert('Hata', 'Bir hata oluştu, kullanıcı güncellenemedi', 'error');
        }
        return back();

    }

    public function settings()
    {
        $settings = Settings::find(1);
        $prices = $this->getPrice();

        return view('admin.settings')->with('settings', $settings)->with('prices', $prices);
    }

    public function settingsUpdate(Request $request)
    {
        $settings = Settings::find(1);
        $settings->isPriceOnline = $request->value;

        if ($settings->save()) {
            Alert::alert('Başarılı', 'Ayarlar güncellendi', 'success');
        } else {
            Alert::alert('Hata', 'Bir hata oluştu', 'error');
        }
        return back();
    }

    public function priceUpdate(Request $request)
    {

        $dizel = DB::table('prices')
            ->where('id', 1)
            ->update(
                [
                    'price' => $request->Dizel
                ]
            );

        $dizel2 = DB::table('prices')
            ->where('id', 4)
            ->update(
                [
                    'price' => $request->Dizel2
                ]
            );

        $benzin = DB::table('prices')
            ->where('id', 2)
            ->update(
                [
                    'price' => $request->Benzin
                ]
            );

        $LPG = DB::table('prices')
            ->where('id', 3)
            ->update(
                [
                    'price' => $request->LPG
                ]
            );

        if ($dizel && $dizel2 && $benzin && $LPG) {
            Alert::alert('Hata', 'Bir hata oluştu', 'error');

        } else {
            Alert::alert('Başarılı', 'Fiyatlar güncellendi', 'success');
        }
        return back();

    }

    public function reportView()
    {
        $process =
            DB::table('process')
                ->leftJoin('sales','sales.id','=','process.sale_id')
                ->join('users', 'users.id', '=', 'process.user_id')
                ->join('tanks', 'tanks.id', '=', 'process.tank_id')
                ->orderBy('process.created_at', 'DESC')
                ->get();
        return view('admin.report')->with('process', $process);
    }

}
