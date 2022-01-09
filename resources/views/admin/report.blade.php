@extends('admin.layouts.master')
@section('title','Kullanıcı Yönetimi')

@section('content')

    <br>
    <div class="row">


        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rapor Tablosu</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example" class="display nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Kullanıcı</th>
                            <th>Plaka</th>
                            <th>Yakıt Tipi</th>
                            <th>Yakıt Litresi</th>
                            <th>Fiyat</th>
                            <th>İşlem Tipi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($process as $proces => $item)
                            <tr>
                                <td>{{$proces+1}}</td>
                                <td width="20">{{$item->name}}</td>
                                <td>{{$item->plate}}</td>
                                <td>{{$item->fuel_type}}</td>
                                <td>{{$item->fuel_amount}}</td>
                                <td>{{$item->total_price ?? 'Fiyat yok'}}</td>
                                <td>{{$item->type}}</td>
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
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                language: {
                    "url":"//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
                },
                responsive: true
            } );
        } );
    </script>
@endsection
