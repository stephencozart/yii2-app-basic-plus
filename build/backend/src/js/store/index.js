import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default function() {
    return new Vuex.Store({
        state: {
            user: {},
            notifications: [
                /*{
                    type: 'success',
                    message: 'Good job what you did worked!',
                    icon: 'check-circle'
                },
                {
                    type: 'error',
                    message: 'Oh boy,  that did not go very will did it?',
                    icon: 'exclamation-triangle'
                }*/
            ],
            roles: [],
            inspect: null,
            overlay: false,
            fieldTypes: {
                TextInput: {
                    value: 'text-input',
                    name: 'Text'
                },
                IntegerInput: {
                    value: 'integer-input',
                    name: 'Integer Input'
                },
                DecimalInput: {
                    value: 'decimal-input',
                    name: 'Decimal Input'
                },
                DateInput: {
                    value: 'date-input',
                    name: 'Date Input'
                },
                DateTimeInput: {
                    value: 'date-time-input',
                    name: 'Date Time Input'
                },
                SelectInput: {
                    value: 'select-input',
                    name: 'Select',
                    choices: true
                },
                TextAreaInput: {
                    value: 'text-area-input',
                    name: 'Text Area'
                },
                RichText: {
                    value: 'rich-text',
                    name: 'WYSIWYG Editor'
                },
                CheckboxInput: {
                    value: 'checkbox-input',
                    name: 'Checkbox',
                    choices: true
                },
                RadioButtonInput: {
                    value: 'radio-button-input',
                    name: 'Radio Button',
                    choices: true
                },
                BooleanInput: {
                    value: 'boolean-input',
                    name: 'True/False'
                },
                AssetInput: {
                    value: 'asset-input',
                    name: 'Asset'
                },
                ColorPickerInput: {
                    value: 'color-picker-input',
                    name: 'Color Picker'
                },
                LocationInput: {
                    value: 'location-input',
                    name: 'Location Input'
                },
                GroupField: {
                    value: 'group-field',
                    name: 'Group Field'
                }
            }
        },
        mutations: {
            USER(state, payload) {
                state.user = payload;
            },
            ROLES(state, payload) {
                state.roles = payload;
            },
            SHOW_OVERLAY(state) {
                state.overlay = true;
            },
            HIDE_OVERLAY(state) {
                state.overlay = false;
            }
        },
        actions: {
            pushErrorNotification({commit, state}, message) {
                state.notifications.push({
                    type: 'error',
                    message: message,
                    icon: 'exclamation-triangle'
                });
            },
            pushSuccessNotification({commit, state}, message) {
                state.notifications.push({
                    type: 'success',
                    message: message,
                    icon: 'check-circle'
                })
            },
            removeNotification({commit, state}, index) {
                state.notifications.splice(index, 1);
            }
        }
    });
}