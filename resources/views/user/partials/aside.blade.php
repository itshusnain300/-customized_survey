  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link " href="{{ route('user.dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link " href="{{ route('user.vendor.index') }}">
          <i class="bi bi-grid"></i>
          <span>Vendors</span>
        </a>
      </li>

      {{-- <li class="nav-item">
        <a class="nav-link " href="{{ route('user.question.index') }}">
          <i class="bi bi-grid"></i>
          <span>Manage Questions</span>
        </a>
      </li> --}}

    </ul>

  </aside>