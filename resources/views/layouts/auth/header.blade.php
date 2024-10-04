 <!--start top header-->
 <header class="top-header">
   <nav class="navbar navbar-expand gap-3">
     <div class="mobile-menu-button">
       <ion-icon name="menu-sharp"></ion-icon>
     </div>

     <div class="top-navbar-right ms-auto">
       @if (Auth::user())
       <ul class="navbar-nav align-items-center">
         <li class="nav-item">
           <a class="nav-link dark-mode-icon" href="javascript:;">
             <div class="mode-icon">
               <ion-icon name="moon-sharp"></ion-icon>
             </div>
           </a>
         </li>

         <li class="nav-item dropdown dropdown-large">
           <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
             <div class="position-relative">
               @if (count(auth()->user()->unreadNotifications) > 0)
               <span class="notify-badge">{{ count(auth()->user()->unreadNotifications) }}</span>
               @endif
               <ion-icon name="notifications-sharp"></ion-icon>
             </div>
           </a>
           <div class="dropdown-menu dropdown-menu-end">
             <a href="{{ route('read_all') }}">
               <div class="msg-header">
                 <p class="msg-header-title">Notifications</p>
                 <p class="msg-header-clear ms-auto">Marks all as read ({{ count(auth()->user()->unreadNotifications) }} )</p>
               </div>
             </a>
             @php
             $notifications = auth()->user()->notifications;
             @endphp
             <div class="header-notifications-list">
               @foreach ($notifications as $notification)
               <a class="dropdown-item" href="{{ route('notification_read', ['id' => $notification->id]) }}">
                 <div class="d-flex align-items-center">

                   <div class="flex-grow-1">
                     <h6 class="msg-name"> {{ $notification->created_at }}</h6>
                     <p class="msg-info">{{ $notification->data['message'] }}</p>
                   </div>
                 </div>
               </a>
               @if($loop->index == 5)
               @break
               @endif
               @endforeach
             </div>
             <a href="{{ route('notifications') }}">
               <div class="text-center msg-footer">View All Notifications</div>
             </a>
           </div>
         </li>
         <li class="nav-item dropdown dropdown-user-setting">
           <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
             <div class="user-setting">
               <ion-icon name="person-outline" class="user-img"></ion-icon>
             </div>
           </a>
           <ul class="dropdown-menu dropdown-menu-end">
             <li>
               <a class="dropdown-item" href="javascript:;">
                 <div class="d-flex flex-row align-items-center gap-2">                  
                   <div class="">
                     <h6 class="mb-0 dropdown-user-name">{{auth()->user()->name}} {{auth()->user()->surname}}</h6>
                     <small class="mb-0 dropdown-user-designation text-secondary">{{auth()->user()->role}} </small>
                   </div>
                 </div>
               </a>
             </li>
             <li>
               <hr class="dropdown-divider">
             </li>
             <li>
               <a class="dropdown-item" href="{{route('users.profile')}}">
                 <div class="d-flex align-items-center">
                   <div class="">
                     <ion-icon name="person-outline"></ion-icon>
                   </div>
                   <div class="ms-3"><span>Profile</span></div>
                 </div>
               </a>
             </li>
             <li>
               <a class="dropdown-item" href="{{route('home')}}">
                 <div class="d-flex align-items-center">
                   <div class="">
                     <ion-icon name="speedometer-outline"></ion-icon>
                   </div>
                   <div class="ms-3"><span>Dashboard</span></div>
                 </div>
               </a>
             </li>

             <li>
               <hr class="dropdown-divider">
             </li>
             <li>
                  <!-- <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{route('logout')}}" class="dropdown-item text-danger" onclick="event.preventDefault();
                                    this.closest('form').submit();">

                      <div class="">
                        <ion-icon name="log-out-outline"></ion-icon> Logout
                      </div>

                    </a>
                  </form> -->                             
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                    </li>            
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
             </li>
           </ul>
         </li>
       </ul>
       @endif
     </div>
   </nav>
 </header>
 <!--end top header-->