const BaseFieldMixin = {
    props: [
        'required',
        'name',
        'error',
        'id',
        'value',
        'label',
        'disabled',
        'readonly',
        'instructions',
        'handle',
        'parent',
        'default_value',
        'choices',
        'pattern',
        'placeholder',
        'repeat_max',
        'position',
        'layout',
        'entry_type_handle',
        'field_type_handle'
    ],
    computed: {
        className() {
            let classNames = ['form-group'];
            if (this.required) {
                classNames.push('required');
            }
            if (this.error) {
                classNames.push('invalid');
            }

            return classNames.join(' ');
        }
    }
};

export { BaseFieldMixin }