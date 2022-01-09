@extends('admin.layouts.master')
@section('title','Kullanıcı Yönetimi')
@section('content')

    <br>

    <div class="row">
        <div class="col-md-4"> </div>
        <div class="col-md-4">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kullanıcı Düzenle</h3>
                </div>

                <div class="card-body">

                    @if($errors->any())
                        @php \Alert::alert('Hata', 'Bir hata oluştu', 'error') @endphp
                    @endif

                    <form action="{{route('admin.user.edit.action',['id' => $user->id])}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">E-Mail</label>
                                <input class="form-control" value="{{$user->email}}" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">İsim</label>
                                <input class="form-control" value="{{$user->name}}" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Şifre</label>
                                <input class="form-control" name="password">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Yetki Seviyesi</label>
                                <select class="form-control" name="permission_level" aria-label="Default select example"
                                        required>
                                    <option>Yetki seviyesi seçiniz</option>
                                    <option value="admin" {{ ($user->permission_level == 'admin') ? 'selected' : '' }}>Yönetici</option>
                                    <option value="user"  {{ ($user->permission_level == 'user') ? 'selected' : '' }}>Kullanıcı</option>
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


    </div>

@endsection
