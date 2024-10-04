<template>
    <div>
        <div class="d-flex my-4">
            <div class="col-4">
                <h5>Locations</h5>
            </div>
            <div class="col-3 offset-md-1">
                <h5>Minutes from departure</h5>
            </div>
            <div class="col-3">
                <h5>Price($) from departure</h5>
            </div>           
        </div>

        <div class="form-group" v-for="(input, index) in inputs" :key="index">
            <div class="d-flex">
                <div class="col-4">
                    <select class="form-control" :ref="`select2-${index}`" :name="`locations[${index}][id]`" :id="`location${index}`" required>
                        <option></option>
                        <option v-for="location in locations" :key="location.id" :value="location.id" :selected="input.id === location.id">
                            {{ location.buslocation }}
                        </option>
                    </select>                    
                </div>                

                <div class="col-2 offset-md-1">
                    <input type="number" :name="`locations[${index}][minutes]`" v-show="index !== 0"
                           :disabled="index === 0" :min="index > 1 ? parseInt(inputs[index - 1].minutes) + 1 : 0"
                           class="form-control mr-2" placeholder="Minutes" v-model="input.minutes"
                           required style="height: 28px !important">
                </div>              

                <div class="col-2 offset-md-1">
                    <input type="number" :name="`locations[${index}][prices]`" v-show="index !== 0"
                           :disabled="index === 0" :min="index > 1 ? parseInt(inputs[index - 1].prices) + 1 : 0"
                           class="form-control mr-2" placeholder="Price" v-model="input.prices"
                           required style="height: 28px !important">
                </div>

                <div class="col-2 d-flex align-items-center dynamic-inputs-buttons">
                    &nbsp;<i class="fas fa-minus text-danger fa-lg mr-2" @click="removeInput(index)"
                       v-show="index !== 0  && inputs.length > 1">
                    </i>&nbsp;
                  <i class="fas fa-plus text-success fa-lg" @click="addInput()"
                       v-show="index === inputs.length - 1">
                    </i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'locations',
        'route',       
    ],

    mounted() {
        if (this.route) {
            this.fillInputsWithRouteLocations(this.route.locations)
        } else {
            this.inputs.push({id: null, minutes: 0}) // Only one initial input
        }

        this.applySelect2(0)
    },

    data() {
        return {
            inputs: []
        }
    },

    methods: {
        addInput() {
            this.inputs.push({
                id: null,
                minutes: parseInt(this.inputs[this.inputs.length - 1].minutes) + 1
            })
            this.applySelect2(this.inputs.length - 1)
        },

        removeInput(index) {
            this.inputs.splice(index, 1)
        },

        fillInputsWithRouteLocations(locations) {
            locations.forEach((location) => {
                this.inputs.push({
                    'id': location.pivot.location_id,
                    'minutes': location.pivot.minutes_from_departure
                })
            })
        },

        applySelect2(index) {
            this.$nextTick(() => {
                $(this.$refs[`select2-${index}`]).select2({
                    placeholder: 'Select location',
                    width: '100%'
                })
            })
        }
    }
}
</script>
