<template>
    <div class="template-fieldtype-container">
        <v-select
            ref="input"
            :name="name"
            @input="update"
            :clearable="config.clearable"
            :disabled="config.disabled"
            :options="options"
            :reduce="selection => selection.value"
            :searchable="true"
            :push-tags="false"
            :multiple="false"
            :value="value" />
    </div>
</template>

<script>
export default {

    mixins: [Fieldtype],

    data: function() {
        return {
            loading: true,
            options: []
        }
    },

    mounted() {
        this.$axios.get(cp_url('api/templates')).then(response => {
            var options = [{
                label: __('Inherit (Default)'),
                value: null
            }];

            _.each(response.data, function(template) {
                options.push({
                    label: template,
                    value: template
                });
            });

            this.options = options;
            this.loading = false;
        });
    }

};
</script>
