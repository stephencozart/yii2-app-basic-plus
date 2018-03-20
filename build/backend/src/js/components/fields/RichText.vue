<template>
    <div class="form-group">
        <label>{{ label }}</label>
        <div v-if="error" class="help-block text-danger">{{ error }}</div>
        <medium-editor :text="value ? value : ''" :options='editorOptions' v-on:edit="syncContent"></medium-editor>
    </div>
</template>
<script>
    import '../../../../../../node_modules/medium-editor/dist/css/medium-editor.css';
    import '../../../../../../node_modules/medium-editor/dist/css/themes/default.css';
    import editor from 'vue2-medium-editor'
    import { BaseFieldMixin } from '../../mixins';

    export default {
        name: 'rich-text',
        mixins: [BaseFieldMixin],
        methods: {
            syncContent(editor) {
                this.$emit('input', editor.api.getContent());
            }
        },
        components: {
            'medium-editor': editor
        },
        data() {
            return {
                editorOptions: {
                    toolbar: {
                        buttons: ['bold', 'italic', 'underline', 'anchor', 'h2', 'h3', 'quote']
                    }
                }
            }
        }
    }
</script>