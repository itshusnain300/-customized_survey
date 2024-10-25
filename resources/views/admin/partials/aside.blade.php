  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link " href="{{ route('admin.dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link " href="{{ route('admin.vendor.index') }}">
          <i class="bi bi-grid"></i>
          <span>Vendors</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="{{ route('admin.question.index') }}">
          <i class="bi bi-grid"></i>
          <span>Manage Questions</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link " href="{{ route('admin.user.index') }}">
          <i class="bi bi-grid"></i>
          <span>Manage Users</span>
        </a>
      </li>

    </ul>

  </aside>