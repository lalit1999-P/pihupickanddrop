<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('/') }}" aria-expanded="false"><i class="me-3 far fa-clock fa-fw"
                            aria-hidden="true"></i><span class="hide-menu">Dashboard</span></a></li>
                @if (auth()->user()->user_type == 1)
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ route('user') }}" aria-expanded="false">
                            <i class="me-3 fa fa-user" aria-hidden="true"></i><span class="hide-menu">Driver
                                Users</span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ route('employee') }}" aria-expanded="false"><i class="me-3 fa fa-table"
                                aria-hidden="true"></i><span class="hide-menu">Employees</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ route('vehicle-model') }}" aria-expanded="false"><i class="me-3 fa fa-car"
                                aria-hidden="true"></i><span class="hide-menu">Vehicle Model</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ route('vehicle-variant') }}" aria-expanded="false"><i class="me-3 fa fa-car"
                                aria-hidden="true"></i><span class="hide-menu">Vehicle Variant</span></a></li>
                @endif
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('serviceorder') }}" aria-expanded="false"><i class="me-3 fa fa-globe"
                            aria-hidden="true"></i><span class="hide-menu">Service Order</span></a></li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
