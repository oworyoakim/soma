<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <span class="brand-text font-weight-light">SOMA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/images/avatar.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link @if(Request::is(['admin','admin/dashboard'])) active @endif">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>Dashboard <i class="right fas fa-angle-left"></i></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('levels')}}" class="nav-link @if(Request::is(['admin/levels'])) active @endif">
                        <i class="nav-icon fas fa-level-up"></i>
                        <p>Manage Levels <i class="right fas fa-angle-left"></i></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('courses')}}" class="nav-link @if(Request::is(['admin/courses'])) active @endif">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Manage Courses <i class="right fas fa-angle-left"></i></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('users')}}" class="nav-link @if(Request::is(['admin/users'])) active @endif">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Manage Users <i class="right fas fa-angle-left"></i></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('roles')}}" class="nav-link @if(Request::is(['admin/roles'])) active @endif">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>Manage Roles <i class="right fas fa-angle-left"></i></p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
