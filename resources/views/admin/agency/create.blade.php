@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="m-b-20 header-title">@lang('admin.CREATE_STORE')</h4>
                @include('layouts.admin.notice')
                <form enctype='multipart/form-data' method="POST"
                      action="{{url('admin?controller=Agency&task=store')}}">
                    {{ csrf_field() }}
                    <div class="col-sm-12">

                        @if($currentUser->group->key == config('auth.usergroup.agency'))
                            @php
                                $listDisabled = true;
                            @endphp
                        @endif

                        @if(!isset($listDisabled) || $listDisabled == false)

                        <div class="form-group">
                            <label>Chủ sở hữu <span>*</span></label>
                            <select name="data[user_id]" class="form-control" required>
                                <option value="">Chọn tài khoản sở hữu</option>
                                @foreach($users AS $value)
                                    <option value="{{$value->id}}">{{ $value->name . ' ' . $value->email }}</option>
                                @endforeach
                            </select>
                        </div>

                        @endif

                        <div class="form-group">
                            <label>Loại cửa hàng <span>*</span></label>
                            <select name="data[type]" id="type" class="form-control">
                                <option value="1">@lang('admin.CAFE_STORE')</option>
                                <option value="2">@lang('admin.restaurant')</option>
                                <option value="3">@lang('admin.GIF')</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tên quán <span>*</span></label>
                            <input type="text" class="form-control" name="data[name]" required/>
                        </div>

                        <div class="form-group">
                            <label>Tỉnh/Thành phố<span></span></label>

                            <select name="data[province_id]" class="form-control" id="province" required>
                                <option>Chọn tỉnh/thành phố</option>
                                @foreach(App\ProvinceGroup::all_province() AS $value)
                                    <option value="{{$value->matp}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Quận/Huyện<span></span></label>

                            <select name="data[district_id]" id="district" class="form-control" required>
                                <option>Chọn quận/huyện</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Xã/Phường<span></span></label>

                            <select name="data[village_id]" id="village" class="form-control" required>
                                <option>Chọn xã/phường</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Địa chỉ<span></span></label>
                            <input type="text" name="data[address]" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Hotline<span></span></label>
                            <input type="text" name="data[hotline]" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Email<span></span></label>
                            <input type="text" name="data[email]" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Website<span></span></label>
                            <input type="text" name="data[website]" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label>Chủ<span></span></label>
                            <input type="text" name="data[owner]" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Owner mobile<span></span></label>
                            <input type="text" name="data[owner_mobile]" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Tên quản lý<span></span></label>
                            <input type="text" name="data[manager]" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>SĐT quản lý<span></span></label>
                            <input type="text" name="data[manager_mobile]" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Giá max<span></span></label>
                            <input type="number" step="0.01" name="data[max_price]" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Giá min<span></span></label>
                            <input type="number" step="0.01" name="data[min_price]" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Mở cửa<span></span></label>
                            <input type="time" name="data[open]" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Đóng cửa<span></span></label>
                            <input type="time" name="data[close]" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <fieldset class="form-group">
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="$('#pro-image').click()">Tải ảnh lên</a>
                                <input type="file" id="pro-image" name="images[]" style="display: none;" class="form-control" multiple>
                            </fieldset>
                            <div class="preview-images-zone">

                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('javascript')
    <script src="{{ asset('public/ckfinder/ckfinder.js') }}"></script>

    <script>

        function selectFileWithCKFinder(elementId) {
            CKFinder.popup({
                chooseFiles: true,
                width: 800,
                height: 600,
                onInit: function (finder) {
                    finder.on('files:choose', function (evt) {
                        var file = evt.data.files.first();
                        console.log(file.get( 'folder' ).attributes.name);
                        var output = document.getElementById(elementId);
                        var path = 'public/images/'+ file.get( 'folder' ).attributes.name + '/' +file.get( 'name' );
                        output.value = path;
                    });

                    finder.on('file:choose:resizedImage', function (evt) {
                        var output = document.getElementById(elementId);
                        output.value = evt.data.resizedUrl;
                    });
                }
            });
        }
    </script>

    <script>


        $(document).ready(function(){

            var type = '{{$type}}';
            $('#type').val(type);

            $("#province").change(function () {
                loadDistrict();
            })


            $("#district").change(function () {
                jQuery.ajax({
                    type:'POST',
                    url:'?controller=Agency&task=ajaxLoadVillage',
                    data: {districtID: $(this).val()},
                    success:function(response){
                        console.log(response);
                        // return;
                        var data = JSON.parse(response);
                        jQuery("#village").html('<option>Chọn xã/phường</option>');
                        for (let i = 0; i < data.length; i ++){
                            jQuery("#village").append('<option value="'+data[i].xaid+'">'+data[i].name+'</option>');
                        }

                    }
                });
            })
        });

        function loadDistrict(){
            jQuery.ajax({
                type:'POST',
                url:'?controller=Agency&task=ajaxLoadDistrict',
                data: {provinceID: jQuery("#province").val()},
                success:function(response){
                    var data = JSON.parse(response);
                    jQuery("#district").html('<option>Chọn quận/huyện</option>');
                    for (let i = 0; i < data.length; i ++){
                        jQuery("#district").append('<option value="'+data[i].maqh+'">'+data[i].name+'</option>');
                    }

                }
            });
        }
    </script>
@stop