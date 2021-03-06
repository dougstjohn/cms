<template>

    <div class="blueprint-builder">

        <div class="flex items-center mb-3">
            <h1 class="flex-1">{{ initialTitle }}</h1>
            <button type="submit" class="btn btn-primary" @click.prevent="save">Save</button>
        </div>

        <div class="publish-form card p-0">
            <div class="form-group">
                <label class="block">{{ __('Title') }}</label>
                <small class="help-block">{{ __('messages.blueprints_title_instructions') }}</small>
                <div v-if="errors.title">
                    <small class="help-block text-red" v-for="(error, i) in errors.title" :key="i" v-text="error" />
                </div>
                <input type="text" name="title" class="input-text" v-model="blueprint.title" autofocus="autofocus">
            </div>
        </div>

        <div class="content mt-5 mb-2">
            <h2>Tab Sections</h2>
            <p class="max-w-lg">The fields in each section will be grouped together into tabs. Create new fields, reuse existing fields, or import entire groups of fields from existing fieldsets.</p>
        </div>

        <sections
            :initial-sections="blueprint.sections"
            @updated="sectionsUpdated"
        />

    </div>

</template>

<script>
import uniqid from 'uniqid';
import Sections from './Sections.vue';

export default {

    components: {
        Sections,
    },

    props: ['action', 'initialBlueprint'],

    data() {
        return {
            blueprint: clone(this.initialBlueprint),
            sections: [],
            initialTitle: this.initialBlueprint.title,
            errors: {}
        }
    },

    created() {
        this.$mousetrap.bindGlobal(['mod+s'], e => {
            e.preventDefault();
            this.save();
        });
    },

    watch: {

        sections(sections) {
            this.blueprint.sections = sections;
        },

        blueprint: {
            deep: true,
            handler() {
                this.$dirty.add('blueprints');
            }
        }

    },

    methods: {

        sectionsUpdated(sections) {
            this.sections = sections;
        },

        save() {
            // this.$axios[this.method](this.action, this.fieldset)
            this.$axios['patch'](this.action, this.blueprint)
                .then(response => this.saved(response))
                .catch(e => {
                    this.$toast.error(e.response.data.message);
                    this.errors = e.response.data.errors;
                })
        },

        saved(response) {
            this.$toast.success('Saved');
            this.errors = {};
            this.$dirty.remove('blueprints');
        }

    }

}
</script>
