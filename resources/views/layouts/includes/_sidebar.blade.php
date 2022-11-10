<nav class="sidebar">
    <div class="sidebar-header">
       <a href="{{ route('dashboard') }}" class="sidebar-brand" style="font-size: 20px">
       Root<span>Stream</span>
       </a>
       <div class="sidebar-toggler not-active">
          <span></span>
          <span></span>
          <span></span>
       </div>
    </div>
    <div class="sidebar-body">
       <ul class="nav">
         
          <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
             <a href="{{ route('dashboard') }}" class="nav-link">
               <i class="link-icon" data-feather="box"></i>
               <span class="link-title">Dashboard</span>
             </a>
          </li>

          @if (Auth::user()->hasPermissionTo('sports_type.access'))

               <li class="nav-item nav-category">Live Control</li>

               <li class="nav-item {{ request()->routeIs('sports_types*') ? 'active' : '' }}">
                  <a href="{{ route('sports_types.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="layers"></i>
                    <span class="link-title">Sports Types</span>
                  </a>
               </li>
               
          @endif

          @if (Auth::user()->hasPermissionTo('app.access'))

               <li class="nav-item nav-category">App</li>

               <li class="nav-item {{ request()->routeIs('apps*') ? 'active' : '' }}">
                  <a class="nav-link" data-bs-toggle="collapse" href="#apps" role="button" aria-expanded="{{ request()->routeIs('apps*') ? 'true' : 'false' }}" aria-controls="apps">
                  {{-- <i class="link-icon" data-feather="apps"></i> --}}
                  <i class="link-icon fab fa-app-store-ios"></i>
                  <span class="link-title">Apps</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse {{ request()->routeIs('apps*') ? 'show' : '' }}" id="apps">
                     <ul class="nav sub-menu">
                        <li class="nav-item">
                           <a href="{{ route('apps.index') }}" class="nav-link {{ request()->routeIs('apps.index') ? 'active' : '' }}">
                              App List
                           </a>
                        </li>
                        <li class="nav-item">
                           <a href="{{ route('apps.create') }}" class="nav-link {{ request()->routeIs('apps.create') ? 'active' : '' }}">
                              Add App
                           </a>
                        </li>
                     </ul>
                  </div>
               </li>
               
          @endif

          @if (Auth::user()->hasAnyPermission(['permission.access', 'role.access']))

               <li class="nav-item nav-category">Role & Permission</li>

               @if (Auth::user()->hasPermissionTo('permission.access'))

                     <li class="nav-item {{ request()->routeIs('permissions*') ? 'active' : '' }}">
                        <a class="nav-link" data-bs-toggle="collapse" href="#permissions" role="button" aria-expanded="{{ request()->routeIs('permissions*') ? 'true' : 'false' }}" aria-controls="permissions">
                        <i class="link-icon" data-feather="shield"></i>
                        <span class="link-title">Permissions</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('permissions*') ? 'show' : '' }}" id="permissions">
                           <ul class="nav sub-menu">
                              <li class="nav-item">
                                 <a href="{{ route('permissions.index') }}" class="nav-link {{ request()->routeIs('permissions.index') ? 'active' : '' }}">
                                 Permission List
                              </a>
                              </li>
                              <li class="nav-item">
                                 <a href="{{ route('permissions.create') }}" class="nav-link {{ request()->routeIs('permissions.create') ? 'active' : '' }}">
                                 Add Permission
                              </a>
                              </li>
                           </ul>
                        </div>
                     </li>

               @endif

               @if (Auth::user()->hasPermissionTo('role.access'))

                     <li class="nav-item {{ request()->routeIs('roles*') ? 'active' : '' }}">
                        <a class="nav-link" data-bs-toggle="collapse" href="#roles" role="button" aria-expanded="{{ request()->routeIs('roles*') ? 'true' : 'false' }}" aria-controls="roles">
                        <i class="link-icon" data-feather="users"></i>
                        <span class="link-title">Roles</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('roles*') ? 'show' : '' }}" id="roles">
                           <ul class="nav sub-menu">
                              <li class="nav-item">
                                 <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                                 Role List
                              </a>
                              </li>
                              <li class="nav-item">
                                 <a href="{{ route('roles.create') }}" class="nav-link {{ request()->routeIs('roles.create') ? 'active' : '' }}">
                                 Add Role
                              </a>
                              </li>
                           </ul>
                        </div>
                     </li>
                     
               @endif

          @endif

          @if (Auth::user()->hasPermissionTo('admin.access'))

               <li class="nav-item nav-category">Admin</li>

               <li class="nav-item {{ request()->routeIs('admins*') ? 'active' : '' }}">
                  <a class="nav-link" data-bs-toggle="collapse" href="#admins" role="button" aria-expanded="{{ request()->routeIs('admins*') ? 'true' : 'false' }}" aria-controls="admins">
                  <i class="link-icon" data-feather="user"></i>
                  <span class="link-title">Admins</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse {{ request()->routeIs('admins*') ? 'show' : '' }}" id="admins">
                     <ul class="nav sub-menu">
                        <li class="nav-item">
                           <a href="{{ route('admins.index') }}" class="nav-link {{ request()->routeIs('admins.index') ? 'active' : '' }}">
                              Admin List
                           </a>
                        </li>
                        <li class="nav-item">
                           <a href="{{ route('admins.create') }}" class="nav-link {{ request()->routeIs('admins.create') ? 'active' : '' }}">
                              Add Admin
                           </a>
                        </li>
                     </ul>
                  </div>
               </li>

          @endif
          
       </ul>
    </div>
</nav>