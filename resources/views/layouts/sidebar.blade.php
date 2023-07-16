<div class="drawer sticky h-full lg:drawer-open">
    <input id="my-drawer" type="checkbox" class="drawer-toggle lg:hidden" />
    <div class="drawer-side z-40 lg:block">
        <label for="my-drawer" class="drawer-overlay lg:hidden"></label>
        <section class="menu p-4 flex flex-col gap-4 mt-16 sm:mt-0 w-56 h-full bg-base-200 text-base-content lg:block">
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
            <a class="sidebar-item">
                <i class="fa-regular fa-circle-question"></i>
                About
            </a>
        </section>

    </div>
</div>
