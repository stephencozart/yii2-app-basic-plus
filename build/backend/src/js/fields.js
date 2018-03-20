import Vue from 'vue'
import TextInput from './components/fields/TextInput'
import Checkbox from './components/Checkbox'
import SelectInput from './components/fields/SelectInput'
import RichText from './components/fields/RichText'
import TextAreaInput from './components/fields/TextAreaInput'
import GroupField from './components/fields/GroupField'
import CheckboxInput from './components/fields/CheckboxInput'
import RadioButtonInput from './components/fields/RadioButtonInput'
import BooleanInput from './components/fields/BooleanInput'
import AssetInput from './components/fields/AssetInput'

Vue.component('asset-input', AssetInput)
Vue.component('boolean-input', BooleanInput)
Vue.component('radio-button-input', RadioButtonInput)
Vue.component('checkbox-input', CheckboxInput)
Vue.component('text-input', TextInput);
Vue.component('text-area-input', TextAreaInput)
Vue.component('checkbox', Checkbox)
Vue.component('select-input', SelectInput)
Vue.component('rich-text', RichText)
Vue.component('group-field', GroupField)
