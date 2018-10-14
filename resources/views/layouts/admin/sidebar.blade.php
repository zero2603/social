<div class="scrollbar-wrapper">
                        <div>
                            <button type="button" class="button-menu-mobile btn-mobile-view visible-xs visible-sm">
                                <i class="mdi mdi-close"></i>
                            </button>
                            <!-- User Detail box -->
                            <div class="user-details">
                                <div class="pull-left">
                                    <img src="assets/images/users/avatar-1.jpg" alt="" class="thumb-md img-circle">
                                </div>
                                <div class="user-info">
                                    <a href="#">Stanley Jones</a>
                                    <p class="text-muted m-0">Administrator</p>
                                </div>
                            </div>
                            <!--- End User Detail box -->

                            <!-- Left Menu Start -->
                            <ul class="metisMenu nav" id="side-menu">
                                <li><a href="{{url('/admin')}}"><i class="ti-home"></i> @lang('Dashboard') </a></li>
                               
                                <li>
                                    <a href="javascript: void(0);" aria-expanded="true"><i class="mdi mdi-account-multiple-plus"></i> @lang('Users') <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">
                                        <li><a href="{{url('/admin?view=User')}}"><i class="ti-person"></i>@lang('Users')</a></li>
                                        <li><a href="{{url('/admin?view=UserGroup')}}"><i class="ti-person"></i>@lang('User Groups')</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" aria-expanded="true"><i class=" mdi mdi-border-color"></i> @lang('Posts') <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">
                                        <li><a href="{{url('/admin?view=Post')}}"><i class="ti-person"></i>@lang('Posts')</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" aria-expanded="true"><i class="mdi mdi-calendar-clock"></i> @lang('Events') <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">
                                        <li><a href="{{url('/admin?view=Event&layout=listEvent')}}"><i class="ti-person"></i>@lang('Events')</a></li>
                                        <li><a href="{{url('/admin?view=Event&layout=listEventSchedules')}}"><i class="ti-person"></i>@lang('Event Schedules')</a></li>
                                        <li><a href="{{url('/admin?controller=Event&task=create')}}"><i class="ti-person"></i>@lang('Create new event')</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" aria-expanded="true"><i class="mdi mdi-diamond"></i> @lang('Module tài chính') <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">
                                        <li><a href="{{url('/admin?view=Finance')}}"><i class="ti-person"></i>@lang('Chia lợi nhuận')</a></li>
                                        <li><a href="{{url('/admin?controller=Finance&task=create')}}"><i class="ti-person"></i>@lang('Thêm cấu hình lợi nhuận')</a></li>
                                        <li><a href="{{url('/admin?view=DatingPrice')}}"><i class="ti-person"></i>@lang('Giá hẹn hò')</a></li>
                                        <li><a href="{{url('/admin?controller=Configuration&option=price')}}"><i class="ti-person"></i>@lang('Cấu hình giá chung')</a></li>

                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);"><i class="mdi mdi-cube-send"></i> Module đại lý <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">
                                        <li><a href="{{url('/admin?view=Agency')}}"><i class="ti-person"></i>@lang('Danh sách đại lý CAFE')</a></li>
                                        <li><a href="{{url('/admin?view=Product')}}"><i class="ti-person"></i>@lang('Sản phẩm')</a></li>
                                        <li><a href="{{url('/admin?view=ProductCategory')}}"><i class="ti-person"></i>@lang('Danh mục sản phẩm')</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" aria-expanded="true"><i class="mdi mdi-settings"></i> @lang('1 số cấu hình khác') <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">

                                        <li><a href="{{url('/admin?view=Job')}}"><i class="ti-person"></i>@lang('Jobs')</a></li>

                                        <li><a href="{{url('/admin?view=ProvinceGroup')}}"><i class="ti-person"></i>@lang('Province Groups')</a></li>

                                        <li><a href="{{url('/admin?view=Hobby')}}"><i class="ti-person"></i>@lang('Sở thích')</a></li>

                                        <li><a href="{{url('/admin?view=Education')}}"><i class="ti-person"></i>@lang('Học vấn')</a></li>

                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" aria-expanded="true"><i class="ti-light-bulb"></i> @lang('Module Hẹn hò') <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">

                                        <li><a href="{{url('/admin?view=Job')}}"><i class="ti-person"></i>@lang('Jobs')</a></li>
                                        <li><a href="{{url('/admin?controller=Job&task=create')}}"><i class="ti-person"></i>@lang('Create new Jobs')</a></li>

                                    </ul>
                                </li>


                                <li>
                                    <a href="{{url('/admin?view=Configuration')}}"><i class="mdi mdi-settings"></i> Configuration <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">
                                        <li><a href="{{url('/admin?view=Configuration&option=general')}}"><i class="ti-person"></i>@lang('Cấu hình chung')</a></li>
                                        <li><a href="{{url('/admin?view=Configuration&option=seo')}}"><i class="ti-person"></i>@lang('Cấu hình Seo')</a></li>
                                        <li><a href="{{url('/admin?view=Configuration&option=general')}}"><i class="ti-person"></i>@lang('Cấu hình ..v..v..')</a></li>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                    </div><!--Scrollbar wrapper-->