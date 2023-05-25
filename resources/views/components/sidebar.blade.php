<div class="main-sidebar sidebar-style-2 d-print-none">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
             <a href="{{route("home")}}"> {{--<img alt="image" src="{{asset('assets/img/logo.png')}}" class="header-logo" /> --}}
                <span class="logo-name">Joaillerie</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown active">
                <a href="{{route("home")}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Inventory</li>
            <li><a class="nav-link" href="{{route('products.index')}}"><i data-feather="shopping-bag"></i><span>Products</span></a></li>
            <li><a class="nav-link" href="{{route('customers.index')}}"><i data-feather="target"></i><span>Customers</span></a></li>
            @can('isManager')
                <li><a class="nav-link" href="{{route('suppliers.index')}}"><i data-feather="truck"></i><span>Suppliers</span></a></li>
                <li><a class="nav-link" href="{{route('product_categories.index')}}"><i data-feather="tag"></i><span>Categories</span></a></li>
                <li><a class="nav-link" href="{{route('transfers.index')}}"><i data-feather="send"></i><span>Transfer Requests</span></a></li>
                <li class="menu-header">Management</li>
                <li class="dropdown">
                    <a href="{{route('branches.index')}}" class="nav-link"><i data-feather="grid"></i><span>Branches</span></a>
                </li>
                <li class="dropdown">
                    <a href="{{route('employees.index')}}" class="nav-link"><i data-feather="briefcase"></i><span>Employees</span></a>
                </li>
            @endcan
            
            
            <li class="menu-header">Financials</li>
            <li><a class="nav-link" href="{{route('orders.index')}}"><i data-feather="shopping-cart"></i><span>Orders</span></a></li>
            {{-- <li><a class="nav-link" href="#"><i data-feather="file-text"></i><span>Invoices</span></a></li> --}}
            <li><a class="nav-link" href="{{route('returns.index')}}"><i data-feather="refresh-cw"></i><span>Returns & Exchanges</span></a></li>
            @can('isManager')
                <li><a class="nav-link" href="{{route('paymentMethods.index')}}"><i data-feather="credit-card"></i><span>Payment Methods</span></a></li>
                <li><a class="nav-link" href="{{route('currencies.index')}}"><i data-feather="dollar-sign"></i><span>Currencies</span></a></li>
                <li class="menu-header">Services</li>
                {{-- <li><a class="nav-link" href="#"><i data-feather="gift"></i><span>Special Requests</span></a></li> --}}
                <li><a class="nav-link" href="{{route('restorations.index')}}"><i data-feather="activity"></i><span>Maintenance Requests</span></a></li>
                <li class="menu-header">System</li>
                <li><a class="nav-link" href="{{route('users.index')}}"><i data-feather="users"></i><span>Users</span></a></li>
                {{-- <li><a class="nav-link" href="timeline.html"><i data-feather="eye"></i><span>Roles</span></a></li>
                <li><a class="nav-link" href="timeline.html"><i data-feather="bar-chart"></i><span>Reports</span></a></li> --}}
                <li><a class="nav-link" href="#"><i data-feather="settings"></i><span>Settings</span></a></li>
            @endcan
        </ul>
    </aside>
</div>
