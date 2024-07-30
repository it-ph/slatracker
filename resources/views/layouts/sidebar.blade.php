<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                {{-- MAIN NAVIGATION --}}
                {{-- <li class="menu-title" key="t-menu">Main Navigation</li> --}}
                @auth
                {{-- Start of Developers --}}
                    <li>
                        <a href="{{ url('home') }}" class="waves-effect">
                            <i class="bx bxs-bar-chart-alt-2"></i>
                            <span key="t-home">Dashboard</span>
                        </a>
                    </li>

                    {{-- @if(in_array('admin',$user['roles']) || in_array('developer',$user['roles']))
                        <li>
                            <a href="{{ url('my-jobs/all') }}" class="waves-effect">
                                <i class="bx bx-task" @if(\Request::routeIs('my-jobs.index')) style="color:#fff" @endif></i>
                                <span key="t-jobs" @if(\Request::routeIs('my-jobs.index')) style="color:#fff" @endif>My Jobs</span>
                            </a>
                        </li>
                    @endif --}}

                {{-- End of Developers --}}

                {{-- Start of ADMIN / TL / MANAGER --}}
                    <li>
                        <a href="{{ url('job/create') }}" class="waves-effect">
                            <i class="bx bxs-plus-circle"></i>
                            <span key="t-jobs">Add Job</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('pending-jobs') }}" class="waves-effect">
                            <i class="bx bx-loader"></i>
                            <span key="t-pending-jobs">Pending Jobs</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('my-jobs') }}" class="waves-effect">
                            <i class="bx bx-task"></i>
                            <span key="t-my-jobs">My Jobs</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('quality-check') }}" class="waves-effect">
                            <i class="bx bxs-check-circle"></i>
                            <span key="t-quality-check">Quality Check</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('jobs') }}" class="waves-effect">
                            <i class="bx bxs-data"></i>
                            <span key="t-jobs">All Jobs</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('permissions') }}" class="waves-effect">
                            <i class="bx bxs-calendar"></i>
                            <span key="t-users">Event Calendar</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('clients') }}" class="waves-effect">
                            <i class="bx bx-hive"></i>
                            <span key="t-client">Clients</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('users') }}" class="waves-effect">
                            <i class="bx bxs-user-circle"></i>
                            <span key="t-users">Users</span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bxs-report"></i>
                            <span key="t-email">Reports</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ url('reports') }}" key="t-inbox">Job Logs</a></li>
                            <li><a href="{{ url('reports') }}" key="t-read-email">Audit Logs</a></li>
                            <li><a href="{{ url('reports') }}" key="t-read-email">Development Report</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-transfer-alt"></i>
                            <span key="t-email">Reallocation</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ url('reports') }}" key="t-read-email">Reallocate Job</a></li>
                            <li><a href="{{ url('reports') }}" key="t-read-email">Reallocate QC</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-cog"></i>
                            <span key="t-settings">Miscellaneous</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ url('request/types') }}" key="t-read-email">Request Type</a></li>
                            <li><a href="{{ url('request/volumes') }}" key="t-read-email">Request Volume</a></li>
                            <li><a href="{{ url('request/slas') }}" key="t-read-email">Request SLA</a></li>
                            <li><a href="{{ url('configurations') }}" key="t-read-email">Email Configuration</a></li>
                        </ul>
                    </li>
                {{-- End of ADMIN / TL / OM --}}
                @endauth
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
