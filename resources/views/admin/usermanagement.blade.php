@extends('admin.layouts.master')
@section('title','Kullanıcı Yönetimi')
@section('content')

    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kullanıcı Ekle</h3>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        @php \Alert::alert('Hata', 'Bir hata oluştu', 'error') @endphp
                    @endif

                    <form action="{{route('admin.user.register')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">E-Mail</label>
                                <input class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">İsim</label>
                                <input class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Şifre</label>
                                <input class="form-control" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Yetki Seviyesi</label>
                                <select class="form-control" name="permission_level" aria-label="Default select example"
                                        required>
                                    <option selected>Yetki seviyesi seçiniz</option>
                                    <option value="admin">Yönetici</option>
                                    <option value="user">Kullanıcı</option>
                                </select>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kullanıcılar</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>E-Mail</th>
                            <th>Adı</th>
                            <th>Yetki Seviyesi</th>
                            <th style="width: 40px">İşlem</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td width="20">{{$user->email}}</td>
                                <td>{{$user->name}}</td>
                                <td>
                                   @if($user->permission_level== 'admin')
                                       Yönetici
                                       @else
                                        Çalışan
                                       @endif
                                </td>
                                <td><a href="{{route('admin.user.edit',['id' => $user->id])}}">Düzenle</a>/<a
                                        href="{{route('admin.user.delete',['id' => $user->id])}}">Sil</a></td>
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
