<div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Quick Acess</div>
                            <a class="nav-link" href="{{route('admins.dashboard', absolute: false)}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                               Home
                            </a>
                           
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                               Employees
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                @can('Add-Employee')
                                    <a class="nav-link"  href="/employee/register">Add Employee</a>
                                    @endcan
                                 @can('list-active-employee')    
                                    <a class="nav-link" href="/employee/list-active">List Active Employees</a>
                                @endcan
                                @can('list-deleted-employee')   
                                    <a class="nav-link" href="/employee/list-deleted">List Deleted Employees</a>
                                @endcan  
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseImports" aria-expanded="false" aria-controls="collapseImports">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                     Purchase Orders
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseImports" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                @can('import-excel')
                                    <a class="nav-link"  href="{{route('import')}}">Import Excel</a>
                                @endcan
                                @can('list-imported-batch')   
                                    <a class="nav-link" href="{{route('orders.listImportedOrders')}}">List Imported Batch</a>
                                @endcan
                                @can('list-send-batch')
                                    <a class="nav-link" href="{{route('orders.listOrderedOrders')}}">List Sent Batch</a>
                                 @endcan 
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSuppliers" aria-expanded="false" aria-controls="collapseImports">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Suppliers
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseSuppliers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    @can('Add-Supplier')
                                    <a class="nav-link"  href="{{route('suppliers.create_supplier')}}">Add Supplier</a>
                                    @endcan
                                    @can('list-active-supplier')
                                    <a class="nav-link" href="{{route('suppliers.listActiveSuppliers')}}">List Active Suppliers</a>
                                    @endcan
                                    @can('list-deleted-supplier')
                                    <a class="nav-link" href="{{route('suppliers.listDeletedSuppliers')}}">List Deleted Suppliers</a>
                                    @endcan
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
                                <div class="sb-nav-link-icon"><i class="fa fa-cog"></i></div>
                                    Settings
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseSettings" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    @can('system-name')
                                        <a class="nav-link"  href="/system-name">System Name</a>
                                    @endcan
                                    @can('view-letter-head')   
                                        <a class="nav-link" href="/business-details">Order Letter Head</a>
                                    @endcan
                                    @can('view-email-content')   
                                        <a class="nav-link" href="{{route('business_details.email_content')}}">Email Content</a>
                                    @endcan
                                    @can('reset-password')   
                                        <a class="nav-link" href="{{route('password.adminEditPassword')}}">Reset Password</a>
                                    @endcan
                                        
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapse_permissions" aria-expanded="false" aria-controls="collapseSettings">
                                <div class="sb-nav-link-icon"><i class="fa fa-cog"></i></div>
                                    Permissions
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapse_permissions" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                @can('create-role')
                                 <a class="nav-link" href="{{route('r_p.createRoles')}}">Create Roles</a>
                                @endcan
                                @can('list-role')
                                    <a class="nav-link"  href="{{route('r_p.listRoles')}}">List Roles</a>
                                 @endcan
                                      
                                    <a class="nav-link" href="{{route('r_p.createpermission')}}">Create Permission</a>
                                </nav>
                            </div>
                            <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                 Employees
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                       Add Users
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                                   
                                            <a class="nav-link" href="#">Add and submit</a>
                                            <a class="nav-link" href="#">Add and readd</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link" href="/display/users">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                               View users
                            </a>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div> -->
                            <!-- <div class="sb-sidenav-menu-heading">Addons</div> -->
                            <!-- <a class="nav-link" href="charts.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a> -->
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                       @php
                        use Illuminate\Support\Facades\Auth;

                        $user = Auth::user();
                       
                        @endphp
                       {{$user['first_name']. ' '.$user['last_name']}}
                    </div>
                </nav>
            </div>