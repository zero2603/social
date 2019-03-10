@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0">@lang('admin.EVENT')</h4>
                <hr>

                <form name="filterUser" action="{{url('admin?view=Transaction')}}" method="GET">

                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tên quán</label>
                                <div>
                                    <input type="text" class="form-control" placeholder="Keywork">
                                </div>
                            </div>
                        </div>

                    </div>


                    <input type="hidden" name="view" value="listEvent">

                </form>

                <hr>

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
                            <th>@lang('admin.NAME')</th>
                            <th>Min/Max</th>
                            <th>@lang('admin.START_TIME')</th>
                            <th>@lang('admin.CREATOR')</th>
                            <th>@lang('admin.TYPE')</th>
                            <th>@lang('admin.AGENCY')</th>
                            <th>@lang('admin.STATUS')</th>
                            <th>@lang('admin.OPTION')</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($items AS $item)

                            @php
                                $status = \App\Event::getStatusById($item->status);
                                $type = \App\Event::getDatingTypeById($item->type);
                            @endphp

                            <tr>
                                <td>
                                    <div class="checkbox checkbox-primary m-r-15">
                                        <input id="checkbox1" type="checkbox">
                                        <label for="checkbox1"></label>
                                    </div>
                                </td>

                                <td>
                                    <a href="admin?view=Event&layout=editEvent&id={{$item->id}}">
                                        {{$item->name}}
                                    </a>
                                </td>

                                <td>
                                    {{$item->min_number . "/" . $item->limit_number}}
                                </td>

                                <td>{{$item->start_time}}</td>

                                <td>{{$item->creator_name}}</td>
                                <td>@lang('admin.'.$type->label)</td>
                                <td>{{$item->agency_name}}</td>
                                <td>
                                    <p>
                                        <span style="color: {{$status->color}}">@lang('admin.'.$status->label)</span>
                                    </p>
                                    <p>
                                        @if($item->is_approved === 0)
                                            @php
                                            $status = BookproHelper::getRegisterStatusAgency($item->is_approved)
                                            @endphp
                                            <span class="{{ $status->class }}">
                                                {{ $status->name }}
                                            </span>
                                        @endif
                                    </p>
                                </td>

                                <td>
                                    @if($item->is_approved === 0)
                                        <a href="{{url('admin?controller=Event&task=approve&id='.$item->id)}}" onclick="return confirm('Are you sure?')">
                                            <button class="btn btn-sm btn-primary">Duyệt</button>
                                        </a>
                                    @endif

                                    <a href="{{url('admin?controller=Post&task=destroy&id='.$item->id)}}" onclick="return confirm('Want to delete?')">
                                        <button class="btn btn-sm btn-danger">@lang('admin.DELETE')</button>
                                    </a>
                                </td>
                            </tr>


                        @endforeach


                        </tbody>
                    </table>
                </div>
                {{ $items->links() }}
            </div>
        </div>
    </div>
@endsection
