 <!--start sidebar -->
 <aside class="sidebar-wrapper" data-simplebar="true">
   <div class="sidebar-header">
     <div>
       <img src="<?php echo e(asset('assets/img/logo.jpg')); ?>" class="logo-icon" alt="logo icon">
     </div>
     <div>
       <h4 class="logo-text">Abisiniya</h4>
     </div>
     <div class="toggle-icon ms-auto">
       <ion-icon name="menu-sharp"></ion-icon>
     </div>
   </div>
   <!--navigation-->
   <?php if(Auth::user()): ?>

   <ul class="metismenu" id="menu">
     <li>
       <a href="<?php echo e(route('home')); ?>">
         <div class="parent-icon">
           <i class="fas fa-home"></i>
         </div>
         <div class="menu-title">Dashboard</div>
       </a>
     </li>
     <hr class="sidebar-divider">
     <?php if(auth()->user()->role == 'admin'): ?>
     <li>
       <a href="javascript:;" class="has-arrow">
         <div class="parent-icon">
           <i class="fas fa-users"></i>
         </div>
         <div class="menu-title">Users</div>
       </a>
       <ul>
         <li> <a class="collapse-item" href="<?php echo e(route('users.index')); ?>">All users</a>
         </li>
         <li><a class="collapse-item" href="<?php echo e(route('users.type', 'property')); ?>">Property Owners</a>
         </li>
         <li> <a class="collapse-item" href="<?php echo e(route('users.type', 'vehicle')); ?>">Vehicle Owners</a>
         </li>
         <li> <a class="collapse-item" href="<?php echo e(route('users.type', 'bus')); ?>">Bus Owners</a>
         </li>
         <li> <a class="collapse-item" href="<?php echo e(route('users.type', 'shuttle')); ?>">Airport Shuttle Owners</a>
         </li>
       </ul>
     </li>

     <li>
       <a href="<?php echo e(route('bookings.index')); ?>">
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
         <li> <a class="collapse-item" href="<?php echo e(route('request.payment')); ?>">Request Payment</a>
         </li>
         <li><a class="collapse-item" href="<?php echo e(route('itn')); ?>">ITN</a>
         </li>
         <li><a class="collapse-item" href="<?php echo e(route('payments')); ?>">Booking Commision</a>
         </li>
         <!--<li><a class="collapse-item" href="<?php echo e(route('invoices')); ?>">Invoices</a>
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
         <li> <a class="collapse-item" href="<?php echo e(route('my.flights')); ?>">Flights Bookings</a>
         </li>
         <li><a class="collapse-item" href="<?php echo e(route('flightrequests.index')); ?>">Flight Requests</a></li>
       </ul>
     </li>
     <li>
       <a href="<?php echo e(route('shuttles.index')); ?>">
         <div class="parent-icon">
           <i class="fas fa-plane"></i>
         </div>
         <div class="menu-title">Airport Shuttle</div>
       </a>
     </li>
     <!--<li>-->
     <!--  <a href="<?php echo e(route('flightrequests.index')); ?>">-->
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
         <li> <a class="collapse-item" href="<?php echo e(route('vehicles.index')); ?>">Vehicles</a>
         </li>
         <li><a class="collapse-item" href="<?php echo e(route('buses.index')); ?>">Buses</a>
         </li>
         <li><a class="collapse-item" href="<?php echo e(route('shuttles.index')); ?>">Airport Shuttle</a>
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
         <li> <a class="collapse-item" href="<?php echo e(route('apartments.index')); ?>">Properties</a>
         </li>
         <li><a class="collapse-item" href="<?php echo e(route('property_types.index')); ?>">Property Types</a>
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
         <li> <a class="collapse-item" href="<?php echo e(route('newsletters.index')); ?>">All subscribers</a>
         </li>
         <li><a class="collapse-item" href="<?php echo e(route('newsletters.create')); ?>">Create Newsletter</a>
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
         <li> <a class="collapse-item" href="<?php echo e(route('announcements.create')); ?>">Email</a>
         </li>
         <li> <a class="collapse-item" href="<?php echo e(route('announcements.sms')); ?>">SMS</a>
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
         <li> <a class="collapse-item" href="<?php echo e(route('contactinfo.index')); ?>">Details</a>
         </li>
       </ul>
     </li>

     <?php else: ?>
     <li>
       <a href="<?php echo e(route('users.bookings.index', auth()->user()->id)); ?>">
         <div class="parent-icon">
           <i class="fas fa-bookmark"></i>
         </div>
         <div class="menu-title">My Bookings</div>
       </a>
     </li>
     <li>
       <a href="<?php echo e(route('payments')); ?>">
         <div class="parent-icon">
           <i class="fas fa-fw fa-tachometer-alt"></i>
         </div>
         <div class="menu-title">Booking Commision</div>
       </a>
     </li>
     <li>
        <a class="collapse-item" href="<?php echo e(route('invoices')); ?>">
          <div class="parent-icon">
            <i class="fas fa-duotone fa-credit-card"></i>
       </div>
       <div class="menu-title">Invoices</div>

       </a>
      </li>
     <!-- <li>
       <a href="<?php echo e(route('flightrequests.index')); ?>">
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
         <li> <a class="collapse-item" href="<?php echo e(route('my.flights')); ?>">Flights Bookings</a>
         </li>
         <li><a class="collapse-item" href="<?php echo e(route('flightrequests.index')); ?>">Flight Requests</a></li>
       </ul>
     </li>
     <li>
       <a href="<?php echo e(route('shuttles.index')); ?>">
         <div class="parent-icon">
           <i class="fas fa-plane"></i>
         </div>
         <div class="menu-title">Airport Shuttle</div>
       </a>
     </li>

     <li>
       <a href="<?php echo e(route('users.apartments.index', auth()->user()->id)); ?>">
         <div class="parent-icon">
           <i class="fas fa-building"></i>
         </div>
         <div class="menu-title">My Apartments</div>
       </a>
     </li>

     <li>
       <a href="<?php echo e(route('users.vehicles.index', auth()->user()->id)); ?>">
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
       
         <li> <a class="collapse-item" href="<?php echo e(route('users.bus.index', auth()->user()->id)); ?>">Buses</a>
         </li>
         <li><a class="collapse-item" href="<?php echo e(route('buses.busstops')); ?>">Bus Stops/ Locations</a>
         </li>
         <li><a class="collapse-item" href="<?php echo e(route('buses.routelist')); ?>">Bus Routes</a>
         </li>
         <li><a class="collapse-item" href="<?php echo e(route('buses.ridelist')); ?>">Rides</a>
         </li>
         <li><a class="collapse-item" href="">Booking</a>
         </li>
                   
       </ul>
     </li>
     <li>
       <a href="<?php echo e(route('users.shuttle.index', auth()->user()->id)); ?>">
         <div class="parent-icon">
           <i class="fas fa-taxi"></i>
         </div>
         <div class="menu-title">My Shuttle</div>
       </a>
     </li>

     <?php endif; ?>



   </ul>
   <?php else: ?>
   <?php endif; ?>
   <!--end navigation-->
 </aside>
 <!--end sidebar -->
 <!-- Sidebar -->

 <!-- End of Sidebar --><?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/layouts/auth/sidebar.blade.php ENDPATH**/ ?>