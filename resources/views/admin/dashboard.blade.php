@extends('admin.layouts.master')
@section('title','Dashboard')
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
                                            Dizel (%{{number_format(((($capasity[0]->current_fullnes) * 100) / $capasity[0]->capasity),2)}})
                                            <span class="float-right"><b>{{$capasity[0]->current_fullnes}}</b>/{{$capasity[0]->capasity}}</span>
                                            <div class="progress progress-sm">

                                                <div class="progress-bar bg-primary" style="width: {{(($capasity[0]->current_fullnes) * 100) / $capasity[0]->capasity}}% "></div>
                                            </div>
                                        </div>
                                        <!-- /.progress-group -->

                                        <div class="progress-group">
                                            Benzin (%{{number_format(((($capasity[1]->current_fullnes) * 100) / $capasity[1]->capasity),2)}})
                                            <span class="float-right"><b>{{$capasity[1]->current_fullnes}}</b>/{{$capasity[1]->capasity}}</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-danger" style="width: {{(($capasity[1]->current_fullnes) * 100) / $capasity[1]->capasity}}%"></div>
                                            </div>
                                        </div>

                                        <!-- /.progress-group -->
                                        <div class="progress-group">
                                            <span class="progress-text">LPG (%{{number_format(((($capasity[2]->current_fullnes) * 100) / $capasity[2]->capasity),2)}})
                                            </span>
                                            <span class="float-right"><b>{{$capasity[2]->current_fullnes}}</b>/{{$capasity[2]->capasity}}</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-success" style="width: {{(($capasity[2]->current_fullnes) * 100) / $capasity[2]->capasity}}%"></div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- ./card-body -->
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-4 col-6">
                                        <div class="description-block border-right">
                                            <h5 class="description-header">{{$istatistik['salescount']}}</h5>
                                            <span class="description-text">Günlük Yapılan Satış Sayısı</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 col-6">
                                        <div class="description-block border-right">
                                            <h5 class="description-header">{{$istatistik['ciro']}}</h5>
                                            <span class="description-text">Günlük Ciro</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 col-6">
                                        <div class="description-block">
                                            <h5 class="description-header">{{$istatistik['usercount']}}</h5>
                                            <span class="description-text">Aktif Personel Sayısı</span>
                                        </div>
                                        <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->

@endsection
