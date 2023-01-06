<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{route('dashboard')}}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        @foreach(ListMenu() as $r)
        @if($r['is_menu'] || $r['is_single_menu'])
            @if($r['url'])
            <li class="nav-item">
                <a class="nav-link " href="{{url(htmlspecialchars($r['url']))}}">
                    <i class="bi bi-grid"></i>
                    <span>{{$r['label']}}</span>
                </a>
            </li><!-- End Dashboard Nav -->
            @else
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#{{$r['gmenu']}}" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>{{$r['label']}}</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                @if(!empty($r['menu']))
                    @foreach($r['menu'] as $m)
                        @if(empty($m['sub_menu']))
                        <ul id="{{$r['gmenu']}}" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            <li>
                                <a href="{{url(htmlspecialchars($m['url']))}}">
                                    <i class="bi bi-circle"></i><span>{{$m['label']}}</span>
                                </a>
                            </li>
                        </ul>
                        @else
                        <ul id="{{$r['gmenu']}}" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                            <li class="nav-item">
                                <a class="nav-link collapsed" data-bs-target="#charts-nav1" data-bs-toggle="collapse1" href="{{$m['url']}}" aria-expanded="false">
                                    <i class="bi bi-bar-chart"></i><span>{{$m['label']}}</span><i class="bi bi-chevron-down ms-auto"></i>
                                </a>
                                @foreach($m['sub_menu'] as $sm)
                                <ul id="charts-nav1" class="nav-content collapse1" data-bs-parent="#sidebar-nav" style="padding-left:15px">
                                    <li>
                                        <a href="{{url(htmlspecialchars($sm['url']))}}">
                                            <i class="bi bi-circle"></i><span>{{$sm['label']}}</span>
                                        </a>
                                    </li>
                                </ul>
                                @endforeach
                            </li>
                        </ul>
                        @endif
                    @endforeach
                @endif
            </li><!-- End Components Nav -->
            @endif
        @endif
        @endforeach
    </ul>

</aside>