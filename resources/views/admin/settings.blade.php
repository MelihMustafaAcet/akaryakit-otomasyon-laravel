@extends('admin.layouts.master')
@section('title','Ayarlar')
@section('content')

    <br>

    <div class="row">
        <div class="col-md-4"> </div>
        <div class="col-md-4">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ayarları Güncelle</h3>
                </div>

                <div class="card-body">


                    <form action="{{route('admin.settings.update')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Fiyat Güncelleme İşlemi</label>
                                <select class="form-control" name="value" aria-label="Default select example"
                                        required>
                                    <option>İşlem Tipi</option>
                                    <option value="1" {{$settings->isPriceOnline ? 'selected' : ''}}>Online</option>
                                    <option value="0" {{!$settings->isPriceOnline ? 'selected' : ''}}>Manuel</option>
                                </select>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </form>
                        <br>
                        <br>

                    @if(!$settings->isPriceOnline)
                            <form action="{{route('admin.price.update')}}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Akaryakıt Fiyatları</label>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Motorin</label>
                                            <input class="form-control" value="{{$prices['motorin']}}" name="Dizel" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Motorin 2</label>
                                            <input class="form-control" value="{{$prices['motorin2']}}" name="Dizel2" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Benzin</label>
                                            <input class="form-control" value="{{$prices['benzin']}}" name="Benzin" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">LPG</label>
                                            <input class="form-control" value="{{$prices['lpg']}}" name="LPG" required>
                                        </div>

                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Kaydet</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

            </div>


    </div>

@endsection
