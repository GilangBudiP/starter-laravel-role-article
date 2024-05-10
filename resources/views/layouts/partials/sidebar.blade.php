<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand my-3 demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <div class="app-brand justify-content-center">
                <a href="{{ route('admin.dashboard') }}" class="app-brand-link gap-2">
                    <img src="{{ asset('admin/img/logo/all-property.png') }}" alt=""
                        style="width: 100%; height: 50px;">
                </a>
            </div>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ strpos(Route::currentRouteName(), 'admin.dashboard') === 0 ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        @can('articles.*','categories.*')
        <li class="menu-item {{ strpos(Route::currentRouteName(), 'admin.articles') === 0 || strpos(Route::currentRouteName(), 'admin.categories') === 0 ? 'active open' : '' }}"
            style="">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-news"></i>
                <div data-i18n="Artikel">Artikel
                </div>
            </a>
            <ul class="menu-sub">
                @can('articles.read')
                <li class="menu-item {{ strpos(Route::currentRouteName(), 'admin.articles') === 0 ? 'active' : '' }}">
                    <a href="{{ route('admin.articles.index') }}" class="menu-link">
                        <div data-i18n="Artikel">Artikel</div>
                    </a>
                </li>
                @endcan
                @can('categories.read')
                <li
                    class="menu-item {{ strpos(Route::currentRouteName(), 'admin.categories.index') === 0 ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}" class="menu-link">
                        <div data-i18n="Kategori">Kategori</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('users.*','permissions.*','roles.*')
        <li class="menu-item {{ strpos(Route::currentRouteName(), 'admin.roles') === 0 || strpos(Route::currentRouteName(), 'admin.permissions') === 0 || strpos(Route::currentRouteName(), 'admin.users') === 0 ? 'active open' : '' }}"
            style="">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-check-shield"></i>
                <div data-i18n="Roles &amp; Permissions">Users Management
                </div>
            </a>
            <ul class="menu-sub">
                @can('roles.read')
                <li
                    class="menu-item {{ strpos(Route::currentRouteName(), 'admin.roles') === 0 || strpos(Route::currentRouteName(), 'admin.users') === 0 ? 'active' : '' }}">
                    <a href="{{ route('admin.roles.index') }}" class="menu-link">
                        <div data-i18n="Roles">Users &amp; Roles Management</div>
                    </a>
                </li>
                @endcan
                @can('permissions.read')
                <li
                    class="menu-item {{ strpos(Route::currentRouteName(), 'admin.permissions.index') === 0 ? 'active' : '' }}">
                    <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                        <div data-i18n="Permission">Permission</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('galleries.read')
        <li class="menu-item {{ strpos(Route::currentRouteName(), 'admin.galleries') === 0 ? 'active' : '' }}">
            <a href="{{ route('admin.galleries.index') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-image-add'></i>
                <div data-i18n="Galleries">Gallery</div>
            </a>
        </li>
        @endcan
    </ul>
</aside>
