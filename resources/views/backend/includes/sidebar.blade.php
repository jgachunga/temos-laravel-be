<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Route::is('admin/dashboard'))
                }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            @if ($logged_in_user->isAdmin())
                <li class="nav-title">
                    @lang('menus.backend.sidebar.system')
                </li>

                <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/auth*'), 'open')
                }}">
                    <a class="nav-link nav-dropdown-toggle {{
                        active_class(Route::is('admin/auth*'))
                    }}" href="#">
                        <i class="nav-icon far fa-user"></i>
                        @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/user*'))
                            }}" href="{{ route('admin.auth.user.index') }}">
                                @lang('labels.backend.access.users.management')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('clients*') ? 'active' : '' }}">
                            <a class="nav-link" href="{!! route('admin.clients.index') !!}">
                                <i class="nav-icon icon-cursor"></i>
                                <span>Clients</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('distributors*') ? 'active' : '' }}">
                                <a class="nav-link" href="{!! route('admin.distributors.index') !!}">
                                    <i class="nav-icon icon-cursor"></i>
                                    <span>Distributors</span>
                                </a>
                        </li>

                        <li class="nav-item {{ Request::is('salesReps*') ? 'active' : '' }}">
                            <a class="nav-link" href="{!! route('admin.salesReps.index') !!}">
                                <i class="nav-icon icon-cursor"></i>
                                <span>Sales Reps</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('customers*') ? 'active' : '' }}">
                                <a class="nav-link" href="{!! route('admin.customers.index') !!}">
                                    <i class="nav-icon icon-cursor"></i>
                                    <span>Customers</span>
                                </a>
                            </li>
                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/role*'))
                            }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="divider"></li>

                <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/products*'), 'open')
                }}">
                        <a class="nav-link nav-dropdown-toggle{{
                            active_class(Route::is('admin/products*'))
                        }}" href="#">
                        <i class="nav-icon fas fa-list"></i> Products
                    </a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item {{ Request::is('categories*') ? 'active' : '' }}">
                            <a class="nav-link" href="{!! route('admin.categories.index') !!}">
                                <i class="nav-icon icon-cursor"></i>
                                <span>Categories</span>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('products*') ? 'active' : '' }}">
                            <a class="nav-link" href="{!! route('admin.products.index') !!}">
                                <i class="nav-icon icon-cursor"></i>
                                <span>Products</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="divider"></li>

                <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/log-viewer*'), 'open')
                }}">
                        <a class="nav-link nav-dropdown-toggle {{
                            active_class(Route::is('admin/log-viewer*'))
                        }}" href="#">
                        <i class="nav-icon fas fa-list"></i> @lang('menus.backend.log-viewer.main')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/log-viewer'))
                        }}" href="{{ route('log-viewer::dashboard') }}">
                                @lang('menus.backend.log-viewer.dashboard')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{
                            active_class(Route::is('admin/log-viewer/logs*'))
                        }}" href="{{ route('log-viewer::logs.list') }}">
                                @lang('menus.backend.log-viewer.logs')
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->

