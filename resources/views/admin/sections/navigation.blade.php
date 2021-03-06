<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('admin.dashboard') }}" class="site_title">
                <span>{{ config('app.name') }}</span>
            </a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ auth()->user()->avatar }}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <h2>{{ auth()->user()->name }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>{{ __('views.backend.section.navigation.sub_header_0') }}</h3>
                <ul class="nav side-menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.menu_0_1') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="menu_section">
                <h3>{{ __('views.backend.section.navigation.sub_header_1') }}</h3>
                <ul class="nav side-menu">

                    @if (Auth::user()->hasRole('administrator'))
                    <li>
                        <a href="{{ route('admin.users') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.menu_1_1') }}
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('admin.uploadQuote') }}">
                            <i class="fa fa-upload" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.menu_1_2') }}
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('admin.getQuotes') }}">
                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.menu_1_3') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.newCapturing') }}">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.menu_1_4') }}
                        </a>
                    </li>
                                       
                </ul>
            </div>
            <div class="menu_section">
                <h3>{{ __('views.backend.section.navigation.sub_header_2') }}</h3>

                <ul class="nav side-menu">
                    <li>
 
                        <a>
                            <i class="fa fa-file" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.menu_1_5') }}
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{route('admin.vetting_reports')}}">
                                    {{ __('views.backend.section.navigation.menu_2_4') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.search_dfmiy')}}">
                                    {{ __('views.backend.section.navigation.menu_2_5') }}
                               </a>
                            </li>
                            <li>
                                <a href="{{route('admin.search_total')}}">
                                    {{ __('views.backend.section.navigation.menu_2_6') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.status_change')}}">
                                    {{ __('views.backend.section.navigation.menu_2_7') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            
            <div class="menu_section">
                <h3>{{ __('views.backend.section.navigation.sub_header_4') }}</h3>

                <ul class="nav side-menu">
                    <li>
 
                        <a>
                            <i class="fa fa-file" aria-hidden="true"></i>
                            {{ __('views.backend.section.navigation.menu_1_11') }}
                            <span class="fa fa-chevron-down"></span>
                        </a>
                        <ul class="nav child_menu">
                            <li>
                                <a href="{{route('admin.viewfacilities')}}">
                                    {{ __('views.backend.section.navigation.menu_1_7') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.viewdfm')}}">
                                    {{ __('views.backend.section.navigation.menu_1_8') }}
                               </a>
                            </li>
                            <li>
                                <a href="{{route('admin.viewdistricts')}}">
                                    {{ __('views.backend.section.navigation.menu_1_9') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.viewsubdistricts')}}">
                                    {{ __('views.backend.section.navigation.menu_1_10') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.viewContractor')}}">
                                    {{ __('views.backend.section.navigation.menu_1_12') }}
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                </ul>
            </div>
            {{-- <div class="menu_section">
                <h3>{{ __('views.backend.section.navigation.sub_header_3') }}</h3>
                <ul class="nav side-menu">
                  <li>
                      <a href="http://netlicensing.io/?utm_source=Laravel_Boilerplate&utm_medium=github&utm_campaign=laravel_boilerplate&utm_content=credits" target="_blank" title="Online Software License Management"><i class="fa fa-lock" aria-hidden="true"></i>NetLicensing</a>
                  </li>
                  <li>
                      <a href="https://photolancer.zone/?utm_source=Laravel_Boilerplate&utm_medium=github&utm_campaign=laravel_boilerplate&utm_content=credits" target="_blank" title="Individual digital content for your next campaign"><i class="fa fa-camera-retro" aria-hidden="true"></i>Photolancer Zone</a>
                  </li>
                </ul>
            </div> --}}
        </div>
        <!-- /sidebar menu -->
    </div>
</div>
