@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0">% Lợi nhuận</h4>
                <div class="table-responsive">
                    <table class="table table-hover mails m-0 table table-actions-bar">
                        <thead>
                        <tr>
                            <th>
                                <div class="checkbox checkbox-primary checkbox-single m-r-15">
                                    <input id="action-checkbox" type="checkbox">
                                    <label for="action-checkbox"></label>
                                </div>
                            </th>
                            <th>Nhóm</th>
                            <th>Kiểu</th>
                            <th>Giá trị</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($items AS $item)
                            <tr>
                                <td>
                                    <div class="checkbox checkbox-primary m-r-15">
                                        <input id="checkbox1" type="checkbox">
                                        <label for="checkbox1"></label>
                                    </div>

                                    <img src="assets/images/users/avatar-1.jpg" alt="contact-img" title="contact-img" class="img-circle thumb-sm" />
                                </td>
                                <td>{{$item->group_id}}</td>
                                <td>{{$item->type}}</td>
                                <td>{{$item->value}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection