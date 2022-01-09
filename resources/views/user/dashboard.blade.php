@extends('user.layouts.master')
@section('title','Kullanıcı Arayüzü')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Tank Detayları</h5>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-center">
                                        <strong>Tank Doluluk Oranları</strong>
                                    </p>

                                    <div class="progress-group">
                                        Dizel (%{{ number_format(((($capasity[0]->current_fullnes) * 100) / $capasity[0]->capasity),2) }})
                                        <span class="float-right"><b>{{$capasity[0]->current_fullnes}}</b>/{{$capasity[0]->capasity}}</span>
                                        <div class="progress progress-sm">

                                            <div class="progress-bar bg-primary"
                                                 style="width: {{(($capasity[0]->current_fullnes) * 100) / $capasity[0]->capasity}}% "></div>
                                        </div>
                                    </div>
                                    <!-- /.progress-group -->

                                    <div class="progress-group">
                                        Benzin (%{{number_format( ((($capasity[1]->current_fullnes) * 100) / $capasity[1]->capasity) , 2) }})
                                        <span class="float-right"><b>{{$capasity[1]->current_fullnes}}</b>/{{$capasity[1]->capasity}}</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-danger"
                                                 style="width: {{(($capasity[1]->current_fullnes) * 100) / $capasity[1]->capasity}}%"></div>
                                        </div>
                                    </div>

                                    <!-- /.progress-group -->
                                    <div class="progress-group">
                                            <span class="progress-text">LPG (%{{number_format( ((($capasity[2]->current_fullnes) * 100) / $capasity[2]->capasity ) , 2) }})
                                            </span>
                                        <span class="float-right"><b>{{$capasity[2]->current_fullnes}}</b>/{{$capasity[2]->capasity}}</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success"
                                                 style="width: {{(($capasity[2]->current_fullnes) * 100) / $capasity[2]->capasity}}%"></div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./card-body -->

                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Satış Ekranı</h5>

                        </div>
                        <form action="{{route('user.sale')}}" method="post">
                            @csrf
                            <div>
                                <div class="cont_order">
                                    <fieldset>
                                        <div class="form-check">
                                            <br>
                                            <div class="form-group">
                                                <label class="form-check-label">Plaka Giriniz....</label>
                                                <input type="text" class="form-control" name="plate" required>
                                            </div>
                                           <br>
                                            <input type="radio" name="selectedgas"
                                                   value="Benzin" onclick="calculateTotal()" id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Kurşunsuz Benzin TL/LT (₺{{floatval($fiyatlar['benzin'])}})
                                            </label>
                                        </div>
                                        <br>
                                        <div class="form-check">
                                            <input  type="radio" name="selectedgas"
                                                   value="Dizel" onclick="calculateTotal()" id="flexRadioDefault2">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Motorin (Eco Force Eurodiesel) TL/LT(₺{{floatval($fiyatlar['motorin'])}})
                                            </label>
                                        </div>
                                        <br>
                                        <div class="form-check">
                                            <input  type="radio" name="selectedgas"
                                                   value="Dizel" onclick="calculateTotal()" id="flexRadioDefault3">
                                            <label class="form-check-label" for="flexRadioDefault3">
                                                Motorin (Ultra Force Eurodiesel) TL/LT(₺{{floatval($fiyatlar['motorin2'])}})
                                            </label>
                                        </div>
                                        <br>
                                        <div class="form-check">
                                            <input  type="radio" name="selectedgas"
                                                   value="lpg" onclick="calculateTotal()" id="flexRadioDefault4">
                                            <label class="form-check-label" for="flexRadioDefault4">
                                                LPG(₺{{floatval($fiyatlar['lpg'])}})
                                            </label>
                                        </div>
                                        <br>


                                        <input id="kursunsuz" type="hidden" value="{{floatval($fiyatlar['benzin'])}}">
                                        <input id="motorineco" type="hidden" value="{{floatval($fiyatlar['motorin'])}}">
                                        <input id="motorinultra" type="hidden" value="{{floatval($fiyatlar['motorin2'])}}">
                                        <input id="lpg" type="hidden" value="{{floatval($fiyatlar['lpg'])}}">
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text"
                                                  id="inputGroup-sizing-sm">  Miktarı giriniz :</span>
                                            <input class="form-control" aria-label="Sizing example input" required name="miktar"
                                                   aria-describedby="inputGroup-sizing-sm" id="filling" type="text"
                                                   oninput="calculateTotal()">
                                        </div>

                                        <br/>

                                        <div id="totalPrice">Miktar Giriniz...</div>

                                        <input type="hidden" id="getget" name="price">


                                    </fieldset>
                                </div>

                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon1">Satış Yap
                                    </button>
                                </div>


                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->

@endsection
@section('scripts')
    <script>
        //Set up an associative array
        //The keys represent the size of the cake
        //The values represent the cost of the cake i.e A 10" cake cost's $35
        function getKursunsuz() {
            var kursunse = document.getElementById('kursunsuz');
            return kursunse.value;
        }

        function getMotorinEco() {
            var motorinse = document.getElementById('motorineco');
            return motorinse.value;
        }

        function getMotorinUltra() {
            var motorinuse = document.getElementById('motorinultra');
            return motorinuse.value;
        }

        function getLpg() {
            var lpgse = document.getElementById('lpg');
            return lpgse.value;
        }

        var gas_prices = new Array();
        gas_prices["Benzin"] = getKursunsuz();
        gas_prices["Dizel"] = getMotorinEco();
        gas_prices["Dizel"] = getMotorinUltra();
        gas_prices["lpg"] = getLpg();

        function getGasPrice() {
            var gasRadio = document.getElementsByName('selectedgas');

            for (i = 0; i < gasRadio.length; i++) {
                if (gasRadio[i].checked) {
                    user_input = gasRadio[i].value;
                }
            }

            return gas_prices[user_input];
        }

        function getFillingPrice() {
            var gasSelect = document.getElementById('filling');
            return gasSelect.value;
        }


        function calculateTotal() {
            var total = getGasPrice() * getFillingPrice();
            var totalEl = document.getElementById('totalPrice');
            var totalEll = document.getElementById('getget');

            document.getElementById('totalPrice').innerHTML = "Fiyat : ₺" +  total.toFixed(2);
            document.getElementById('getget').value = total.toFixed(2);
            totalEl.style.display = 'block';
            totalEll.style.display = 'block';

            return total;
        }


    </script>
@endsection
