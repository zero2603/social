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
                                    <a href="javascript: void(0);" aria-expanded="true"><i class="ti-light-bulb"></i> @lang('Users') <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">
                                        <li><a href="{{url('/admin?view=User')}}"><i class="ti-person"></i>@lang('Users')</a></li>
                                        <li><a href="{{url('/admin?view=User&layout=create')}}"><i class="ti-person"></i>@lang('Create user')</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript: void(0);" aria-expanded="true"><i class="ti-light-bulb"></i> @lang('User Groups') <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">
                                        <li><a href="{{url('/admin?view=UserGroup')}}"><i class="ti-person"></i>@lang('User Groups')</a></li>
                                        <li><a href="{{url('/admin?controller=UserGroup&task=create')}}"><i class="ti-person"></i>@lang('Create user group')</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" aria-expanded="true"><i class="ti-light-bulb"></i> @lang('Posts') <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">
                                        <li><a href="{{url('/admin?view=Post')}}"><i class="ti-person"></i>@lang('Posts')</a></li>
                                        <li><a href="{{url('/admin?controller=Post&task=create')}}"><i class="ti-person"></i>@lang('Create new post')</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" aria-expanded="true"><i class="ti-light-bulb"></i> @lang('1 số config') <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">

                                        <li><a href="{{url('/admin?view=Job')}}"><i class="ti-person"></i>@lang('Jobs')</a></li>
                                        <li><a href="{{url('/admin?controller=Job&task=create')}}"><i class="ti-person"></i>@lang('Create new Jobs')</a></li>

                                        <li><a href="{{url('/admin?view=ProvinceGroup')}}"><i class="ti-person"></i>@lang('Province Groups')</a></li>
                                        <li><a href="{{url('/admin?controller=ProvinceGroup&task=create')}}"><i class="ti-person"></i>@lang('Thêm group')</a></li>

                                    </ul>
                                </li>

                                <li>
                                    <a href="javascript: void(0);" aria-expanded="true"><i class="ti-light-bulb"></i> @lang('Events') <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">
                                        <li><a href="{{url('/admin?view=Event&layout=listEvent')}}"><i class="ti-person"></i>@lang('Events')</a></li>
                                        <li><a href="{{url('/admin?view=Event&layout=listEventSchedules')}}"><i class="ti-person"></i>@lang('Event Schedules')</a></li>
                                        <li><a href="{{url('/admin?controller=Event&task=create')}}"><i class="ti-person"></i>@lang('Create new event')</a></li>
                                    </ul>
                                </li>
                                
                                <li>
                                    <a href="{{url('/admin?view=Configuration')}}"><i class="ti-light-bulb"></i> Configuration <span class="fa arrow"></span></a>
                                    <ul class="nav-second-level nav" aria-expanded="true">
                                        <li><a href="{{url('/admin?view=Configuration&option=general')}}"><i class="ti-person"></i>@lang('Cấu hình chung')</a></li>
                                        <li><a href="{{url('/admin?view=Configuration&option=seo')}}"><i class="ti-person"></i>@lang('Cấu hình Seo')</a></li>
                                        <li><a href="{{url('/admin?view=Configuration&option=general')}}"><i class="ti-person"></i>@lang('Cấu hình ..v..v..')</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{url('/admin?controller=user&task=test')}}"><i class="ti-home"></i> Test controller admin </a></li>

                            </ul>
                        </div>
                    </div><!--Scrollbar wrapper-->