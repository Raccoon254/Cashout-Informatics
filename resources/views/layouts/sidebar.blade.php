<div class="drawer sticky h-full lg:drawer-open">
    <input id="my-drawer" type="checkbox" class="drawer-toggle lg:hidden" />
    <div class="drawer-side z-40 lg:block">
        <label for="my-drawer" class="drawer-overlay lg:hidden"></label>
        <section class="menu p-4 flex flex-col z-30 gap-4 mt-16 sm:mt-0 w-56 h-full bg-base-200 text-base-content lg:block">
            <a href="{{ route('dashboard') }}" class="sidebar-item {{ Route::is('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>

            <header class="text-[15px] py-[10px] px-[16px] mx-[16px]">
                PAGES
            </header>

            <!-- Sidebar content here -->
            <a href="{{ route('account.index') }}" class="sidebar-item {{ Route::is('account.index') ? 'active' : '' }}">
                <i class="fa-solid fa-circle-user"></i>
                Account
            </a>

            <a href="{{ route('user.withdrawals') }}" class="sidebar-item {{ Route::is('user.withdrawals') ? 'active' : '' }}">
                <i class="fa-solid fa-coins"></i>
                Withdrawals
            </a>

            <a href="{{ route('notifications.user') }}" class="sidebar-item {{ Route::is('notifications.user') ? 'active' : '' }}">
                <i class="fa-solid fa-bell"></i>
                Notifications
            </a>

            <a class="sidebar-item">
                <i class="fa-solid fa-crosshairs"></i>
                Spin & Win
            </a>
            <a class="sidebar-item">
                <i class="fa-regular fa-circle-play"></i>
                Ad to Cash
            </a>
            <a class="sidebar-item">
                <i class="fa-solid fa-rectangle-ad"></i>
                Advertise
            </a>
            <a href="{{ route('about') }}" class="sidebar-item {{ Route::is('about') ? 'active' : '' }}">
                <i class="fa-regular fa-circle-question"></i>
                About
            </a>

            @can('manage')
                <a class="sidebar-item bg-red-500" href="{{ route('admin') }}">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    Admin Section
                </a>
            @endcan
        </section>

    </div>
</div>
