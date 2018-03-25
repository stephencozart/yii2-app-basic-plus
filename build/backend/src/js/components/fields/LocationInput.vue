<template>
    <div :class="className">
        <label :for="id">{{ label }}</label>

        <div class="hint-block text-muted" v-if="instructions">{{ instructions }}</div>
        <div v-if="error" class="help-block text-danger">{{ error }}</div>
        <vue-google-autocomplete
                :id="'map-'+id"
                classname="form-control"
                :placeholder="displayName"
                v-on:placechanged="setAddressData"
                ref="address"
        >
        </vue-google-autocomplete>

        <div v-if="address && address.latitude" class="lat-lng">
            <span class="badge badge-secondary">
                {{ address.latitude }}, {{ address.longitude }}
            </span>
            <button @click="removeLocation" class="btn btn-outline-secondary btn-sm">
                <font-awesome-icon icon="times" prefix="far"></font-awesome-icon>
            </button>
        </div>

        <div v-show="address && address.latitude" style="min-height: 200px;" ref="mapContainer" id="map-container">

        </div>
    </div>
</template>
<script>
    import { BaseFieldMixin } from '../../mixins'
    import VueGoogleAutocomplete from 'vue-google-autocomplete'

    export default {
        name: 'location-input',
        mixins: [BaseFieldMixin],
        components: {
          VueGoogleAutocomplete
        },
        methods: {
            setAddressData(value, placeResultData) {
                this.address = value;
                this.displayName = placeResultData.formatted_address;
            },
            removeLocation() {
                this.address = '';
                this.displayName = 'Start typing';
                this.$refs.address.update('');
            },
            initMap(value) {
                if (value) {
                    let map = new google.maps.Map(this.$refs.mapContainer, {
                        center: {lat: value.latitude, lng: value.longitude},
                        zoom: 13
                    });

                    let marker = new google.maps.Marker({
                        map: map,
                        position:  {
                            lat: value.latitude,
                            lng: value.longitude
                        }
                    });
                }

            }
        },
        data() {
            let value = this.value ? JSON.parse(this.value) : { address: '', displayName: 'Start typing'};
            return {
                address: value.address,
                displayName: value.displayName
            }
        },
        mounted() {
            this.initMap(this.address);
        },
        watch: {
            address(value) {
                if (value) {
                    this.initMap(value);
                }
                let data = JSON.stringify({
                    address: this.address,
                    displayName: this.displayName
                });
                this.$emit('input', data);
            }
        }
    }
</script>
<style lang="scss">
    .lat-lng {
        padding: 1rem 0;
        .badge {
            padding: .6rem;
            font-size: 73%;
            vertical-align: middle;
        }
    }
</style>