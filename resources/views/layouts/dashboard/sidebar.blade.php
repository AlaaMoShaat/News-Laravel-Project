  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.home') }}">
          <div class="sidebar-brand-icon">
              <img src="{{ asset($get_setting->logo) }}" alt="" style="max-width: 50px">
          </div>
          <div class="sidebar-brand-text mx-3">{{ env('APP_NAME') }}</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      @can('home')
          <!-- Nav Item - Dashboard -->
          <li class="nav-item active">
              <a class="nav-link" href="{{ route('dashboard.home') }}">
                  <i class="fas fa-fw fa-tachometer-alt"></i>
                  <span>Dashboard</span></a>
          </li>
      @endcan

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
          Interface
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
              aria-expanded="true" aria-controls="collapseTwo">
              <i class="fas fa-fw fa-cog"></i>
              <span>Post Management</span>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Posts Management:</h6>
                  @can('index_posts')
                      <a class="collapse-item" href="{{ route('dashboard.posts.index') }}">Posts</a>
                  @endcan
                  @can('create_posts')
                      <a class="collapse-item" href="{{ route('dashboard.posts.create') }}">Create Post</a>
                  @endcan
              </div>
          </div>
      </li>

      @can('admins')
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#adminManagment"
                  aria-expanded="true" aria-controls="adminManagment">
                  <i class="fas fa-user fa-user"></i>
                  <span>Admins</span>
              </a>
              <div id="adminManagment" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Admins managment:</h6>
                      <a class="collapse-item" href="{{ route('dashboard.admins.index') }}">Admins</a>
                      <a class="collapse-item" href="{{ route('dashboard.admins.create') }}">Add New Admin</a>
                  </div>
              </div>
          </li>
      @endcan

      @can('authorizations')
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#authorizationManagent"
                  aria-expanded="true" aria-controls="authorizationManagent">
                  <i class="fas fa-fw fa-wrench"></i>
                  <span>Authorization</span>
              </a>
              <div id="authorizationManagent" class="collapse" aria-labelledby="headingUtilities"
                  data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Authorization managment:</h6>
                      <a class="collapse-item" href="{{ route('dashboard.authorizations.index') }}">Roles</a>
                      <a class="collapse-item" href="{{ route('dashboard.authorizations.create') }}"> Create Role</a>
                  </div>
              </div>
          </li>
      @endcan

      @can('settings')
          <!-- Nav Item - Utilities Collapse Menu -->
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                  aria-expanded="true" aria-controls="collapseUtilities">
                  <i class="fas fa-fw fa-wrench"></i>
                  <span>Setting</span>
              </a>
              <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                  data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Setting Management:</h6>
                      <a class="collapse-item" href="{{ route('dashboard.settings.index') }}">Setting</a>
                      <a class="collapse-item" href="{{ route('dashboard.related-site.index') }}">Related Sites</a>
                  </div>
              </div>
          </li>
      @endcan

      @can('contacts')
          <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard.contacts.index') }}">
                  <i class="fas fa-fw fa-phone"></i>
                  <span>Contacts</span></a>
          </li>
      @endcan

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
          Addons
      </div>

      @can('users')
          <!-- Nav Item - Pages Collapse Menu -->
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                  aria-expanded="true" aria-controls="collapsePages">
                  <i class="fas fa-fw fa-users"></i>
                  <span>User Management</span>
              </a>
              <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <a class="collapse-item" href="{{ route('dashboard.users.index') }}">Users</a>
                      <a class="collapse-item" href="{{ route('dashboard.users.create') }}">Add User</a>
                      <a class="collapse-item" href="login.html">Delete User</a>
                  </div>
              </div>
          </li>
      @endcan

      <!-- Nav Item - notifications -->
      @can('notifications')
          <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard.notifications.index') }}">
                  <i class="fas fa-bell fa-fw"></i>
                  <span>Notification</span></a>
          </li>
      @endcan

      <!-- Nav Item - Tables -->
      @can('categories')
          <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard.categories.index') }}">
                  <i class="fas fa-fw fa-table"></i>
                  <span>Categories</span></a>
          </li>
      @endcan

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

  </ul>
  <!-- End of Sidebar -->
