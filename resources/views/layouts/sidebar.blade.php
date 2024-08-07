<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                @auth
                    <li>
                        <a href="{{ url('home') }}" class="waves-effect">
                            <i class="fa fa-bar-chart"></i>
                            <span key="t-home">Dashboard</span>
                        </a>
                    </li>

                    {{-- ADMIN / TEAM LEAD / MANAGER --}}
                    @if(in_array('admin',$user['roles']) || in_array('manager',$user['roles']) || in_array('team lead',$user['roles']))
                        <li>
                            <a href="{{ url('job/create') }}" class="waves-effect">
                                <i class="fa fa-plus-circle"></i>
                                <span key="t-jobs">Add Job</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('pendingjobs') }}" class="waves-effect">
                                <i class="fa fa-spinner"></i>
                                <span key="t-pendingjobs">Pending Jobs</span>
                            </a>
                        </li>
                    @endif

                    {{-- ADMIN / DEVELOPER --}}
                    @if(in_array('admin',$user['roles']) || in_array('developer',$user['roles']))
                        <li>
                            <a href="{{ url('myjobs') }}" class="waves-effect">
                                <i class="fa fa-tasks"></i>
                                <span key="t-myjobs">My Jobs</span>
                            </a>
                        </li>
                    @endif

                    {{-- ADMIN / AUDITOR --}}
                    @if(in_array('admin',$user['roles']) || in_array('auditor',$user['roles']))
                        <li>
                            <a href="{{ url('qualitycheck') }}" class="waves-effect">
                                <i class="fa fa-check-circle"></i>
                                <span key="t-qualitycheck">Quality Check</span>
                            </a>
                        </li>
                    @endif

                    {{-- ADMIN / TEAM LEAD / MANAGER --}}
                    @if(in_array('admin',$user['roles']) || in_array('manager',$user['roles']) || in_array('team lead',$user['roles']))
                        <li>
                            <a href="{{ url('jobs') }}" class="waves-effect">
                                <i class="fa fa-database"></i>
                                <span key="t-jobs">All Jobs</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('permissions') }}" class="waves-effect">
                                <i class="fa fa-calendar"></i>
                                <span key="t-users">Event Calendar</span>
                            </a>
                        </li>
                    @endif

                    {{-- ADMIN ONLY --}}
                    @if(in_array('admin',$user['roles']))
                        <li>
                            <a href="{{ url('clients') }}" class="waves-effect">
                                <i class="fa fa-object-group"></i>
                                <span key="t-clients">Clients</span>
                            </a>
                        </li>
                    @endif

                    {{-- ADMIN / TEAM LEAD / MANAGER --}}
                    @if(in_array('admin',$user['roles']) || in_array('manager',$user['roles']) || in_array('team lead',$user['roles']))
                        <li>
                            <a href="{{ url('users') }}" class="waves-effect">
                                <i class="fa fa-users"></i>
                                <span key="t-users">Users</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa fa-table"></i>
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
                                <i class="fa fa-handshake-o"></i>
                                <span key="t-email">Reallocation</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ url('reallocation/job') }}" key="t-read-email">Reallocate Job</a></li>
                                <li><a href="{{ url('reallocation/qc') }}" key="t-read-email">Reallocate QC</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa fa-cogs"></i>
                                <span key="t-settings">Miscellaneous</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ url('request/types') }}" key="t-read-email">Request Type</a></li>
                                <li><a href="{{ url('request/volumes') }}" key="t-read-email">Request Volume</a></li>
                                <li><a href="{{ url('request/slas') }}" key="t-read-email">Request SLA</a></li>
                                <li><a href="{{ url('configuration') }}" key="t-read-email">Configuration</a></li>
                            </ul>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
