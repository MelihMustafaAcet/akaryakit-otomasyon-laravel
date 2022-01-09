@extends('admin.layouts.master')
@section('title','Tank Detayları')
@section('content')

    <br>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tanklar</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Yakıt Tipi</th>
                        <th>Kapasite</th>
                        <th>Doluluk</th>
                        <th style="width: 40px">Yüzde</th>
                        <th style="width: 40px">İşlem</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tanks as $tank)
                    <tr>
                        <td>{{$tank->id}}</td>
                        <td>{{$tank->fuel_type}}</td>
                        <td>{{$tank->capasity}} Lt</td>
                        <td>
                            <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-success" style="width: {{($tank->current_fullnes *100) / $tank->capasity}}%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-success">{{number_format((($tank->current_fullnes *100) / $tank->capasity),2) }}%</span></td>
                        <td><a href="{{route('admin.filling',['id' => $tank->id])}}">Doldur</a>/<a href="{{route('admin.unload',['id' => $tank->id])}}">Boşalt</a></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->


        <!-- /.card -->
    </div>

@endsection
