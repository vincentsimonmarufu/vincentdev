    <div class=" container mt-5">
        <h1 class="text-white">Plan Your Perfect Getaway Today</h1>
        <p class="text-white mb-2">Whether you're seeking adventure or relaxation, TripJoy has the perfect travel
            deals for
            you. Start planning now.</p>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs rounded-top" id="bookingTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="airplane-tab" data-bs-toggle="tab" data-bs-target="#airplane"
                    type="button" role="tab" aria-controls="airplane" aria-selected="true">Flights</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="hotel-tab" data-bs-toggle="tab" data-bs-target="#hotel" type="button"
                    role="tab" aria-controls="hotel" aria-selected="false">Apartments</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tour-tab" data-bs-toggle="tab" data-bs-target="#tour" type="button"
                    role="tab" aria-controls="tour" aria-selected="false">Airpot Shuttle</button>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content border border-top-0 bg-white p-4 rounded-bottom shadow-sm" id="bookingTabsContent">
            <!-- Airplane Ticket Tab -->
            <div class="tab-pane fade show active" id="airplane" role="tabpanel" aria-labelledby="airplane-tab">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="from" class="form-label">From</label>
                            <input type="text" class="form-control" id="from" placeholder="e.g., Jakarta">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="to" class="form-label">To</label>
                            <input type="text" class="form-control" id="to" placeholder="e.g., New York">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </form>
            </div>

            <!-- Hotel Tab -->
            <div class="tab-pane fade" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
                <form>
                    <div class="mb-3">
                        <label for="destination" class="form-label">Destination</label>
                        <input type="text" class="form-control" id="destination" placeholder="e.g., Bali">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </form>
            </div>

            <!-- Tour Tab -->
            <div class="tab-pane fade" id="tour" role="tabpanel" aria-labelledby="tour-tab">
                <form>
                    <div class="mb-3">
                        <label for="tourDestination" class="form-label">Destination</label>
                        <input type="text" class="form-control" id="tourDestination" placeholder="e.g., Paris">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </form>
            </div>
        </div>
    </div>
<?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/partials/home-tabs.blade.php ENDPATH**/ ?>