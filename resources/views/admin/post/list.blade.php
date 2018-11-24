@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <h4 class="m-t-0">Bài viết</h4>

                <hr />


                <form name="filterUser" action="{{url('admin?view=User')}}" method="GET">

                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Users</label>
                                <div>
                                    <select class="form-control">
                                        <option value="">@lang('admin.SELECT_USER')</option>
                                        @foreach($users AS $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Thời gian</label>
                                <div>
                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="text" class="form-control" name="filter[start]">
                                        <span class="input-group-addon b-0">Tới</span>
                                        <input type="text" class="form-control" name="filter[end]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary"><i class="mdi mdi-filter-outline"></i> Lọc</button>
                            <a href="{{url('/admin?view=Post')}}">
                                <button type="button" class="btn btn-primary">
                                    <i class="mdi mdi-notification-clear-all"></i> Reset
                                </button>
                            </a>
                        </div>
                    </div>

                    <input type="hidden" name="view" value="Post">

                </form>


                <div class="table-responsive">

                    <div class="row">
                        <div class="col-sm-6">
                        </div>
                        <div class="col-sm-6">
                            <div id="datatable-responsive_filter" class="dataTables_filter">
                                <a href="<?= url('/admin?controller=Post&task=create') ?>" type="button" class="btn btn-primary">
                                    Thêm
                                </a>
                                <button type="button" onclick="javascrip:alert('Đang nâng cấp ...')" class="btn btn-primary">Xóa</button>
                            </div>

                        </div>
                    </div>

                    <table class="table table-hover mails m-0 table table-actions-bar">
                        <thead>
                            <tr>
                                <th style="min-width: 95px;">
                                    <div class="checkbox checkbox-primary checkbox-single m-r-15">
                                        <input id="action-checkbox" type="checkbox">
                                        <label for="action-checkbox"></label>
                                    </div>
                                </th>
                                <th>User</th>
                                <th>Content</th>
                                <th>Reaction</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Option</th>
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

                                <td>
                                    <a href="{{url('/admin?view=User&layout=edit&id=' . $item->id)}}" target="_blank">
                                        {{$item->name}}
                                    </a>
                                </td>

                                <td>
                                    <a href="{{url('admin?view=Post&layout=edit&id='.$item->id)}}" class="text-muted">{{substr($item->content, 0, 200)}}...</a>
                                </td>

                                <td>
                                    
                                </td>

                                <td>
                                    {{$item->created_at}}
                                </td>

                                <td>
                                    {{$item->updated_at}}
                                </td>
                                <td>
                                    <a onclick="return confirm('Want to delete?')" href="{{url('admin?controller=Post&task=destroy&id='.$item->id)}}">
                                        <button class="btn btn-sm btn-danger">Delete</button>
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


@section('javascript')
    <script type="text/javascript">
        $('.input-daterange').datepicker();
    </script>
@stop

