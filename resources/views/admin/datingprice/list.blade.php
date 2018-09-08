@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0">Quản lý giá hẹn hò</h4>
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
                            <th>Type</th>
                            <th>Nhóm tỉnh</th>
                            <th>Giá (VND)</th>
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

                                </td>
                                <td>
                                    <a href="{{'admin?view=Finance&layout=edit&id='.$item->id}}">
                                        {{BookproHelper::get_group_name_by_id($item->group_id)}}
                                    </a>
                                </td>
                                <td> {{BookproHelper::get_finance_type_name($item->type)}}</td>
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