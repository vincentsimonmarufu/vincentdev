 <!--start sidebar -->
 <aside class="sidebar-wrapper" data-simplebar="true">
     <div class="sidebar-header">
         <div>
             <img src="{{ asset('assets/img/logo.jpg') }}" class="logo-icon" alt="logo icon">
         </div>
         <div>
             <h4 class="logo-text">Abisiniya</h4>
         </div>
         <div class="toggle-icon ms-auto">
             <ion-icon name="menu-sharp"></ion-icon>
         </div>
     </div>
     <!--navigation-->
     @if (Auth::user())

         <ul class="metismenu" id="menu">
             <li>
                 <a href="{{ route('home') }}">
                     <div class="parent-icon">
                         <i class="fas fa-home"></i>
                     </div>
                     <div class="menu-title">Dashboard</div>
                 </a>
             </li>
             <hr class="sidebar-divider">
             @if (auth()->user()->role == 'admin')
                 <li>
                     <a href="javascript:;" class="has-arrow">
                         <div class="parent-icon">
                             <i class="fas fa-users"></i>
                         </div>
                         <div class="menu-title">Users</div>
                     </a>
                     <ul>
                         <li> <a class="collapse-item" href="{{ route('users.index') }}">All users</a>
                         </li>
                         <li><a class="collapse-item" href="{{ route('users.type', 'property') }}">Property Owners</a>
                         </li>
                         <li> <a class="collapse-item" href="{{ route('users.type', 'vehicle') }}">Vehicle Owners</a>
                         </li>
                         <li> <a class="collapse-item" href="{{ route('users.type', 'bus') }}">Bus Owners</a>
                         </li>
                         <li> <a class="collapse-item" href="{{ route('users.type', 'shuttle') }}">Airport Shuttle
                                 Owners</a>
                         </li>
                     </ul>
                 </li>

                 <li>
                     <a href="javascript:;" class="has-arrow">
                         <div class="parent-icon">
                             <i class="fas fa-users"></i>
                         </div>
                         <div class="menu-title">Roles</div>
                     </a>
                     <ul>
                         <li> <a class="collapse-item" href="{{ route('roles.index') }}">All Roles</a>
                         </li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript:;" class="has-arrow">
                         <div class="parent-icon">
                             <i class="fas fa-users"></i>
                         </div>
                         <div class="menu-title">Permissions</div>
                     </a>
                     <ul>
                         <li> <a class="collapse-item" href="{{ route('permissions.index') }}">All Permissions</a>
                         </li>
                     </ul>
                 </li>

                 <li>
                     <a href="{{ route('bookings.index') }}">
                         <div class="parent-icon">
                             <i class="fas fa-bookmark"></i>
                         </div>
                         <div class="menu-title">Bookings</div>
                     </a>
                 </li>

                 <li>
                     <a href="javascript:;" class="has-arrow">
                         <div class="parent-icon">
                             <i class="fas fa-duotone fa-credit-card"></i>
                         </div>
                         <div class="menu-title">Invoices & Payments</div>
                     </a>
                     <ul>
                         <li> <a class="collapse-item" href="{{ route('request.payment') }}">Request Payment</a>
                         </li>
                         <li><a class="collapse-item" href="{{ route('itn') }}">ITN</a>
                         </li>
                         <li><a class="collapse-item" href="{{ route('payments') }}">Booking Commision</a>
                         </li>
                         <!--<li><a class="collapse-item" href="{{ route('invoices') }}">Invoices</a>
            </li>-->
                     </ul>
                 </li>
                 <li>
                     <a href="javascript:;" class="has-arrow">
                         <div class="parent-icon">
                             <i class="fas fa-plane"></i>
                         </div>
                         <div class="menu-title">Flights</div>
                     </a>
                     <ul>
                         <li> <a class="collapse-item" href="{{ route('my.flights') }}">Flights Bookings</a>
                         </li>
                         <li><a class="collapse-item" href="{{ route('flightrequests.index') }}">Flight Requests</a>
                         </li>
                     </ul>
                 </li>
                 <li>
                     <a href="{{ route('shuttles.index') }}">
                         <div class="parent-icon">
                             <i class="fas fa-plane"></i>
                         </div>
                         <div class="menu-title">Airport Shuttle</div>
                     </a>
                 </li>
                 <!--<li>-->
                 <!--  <a href="{{ route('flightrequests.index') }}">-->
                 <!--    <div class="parent-icon">-->
                 <!--      <i class="fas fa-plane"></i>-->
                 <!--    </div>-->
                 <!--    <div class="menu-title">Flight Requests</div>-->
                 <!--  </a>-->
                 <!--</li>-->
                 <li>
                     <a href="javascript:;" class="has-arrow">
                         <div class="parent-icon">
                             <i class="fas fa-taxi"></i>
                         </div>
                         <div class="menu-title">Vehicles & Buses</div>
                     </a>
                     <ul>
                         <li> <a class="collapse-item" href="{{ route('vehicles.index') }}">Vehicles</a>
                         </li>
                         <li><a class="collapse-item" href="{{ route('buses.index') }}">Buses</a>
                         </li>
                         <li><a class="collapse-item" href="{{ route('shuttles.index') }}">Airport Shuttle</a>
                         </li>
                     </ul>
                 </li>

                 <li>
                     <a href="javascript:;" class="has-arrow">
                         <div class="parent-icon">
                             <i class="fas fa-building"></i>
                         </div>
                         <div class="menu-title">Properties</div>
                     </a>
                     <ul>
                         <li> <a class="collapse-item" href="{{ route('apartments.index') }}">Properties</a>
                         </li>
                         <li><a class="collapse-item" href="{{ route('property_types.index') }}">Property Types</a>
                         </li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript:;" class="has-arrow">
                         <div class="parent-icon">
                             <i class="fas fa-newspaper"></i>
                         </div>
                         <div class="menu-title">Newsletter</div>
                     </a>
                     <ul>
                         <li> <a class="collapse-item" href="{{ route('newsletters.index') }}">All subscribers</a>
                         </li>
                         <li><a class="collapse-item" href="{{ route('newsletters.create') }}">Create Newsletter</a>
                         </li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript:;" class="has-arrow">
                         <div class="parent-icon">
                             <i class="fas fa-fw fa-tachometer-alt"></i>
                         </div>
                         <div class="menu-title">Announcement</div>
                     </a>
                     <ul>
                         <li> <a class="collapse-item" href="{{ route('announcements.create') }}">Email</a>
                         </li>
                         <li> <a class="collapse-item" href="{{ route('announcements.sms') }}">SMS</a>
                         </li>
                     </ul>
                 </li>
                 <li>
                     <a href="javascript:void(0);" class="has-arrow">
                         <div class="parent-icon">
                             <i class="fas fa-comment"></i>
                         </div>
                         <div class="menu-title">Contact Info</div>
                     </a>
                     <ul>
                         <li> <a class="collapse-item" href="{{ route('contactinfo.index') }}">Details</a>
                         </li>
                     </ul>
                 </li>
             @else
                 <li>
                     <a href="{{ route('users.bookings.index', auth()->user()->id) }}">
                         <div class="parent-icon">
                             <i class="fas fa-bookmark"></i>
                         </div>
                         <div class="menu-title">My Bookings</div>
                     </a>
                 </li>
                 <li>
                     <a href="{{ route('payments') }}">
                         <div class="parent-icon">
                             <i class="fas fa-fw fa-tachometer-alt"></i>
                         </div>
                         <div class="menu-title">Booking Commision</div>
                     </a>
                 </li>
                 <li>
                     <a class="collapse-item" href="{{ route('invoices') }}">
                         <div class="parent-icon">
                             <i class="fas fa-duotone fa-credit-card"></i>
                         </div>
                         <div class="menu-title">Invoices</div>

                     </a>
                 </li>
                 <!-- <li>
       <a href="{{ route('flightrequests.index') }}">
         <div class="parent-icon">
           <i class="fas fa-plane"></i>
         </div>
         <div class="menu-title">My Flight</div>
       </a>
     </li> -->

                 <li>
                     <a href="javascript:;" class="has-arrow">
                         <div class="parent-icon">
                             <i class="fas fa-plane"></i>
                         </div>
                         <div class="menu-title">My Flight</div>
                     </a>
                     <ul>
                         <li> <a class="collapse-item" href="{{ route('my.flights') }}">Flights Bookings</a>
                         </li>
                         <li><a class="collapse-item" href="{{ route('flightrequests.index') }}">Flight Requests</a>
                         </li>
                     </ul>
                 </li>
                 <li>
                     <a href="{{ route('shuttles.index') }}">
                         <div class="parent-icon">
                             <i class="fas fa-plane"></i>
                         </div>
                         <div class="menu-title">Airport Shuttle</div>
                     </a>
                 </li>

                 <li>
                     <a href="{{ route('users.apartments.index', auth()->user()->id) }}">
                         <div class="parent-icon">
                             <i class="fas fa-building"></i>
                         </div>
                         <div class="menu-title">My Apartments</div>
                     </a>
                 </li>

                 <li>
                     <a href="{{ route('users.vehicles.index', auth()->user()->id) }}">
                         <div class="parent-icon">
                             <i class="fas fa-car"></i>
                         </div>
                         <div class="menu-title">My Vehicles</div>
                     </a>
                 </li>
                 <li>
                     <a href="javascript:;" class="has-arrow">
                         <div class="parent-icon">
                             <i class="fas fa-bus"></i>
                         </div>
                         <div class="menu-title">My Buses</div>
                     </a>
                     <ul>

                         <li> <a class="collapse-item"
                                 href="{{ route('users.bus.index', auth()->user()->id) }}">Buses</a>
                         </li>
                         <li><a class="collapse-item" href="{{ route('buses.busstops') }}">Bus Stops/ Locations</a>
                         </li>
                         <li><a class="collapse-item" href="{{ route('buses.routelist') }}">Bus Routes</a>
                         </li>
                         <li><a class="collapse-item" href="{{ route('buses.ridelist') }}">Rides</a>
                         </li>
                         <li><a class="collapse-item" href="{{-- route('buses.busbooking') --}}">Booking</a>
                         </li>

                     </ul>
                 </li>
                 <li>
                     <a href="{{ route('users.shuttle.index', auth()->user()->id) }}">
                         <div class="parent-icon">
                             <i class="fas fa-taxi"></i>
                         </div>
                         <div class="menu-title">My Shuttle</div>
                     </a>
                 </li>
             @endif



         </ul>
     @else
     @endif
     <!--end navigation-->
 </aside>
 <!--end sidebar -->
 <!-- Sidebar -->

 <!-- End of Sidebar -->
