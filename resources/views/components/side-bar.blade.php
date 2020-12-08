<aside class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="{{ asset('user.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-1" style="opacity: .8">
    <div class="brand-text font-weight-light"><strong>SEO</strong> <small>Catalog</small></div>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ Auth::user()->image ? asset("storage/avatar/".Auth::user()->username) : asset('user.png') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block text-wrap">{{ \Illuminate\Support\Facades\Auth::user()->username }}</a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="nav-icon fa fa-home"></i>
            <p>
              Home
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('user.index') }}" class="nav-link {{ request()->is(['user', 'user/*']) ? 'active' : '' }}">
            <i class="nav-icon fa fa-home"></i>
            <p>
              User
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('location.index') }}" class="nav-link {{ request()->is(['location', 'location/*']) ? 'active' : '' }}">
            <i class="nav-icon fa fa-home"></i>
            <p>
              Location
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('room.index') }}" class="nav-link {{ request()->is(['room', 'room/*']) ? 'active' : '' }}">
            <i class="nav-icon fa fa-home"></i>
            <p>
              Room
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link">
            <i class="nav-icon fas fa-power-off"></i>
            <p>
              Logout
            </p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
