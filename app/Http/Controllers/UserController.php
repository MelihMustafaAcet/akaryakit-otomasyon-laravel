<?php

namespace App\Http\Controllers;

use App\Models\Prices;
use App\Models\Process;
use App\Models\Sales;
use App\Models\Settings;
use App\Models\Tanks;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Auth;
use PHPHtmlParser\Dom;
use RealRashid\SweetAlert\Facades\Alert;
use stringEncode\Exception;

class UserController extends Controller
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
            $salescount = count(Sales::all()->toArray());

            $ciro = Sales::all()->toArray();
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

    public function pompa(string $type, string $tankName, int $miktar)
    {
        if ($type == 'satis') {
            $tank = Tanks::where('fuel_type', '=', $tankName)->first();
            if ($miktar > $tank->current_fullnes) {
                Alert::alert('Hata', 'Tankta yeterli yakıt yok', 'error');

                return false;
            } else {
                $tank->current_fullnes = $tank->current_fullnes - $miktar;
                $tank->save();
                return true;
            }
        }
    }

    public function index()
    {
        $capasity = $this->getSomething('tanks');
        $fiyatlar = $this->getPrice();

        return view('user.dashboard')->with('capasity', $capasity)->with('fiyatlar', $fiyatlar);
    }

    public function makeSale(Request $request)
    {
        if (!$request->selectedgas) {
            Alert::alert('Hata', 'Seçim yapınız', 'error');
            return back();
        }
        $tank_id = null;
        if ($request->selectedgas == 'Dizel' || $request->selectedgas == 'Dizel2') {
            $tank_id = 1;
        } elseif ($request->selectedgas == 'Benzin') {
            $tank_id = 2;
        } else {
            $tank_id = 3;
        }
        $sale = new Sales();
        $sale->user_id = Auth::user()->id;
        $sale->platenumber = $request->plate;
        $sale->fuel_type = $request->selectedgas;
        $sale->fuel_litre = $request->miktar;
        $sale->total_price = $request->price;
        if ($this->pompa('satis', $request->selectedgas, $request->miktar)) {

            if ($sale->save()) {
                $process = new Process();
                $process->plate = $request->plate;
                $process->user_id = Auth::user()->id;
                $process->tank_id = $tank_id;
                $process->fuel_amount = $request->miktar;
                $process->type = 'Satış';
                $process->sale_id = $sale->id;
                $process->save();
                Alert::alert('Başarılı', 'Satış yapıldı', 'success');
            } else {
                Alert::alert('Hata', 'Bir hata oluştu, satış yapılamadı', 'error');
            }
        } else {
            Alert::alert('Hata', 'Bir hata oluştu, satış yapılamadı', 'error');
        }
        return back();
    }


}
