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
               <i class="link-icon fas fa-tachometer-alt"></i>
               <span class="link-title">Dashboard</span>
             </a>
          </li>

          <li class="nav-item">
             <a href="{{ route('cache_clear') }}" class="nav-link">
               <i class="link-icon fas fa-trash"></i>
               <span class="link-title">Cache Clean</span>
             </a>
          </li>

          @if (Auth::user()->hasAnyPermission(['sports_type.access', 'live_match.access']))

               <li class="nav-item nav-category">Live Control</li>

               @if (Auth::user()->hasPermissionTo('sports_type.access'))

                  <li class="nav-item {{ request()->routeIs('sports_types*') ? 'active' : '' }}">
                     <a href="{{ route('sports_types.index') }}" class="nav-link">
                     <i class="link-icon fas fa-layer-group"></i>
                     <span class="link-title">Sports Types</span>
                     </a>
                  </li>

               @endif

               @if (Auth::user()->hasPermissionTo('live_match.access'))

                  <li class="nav-item {{ request()->routeIs('live_matches*') ? 'active' : '' }}">
                     <a class="nav-link" data-bs-toggle="collapse" href="#live_matches" role="button" aria-expanded="{{ request()->routeIs('live_matches*') ? 'true' : 'false' }}" aria-controls="live_matches">
                     <i class="link-icon fas fa-desktop"></i>
                     <span class="link-title">Live Matches</span>
                     <i class="link-arrow" data-feather="chevron-down"></i>
                     </a>
                     <div class="collapse {{ request()->routeIs('live_matches*') ? 'show' : '' }}" id="live_matches">
                        <ul class="nav sub-menu">
                           <li class="nav-item">
                              <a href="{{ route('live_matches.index') }}" class="nav-link {{ request()->routeIs('live_matches.index') ? 'active' : '' }}">
                                 Live Match List
                              </a>
                           </li>
                           <li class="nav-item">
                              <a href="{{ route('live_matches.create') }}" class="nav-link {{ request()->routeIs('live_matches.create') ? 'active' : '' }}">
                                 Add Live Match
                              </a>
                           </li>
                        </ul>
                     </div>
                  </li>

               @endif

          @endif

          @if (Auth::user()->hasAnyPermission(['popular_series.access', 'highlight.access']))

               <li class="nav-item nav-category">Popular Stream</li>

               @if (Auth::user()->hasPermissionTo('popular_series.access'))


                     <li class="nav-item {{ request()->routeIs('popular_series*') ? 'active' : '' }}">
                        <a class="nav-link" data-bs-toggle="collapse" href="#popular_series" role="button" aria-expanded="{{ request()->routeIs('popular_series*') ? 'true' : 'false' }}" aria-controls="popular_series">
                        <i class="link-icon fas fa-file-video"></i>
                        <span class="link-title">Popular Series</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('popular_series*') ? 'show' : '' }}" id="popular_series">
                           <ul class="nav sub-menu">
                              <li class="nav-item">
                                 <a href="{{ route('popular_series.index') }}" class="nav-link {{ request()->routeIs('popular_series.index') ? 'active' : '' }}">
                                    Popular Series List
                                 </a>
                              </li>
                              <li class="nav-item">
                                 <a href="{{ route('popular_series.create') }}" class="nav-link {{ request()->routeIs('popular_series.create') ? 'active' : '' }}">
                                    Add Popular Series
                                 </a>
                              </li>
                           </ul>
                        </div>
                     </li>
               
               @endif

               @if (Auth::user()->hasPermissionTo('highlight.access'))

                     <li class="nav-item {{ request()->routeIs('highlights*') ? 'active' : '' }}">
                        <a class="nav-link" data-bs-toggle="collapse" href="#highlights" role="button" aria-expanded="{{ request()->routeIs('highlights*') ? 'true' : 'false' }}" aria-controls="highlights">
                        <i class="link-icon fas fa-file-video"></i>
                        <span class="link-title">Highlights</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs('highlights*') ? 'show' : '' }}" id="highlights">
                           <ul class="nav sub-menu">
                              <li class="nav-item">
                                 <a href="{{ route('highlights.index') }}" class="nav-link {{ request()->routeIs('highlights.index') ? 'active' : '' }}">
                                    Highlight List
                                 </a>
                              </li>
                              <li class="nav-item">
                                 <a href="{{ route('highlights.create') }}" class="nav-link {{ request()->routeIs('highlights.create') ? 'active' : '' }}">
                                    Add Highlight
                                 </a>
                              </li>
                           </ul>
                        </div>
                     </li>
                     
               @endif

          @endif

          @if (Auth::user()->hasPermissionTo('notification.access'))

               <li class="nav-item nav-category">Notification</li>

               <li class="nav-item {{ request()->routeIs('notifications*') ? 'active' : '' }}">
                  <a class="nav-link" data-bs-toggle="collapse" href="#notifications" role="button" aria-expanded="{{ request()->routeIs('notifications*') ? 'true' : 'false' }}" aria-controls="notifications">
                  <i class="link-icon fas fa-bell"></i>
                  <span class="link-title">Notifications</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse {{ request()->routeIs('notifications*') ? 'show' : '' }}" id="notifications">
                     <ul class="nav sub-menu">
                        <li class="nav-item">
                           <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.index') ? 'active' : '' }}">
                           Notification List
                        </a>
                        </li>
                        <li class="nav-item">
                           <a href="{{ route('notifications.create') }}" class="nav-link {{ request()->routeIs('notifications.create') ? 'active' : '' }}">
                           Add Notification
                        </a>
                        </li>
                     </ul>
                  </div>
               </li>

         @endif

         @if (Auth::user()->hasPermissionTo('subscription.access'))

               <li class="nav-item nav-category">Subscription</li>

               @if (Auth::user()->hasPermissionTo('user.access'))

                  <li class="nav-item {{ request()->routeIs('users*') ? 'active' : '' }}">
                     <a href="{{ url('users') }}" class="nav-link">
                        <i class="link-icon fas fa-users"></i>
                        <span class="link-title">Manage Users</span>
                     </a>
                  </li>

               @endif

               @if (Auth::user()->hasPermissionTo('payment.access'))

                  <li class="nav-item {{ request()->routeIs('payments') ? 'active' : '' }}">
                     <a href="{{ url('payments') }}" class="nav-link">
                        <i class="link-icon fas fa-dollar-sign"></i>
                        <span class="link-title">Payments</span>
                     </a>
                  </li>

               @endif

               <li class="nav-item {{ request()->routeIs('subscriptions*') ? 'active' : '' }}">
                  <a class="nav-link" data-bs-toggle="collapse" href="#subscriptions" role="button" aria-expanded="{{ request()->routeIs('subscriptions*') ? 'true' : 'false' }}" aria-controls="subscriptions">
                  <i class="link-icon fas fa-dice-four"></i>
                  <span class="link-title">Subscriptions</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse {{ request()->routeIs('subscriptions*') ? 'show' : '' }}" id="subscriptions">
                     <ul class="nav sub-menu">
                        <li class="nav-item">
                           <a href="{{ route('subscriptions.index') }}" class="nav-link {{ request()->routeIs('subscriptions.index') ? 'active' : '' }}">
                           Subscription List
                        </a>
                        </li>
                        <li class="nav-item">
                           <a href="{{ route('subscriptions.create') }}" class="nav-link {{ request()->routeIs('subscriptions.create') ? 'active' : '' }}">
                           Add Subscription
                        </a>
                        </li>
                     </ul>
                  </div>
               </li>

         @endif

         @if (Auth::user()->hasPermissionTo('app.access'))

               <li class="nav-item nav-category">App</li>

               <li class="nav-item {{ request()->routeIs('manage_app') ? 'active' : '' }}">
                  <a href="{{ route('manage_app') }}" class="nav-link">
                     <i class="link-icon fab fa-google-play"></i>
                     <span class="link-title">Manage Apps</span>
                  </a>
               </li>

               <li class="nav-item {{ request()->routeIs('apps*') ? 'active' : '' }}">
                  <a class="nav-link" data-bs-toggle="collapse" href="#apps" role="button" aria-expanded="{{ request()->routeIs('apps*') ? 'true' : 'false' }}" aria-controls="apps">
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

         @if (Auth::user()->hasPermissionTo('administration.access'))

               <li class="nav-item nav-category">Administration</li>

               <li class="nav-item {{ request()->routeIs('general_settings') ? 'active' : '' }}">
                  <a class="nav-link" data-bs-toggle="collapse" href="#general_settings" role="button" aria-expanded="{{ request()->routeIs('general_settings') ? 'true' : 'false' }}" aria-controls="general_settings">
                  <i class="link-icon fas fa-cogs"></i>
                  <span class="link-title">General Settings</span>
                  <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse {{ request()->routeIs('general_settings') ? 'show' : '' }}" id="general_settings">
                     <ul class="nav sub-menu">
                        <li class="nav-item">
                           <a href="{{ route('general_settings') }}" class="nav-link {{ request()->routeIs('general_settings') ? 'active' : '' }}">
                              General Settings
                           </a>
                        </li>
                        <li class="nav-item">
                           <a href="{{ route('database_backup') }}" class="nav-link">
                              Database Backup
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
                        <i class="link-icon fas fa-shield-alt"></i>
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
                        <i class="link-icon fas fa-users"></i>
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
                  <i class="link-icon 	fas fa-user-tie"></i>
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