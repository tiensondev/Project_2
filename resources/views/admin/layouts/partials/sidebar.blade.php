<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="{{ url('/admin') }}" class="brand-link">
      <!--begin::Brand Image-->
      <img
        src="{{ asset('dist/assets/img/AdminLTELogo.png') }}"
        alt="AdminLTE Logo"
        class="brand-image opacity-75 shadow" />
      <!--end::Brand Image-->
      <!--begin::Brand Text-->
      <span class="brand-text fw-light font-fira">LAPTOPTECH</span>
      <!--end::Brand Text-->
    </a>
    <!--end::Brand Link-->
  </div>
  <!--end::Sidebar Brand-->
  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false">
        <li class="nav-item menu-open">
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <i class="nav-icon bi bi-speedometer2"></i>
                <p>Dashboard</p>
              </a>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('admin.orders.index') }}" class="nav-link">
                <i class="nav-icon bi bi-cart-check"></i>
                <p>Orders</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('admin.brands.index') }}" class="nav-link">
                <i class="nav-icon bi bi-award"></i>
                <p>Brands</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.categories.list') }}" class="nav-link">
                <i class="nav-icon bi bi-grid"></i>
                <p>Categories</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.products.list') }}" class="nav-link">
                <i class="nav-icon bi bi-box-seam"></i>
                <p>Products</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.users.index') }}" class="nav-link">
                <i class="nav-icon bi bi-people"></i>
                <p>Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.product-details.index') }}" class="nav-link">
                <i class="nav-icon bi bi-info-circle"></i>
                <p>Product Details</p>
              </a>
            </li>
          </ul>
          <!--end::Sidebar Menu-->
          <hr>
          <div class="sidebar-footer">
            <a href="{{ route('home') }}" class="d-flex align-items-center justify-content-center text-decoration-none">
              <i class="icon-arrow-left"></i> <span>Back to Customer</span>
            </a>
          </div>
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>