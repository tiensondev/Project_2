<nav class="app-header navbar navbar-expand bg-body">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::End Navbar Links-->
    <ul class="navbar-nav ms-auto">
      <!--begin::User Menu Dropdown-->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img
            src="{{ Auth::user()->avatar ? asset('uploads/' . Auth::user()->avatar) : asset('dist/assets/img/user2-160x160.jpg') }}"
            class="user-image rounded-circle shadow"
            alt="User Image" />
          <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <!--begin::User Image-->
          <li class="user-header text-bg-primary">
            <img
              src="{{ Auth::user()->avatar ? asset('uploads/' . Auth::user()->avatar) : asset('dist/assets/img/user2-160x160.jpg') }}"
              class="rounded-circle shadow"
              alt="User Image" />
            <p>
              {{ Auth::user()->name }} - {{ ucfirst(Auth::user()->role) }}
              <small>{{ Auth::user()->email }}</small>
            </p>
          </li>
          <!--end::User Image-->
          <li class="user-body">
            <div class="container-fluid">
              <div class="row border-bottom py-2">
                <div class="col-5 text-muted"><strong>Phone:</strong></div>
                <div class="col-7 text-end">
                  <a href="tel:{{ Auth::user()->phone }}" class="text-decoration-none">{{ Auth::user()->phone ?? 'Chưa cập nhật' }}</a>
                </div>
              </div>
              <div class="row py-2">
                <div class="col-5 text-muted"><strong>Role:</strong></div>
                <div class="col-7 text-end">
                  <span class="text-decoration-none">{{ Auth::user()->role }}</span>
                </div>
              </div>
            </div>
          </li>
          <!--end::Menu Body-->
          <!--begin::Menu Footer-->
          <li class="user-footer">
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-default btn-flat">Logout</button>
            </form>
          </li>
          <!--end::Menu Footer-->
        </ul>
      </li>
      <!--end::User Menu Dropdown-->
    </ul>
    <!--end::End Navbar Links-->
  </div>
  <!--end::Container-->
</nav>
<script>
  const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
  const Default = {
    scrollbarTheme: 'os-theme-light',
    scrollbarAutoHide: 'leave',
    scrollbarClickScroll: true,
  };
</script>