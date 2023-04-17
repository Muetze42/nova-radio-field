<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
        :full-width-content="fullWidthContent"
    >
        <template #field>
            <div class="inline-flex" :class="field.cClasses">
                <label v-for="option in field.options" class="cursor-pointer">
                    <input
                        :id="option.value === value ? field.attribute : null"
                        :value="option.value"
                        :name="field.attribute"
                        type="radio"
                        v-model="value"
                        class="checkbox rounded-full"
                        :class="field.radioHelps[option.value] ? 'mb-0.5' : 'mb-1'"
                    />
                    {{ option.label }}
                    <span v-if="field.radioHelps[option.value]"
                          class="block help-text help-text pl-5 mt-[-0.25rem]"
                          v-html="field.radioHelps[option.value]"
                    />
                </label>
            </div>
        </template>
    </DefaultField>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    mounted() {
        console.log(this.field.options)
        console.log(this.field.radioHelps)
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },
    },
}
</script>
