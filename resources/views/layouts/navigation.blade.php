<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <img class="img-circle elevation-2" alt="User Image" src="{{ asset('storage/user_images/default.png') }}" >
        <div class="info ">
            <a href="#" class="d-block">{{ ucwords(Auth::user()->firstname.' '.Auth::user()->lastname) }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    @if(Auth::user()->position_dtls->user_level == 1 || Auth::user()->position_dtls->user_level == 2 || Auth::user()->position_dtls->user_level == 0)
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            {{ __('Dashboard') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>
                            Purchase Request
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                   
                    <ul class="nav nav-treeview" style="display: none;">
                        @if(Auth::user()->position_dtls->user_level >= 2)
                            <li class="nav-item">
                                <a href="{{ route('requisition.index') }}" class="nav-link">
                                    <i class="fas fa-hand-holding-heart nav-icon"></i>
                                    <p>Create PR</p>
                                </a>
                            </li>
                        
                       @endif
                        <li class="nav-item">
                            <a href="{{ route('manage.purchase.request.index') }}" class="nav-link">
                                <i class="fas fa-list-alt nav-icon"></i>
                                <p>List of PR</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('approve.index') }}" class="nav-link">
                                <i class="fas fa-list-alt nav-icon"></i>
                                <p>Approve PR</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-box-open nav-icon"></i>
                        <p>
                            Manage Item
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('index.manage.item') }}" class="nav-link">
                                <i class="fas fa-th-list nav-icon"></i>
                                <p>Item List</p>
                            </a>
                        </li>
                    </ul>
                </li>
        @if(Auth::user()->position_dtls->user_level == 2)
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-users-cog nav-icon"></i>
                        <p>
                            Manage User
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('index.user.list') }}" class="nav-link">
                                <i class="fas fa-th-list nav-icon"></i>
                                <p>User List</p>
                            </a>
                        </li>
                    </ul>
                </li>
        @endif <!-- ADMIN UL 2-->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-archive nav-icon"></i>
                        <p>
                            PPMP
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: none;">
                        <li class="nav-item">
                            <a href="{{ route('index.pmpp') }}" class="nav-link">
                                <i class="fas fa-plus-square nav-icon"></i>
                                <p>Create PMPP</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('manage.logs.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Logs
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    @endif <!-- SUPER ADMIN AND ADMIN UL 1 AND 2-->
    
    <!-- /.sidebar-menu -->

@if(Auth::user()->position_dtls->user_level >= 5)
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Dashboard') }}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>
                        Purchase Request
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{ route('requisition.index') }}" class="nav-link">
                            <i class="fas fa-hand-holding-heart nav-icon"></i>
                            <p>Create PR</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('manage.purchase.request.index') }}" class="nav-link">
                            <i class="fas fa-list-alt nav-icon"></i>
                            <p>List of PR</p>
                        </a>
                    </li>
                    {{-- @if(Auth::user()->position_dtls->user_level == 5) --}}
                        <li class="nav-item">
                            <a href="{{ route('approve.index') }}" class="nav-link">
                                <i class="fas fa-list-alt nav-icon"></i>
                                <p>Approve PR</p>
                            </a>
                        </li>
                    {{-- @endif --}}
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('manage.logs.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        Logs
                    </p>
                </a>
            </li>
           
            
        </ul>
    </nav>
@endif <!-- DEPT HEAD UL 5-->


    @if(Auth::user()->position_dtls->user_level == 4)
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Dashboard') }}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>
                        Purchase Request
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{ route('requisition.index') }}" class="nav-link">
                            <i class="fas fa-hand-holding-heart nav-icon"></i>
                            <p>Create PR</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('manage.purchase.request.index') }}" class="nav-link">
                            <i class="fas fa-list-alt nav-icon"></i>
                            <p>List of PR</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('approve.index') }}" class="nav-link">
                            <i class="fas fa-list-alt nav-icon"></i>
                            <p>Approve PR</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-archive nav-icon"></i>
                    <p>
                        PPMP
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{ route('index.pmpp') }}" class="nav-link">
                            <i class="fas fa-plus-square nav-icon"></i>
                            <p>Create PPMP</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('manage.logs.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        Logs
                    </p>
                </a>
            </li>
        </ul>
    </nav>
@endif <!-- BUDGET OFFICER UL 4-->

</div>
<!-- /.sidebar -->