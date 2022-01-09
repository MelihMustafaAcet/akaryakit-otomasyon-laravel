@extends('admin.layouts.master')
@section('title','Tank Boşaltım')
@section('content')

    <br>
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tank Boşaltım</h3>
            </div>
            @if($errors->any())
                @php \Alert::alert('Hata', 'Bir hata oluştu', 'error') @endphp
            @endif

            <form action="{{route('admin.unload.post',['id' => $tank->id])}}" method="post">
                @csrf
                <div class="card-body">
                    <div class="alert alert-danger" role="alert">
                       BU TANKI BOŞALTMAKTASINIZ!
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Yakıt Tipi</label>
                        <input class="form-control" value="{{$tank->fuel_type}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Kapasite</label>
                        <input class="form-control" value="{{$tank->capasity}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mevcut Miktar</label>
                        <input class="form-control" value="{{$tank->current_fullnes}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Boşaltım Miktarı</label>
                        <input type="number" class="form-control" name="miktar">
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Boşalt</button>
                </div>
            </form>
        </div>

    </div>

@endsection
