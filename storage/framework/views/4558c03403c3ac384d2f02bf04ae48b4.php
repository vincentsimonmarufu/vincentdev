<style>
    .deck-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, 40px);
        grid-template-rows: repeat(auto-fill, 40px);
        gap: 1px;
        margin: 1 auto;
        padding-bottom: 10%;
    }

    .seat {
        background-color: #ddd;
        border: 1px solid #aaa;
        padding: 5px;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s, border-color 0.3s;
        margin-bottom: 1px;
    }

    .seat:hover {
        background-color: #ccc;
    }

    .facility {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: transparent;
    }

    .facility-icon {
        width: 20px;
        height: 20px;
    }

    .wing-area {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #e0e0e0;
        grid-column: span 3;
    }

    .wing-icon {
        width: 30px;
        height: auto;
    }


    .exit-row {
        background-color: #f2f2f2;
        text-align: center;
        padding: 5px;
        border: 1px solid #aaa;
    }


    .exit-text {
        color: red;
        font-weight: bold;
    }


    .exit-row {
        background-color: #f5f5f5;
        text-align: center;
        color: red;
        font-weight: bold;
        grid-column: 1 / -1;
        /* This spans the entire row */
        padding: 5px 0;
    }

    .blocked-seat {
        background-color: red;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .available-seat {
        background-color: #c6f5d9;
        cursor: pointer;
    }

    .occupied-seat {
        background-color: #c6e7f5;
        cursor: default;
        opacity: 0.8;
    }

    .dynamic-window {
        position: fixed;
        width: 200px;
        height: 30%;
        background-color: #e1e4dc;
        border: 1px solid #ccc;
        /* z-index: 1000; */
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 15px;
    }

    .dynamic-window-content {
        flex-grow: 1;
        overflow-y: auto;
    }

    .dynamic-window button {
        margin-top: auto;
    }

    /* @media (max-width: 768px) {
        .dynamic-window {
            width: 80%;
            height: 40%;
            right: 10%;
        }
    }

    @media (max-width: 576px) {
        .dynamic-window {
            width: 90%;
            height: 50%;
            right: 5%;
        }
    } */

    .legend-container {
        display: flex;
        gap: 8px;
        align-items: center;
        margin-left: 15px;
        margin-top: 5px;
    }

    .legend-item {
        display: flex;
        align-items: center;
    }

    .legend-color {
        width: 15px;
        height: 15px;
        margin-right: 1px;
        display: inline-block;
        border-radius: 4px;
    }


    .legend-text {
        font-size: 13px;
    }

    #confirm-seat {
        display: block;
        /* margin: 20px auto; */
        padding: 7px 10px;
        background-color: #3498db;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-bottom: 5px;
    }

    #confirm-seat:disabled {
        background-color: #95a5a6;
        cursor: not-allowed;
    }

    .booking-seats-window {
        min-width: 200px;
        height: auto;
        padding: 15px;
        border: 1px solid #ccc;
        /* Optional: Add a border */
        background-color: #f9f9f9;
        /* Optional: Add background color */
        border-radius: 8px;
        /* Optional: Rounded corners */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        /* Optional: Add shadow */
    }
</style>
<style>
    .container-box {
        width: 480px;
        max-height: 400px;
        background-color: #f0f0f0;
        border: 1px solid #ddd;
        display: none;

    }

    .container-box.active {
        display: block;
    }
</style>


<div class="container" id="">
    <div class="row">

        <div class="col-md-5">
            <h4 class="mt-2" style="margin-left: 10px;">
                Flight(<?php echo e($seatMapData[0]['carrierCode']); ?><?php echo e($seatMapData[0]['number']); ?>) seats detail</h4>
            <div class="container mt-2">

                <?php for($i = 0; $i < $metaCount; $i++): ?>
                    <?php
                        $newactive = $i == 0 ? 'active' : '';
                    ?>

                    <div id="container-<?php echo e($i + 1); ?>" class="container-box <?php echo e($newactive); ?>"
                        style="overflow: auto;">
                        <?php if($i == 0): ?>
                            <div class="mb-1"> Select seats for flight </div>
                        <?php endif; ?>
                        <?php if($i >= 1): ?>
                            <div class="mb-1"> Select seats for <b><?php echo e($i); ?></b> connecting flight </div>
                        <?php endif; ?>
                        <?php $__currentLoopData = $seatMapData[$i]['decks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="deck-container"
                                style="width: <?php echo e($deck['deckConfiguration']['width'] * 40); ?>px;">
                                <?php $__currentLoopData = $deck['seats']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $status = strtolower($seat['travelerPricing'][0]['seatAvailabilityStatus']);
                                    ?>

                                    <div class="seat
                                                                <?php echo e($status === 'blocked' ? 'blocked-seat' : ($status === 'available' ? 'available-seat' : ($status === 'occupied' ? 'occupied-seat' : ''))); ?>"
                                        data-seat-number="<?php echo e($seat['number']); ?>"
                                        style="grid-column: <?php echo e($seat['coordinates']['y'] + 1); ?>;
                                                                        grid-row: <?php echo e($seat['coordinates']['x'] + 1); ?>;">
                                        <?php echo e($seat['number']); ?>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="legend-container">
                <div class="legend-item">
                    <span class="legend-color" style="background-color: #c6f5d9;"></span>
                    <span class="legend-text">Available</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background-color: #c6e7f5;"></span>
                    <span class="legend-text">Occupied</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background-color: #ff0000b3;"></span>
                    <span class="legend-text">Blocked</span>
                </div>
                <div class="legend-item">
                    <span class="legend-color" style="background-color: rgb(246, 246, 194, 1);"></span>
                    <span class="legend-text">Selected</span>
                </div>
            </div>

            <div class="container mt-1 mb-2">
                <button id="prev-btn" class="btn btn-secondary mt-0" style="display: none;">Previous</button>
                <button id="next-btn" class="btn btn-primary mt-0" data-metacount="<?php echo e($metaCount); ?>">Next</button>
            </div>
        </div>
        <div class="col-md-5" style="margin-left: 5%;margin-top: 5%;">
            <!-- <div class="dynamic-window">  -->
            <div class="booking-seats-window">
                <h5>Booking seats details</h5>
                <div id="no_of_selected_seats">Selected Seat: 0</div>
                <!-- <div id="count">Count: 0</div>  -->

                <form action="<?php echo e(route('flight-price')); ?>" id="form<?php echo e($flightOfferDetail->id); ?>" method="POST"
                    class="form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="flight" value="<?php echo e(json_encode($flightOfferDetail) ?? ''); ?>" />
                    <input type="hidden" name="flight_option" value="<?php echo e($flight_option ?? ''); ?>" />
                    <input type="hidden" name="selectedSeats[]" id="selectedSeats" />
                    <button type="submit" id="confirm-seat" class="btn btn-primary" disabled>Confirm Seats</button>
                </form>
            </div>

            <!-- </div> -->
        </div>
        <div class="col-md-4"></div>
    </div>
    <div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                let currentContainer = 1;
                var totalContainers = $('#next-btn').data('metacount');

                // Log the current metaCount
                console.log("Initial metaCount:", totalContainers);

                function toggleButtons() {
                    if (currentContainer === 1) {
                        $('#prev-btn').hide();
                    } else {
                        $('#prev-btn').show();
                    }

                    if (currentContainer === totalContainers) {
                        $('#next-btn').hide();
                    } else {
                        $('#next-btn').show();
                    }
                }

                // Initialize button visibility
                toggleButtons();

                // Handle "Next" button click
                $('#next-btn').click(function() {
                    // Hide the current container
                    $('#container-' + currentContainer).removeClass('active');

                    // Move to the next container
                    currentContainer++;

                    // Show the next container
                    $('#container-' + currentContainer).addClass('active');

                    // Update button visibility
                    toggleButtons();
                });

                // Handle "Previous" button click
                $('#prev-btn').click(function() {
                    // Hide the current container
                    $('#container-' + currentContainer).removeClass('active');

                    // Move to the previous container
                    currentContainer--;

                    // Show the previous container
                    $('#container-' + currentContainer).addClass('active');

                    // Update button visibility
                    toggleButtons();
                });

                // other code
                let selectedSeats = [];

                // Event listener for available seats
                $('.deck-container').on('click', '.seat.available-seat', function() {
                    const seatNumber = $(this).data('seat-number').toString().trim();
                    if (seatNumber) {
                        selectedSeats.push(seatNumber);
                        $(this).addClass('selected');
                        $(this).css('background-color', '#ffffe0');
                    } else {
                        // Remove seat number if clicked again (toggle functionality)
                        selectedSeats = selectedSeats.filter(seat => seat !== seatNumber);
                    }

                    // Update the hidden input field with the selected seats array, joined as a string
                    $('#selectedSeats').val(selectedSeats.join(','));
                    console.log(selectedSeats);

                    $('#confirm-seat').prop('disabled', selectedSeats.length === 0);

                    $('#no_of_selected_seats').text('Selected Seats: ' + (selectedSeats.length > 0 ?
                        selectedSeats.join(', ') : 'None'));
                    $('#count').text('Count: ' + selectedSeats.length);
                });

            });
        </script>
<?php /**PATH C:\Users\vince\Documents\Workspace\Abisiniya\abisiniya82\resources\views/layouts/flightseatmapwidget.blade.php ENDPATH**/ ?>