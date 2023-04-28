<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
        :full-width-content="fullWidthContent"
    >
        <template #field>
            <div :class="field.classes" :style="field.styles">
                <label v-for="option in field.options" :class="field.labelClasses" :style="field.labelStyles">
                    <span class="block flex gap-1.5">
                        <span class="block">
                            <input
                                :id="option.value === value ? field.attribute : null"
                                :value="option.value"
                                :name="field.attribute"
                                type="radio"
                                v-model="value"
                                class="checkbox rounded-full"
                                @input="changed(option.value)"
                            />
                        </span>
                        <span class="block">
                            {{ option.label }}
                            <span v-if="field.radioHelps[option.value]"
                                  class="block help-text help-text mt-[-0.25rem]"
                                  v-html="field.radioHelps[option.value]"
                            />
                        </span>
                    </span>
                </label>
            </div>
        </template>
    </DefaultField>
</template>

<script>
import {FormField, DependentFormField, HandlesValidationErrors} from 'laravel-nova'

export default {
    mixins: [FormField, DependentFormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

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

        changed(value) {
            this.emitFieldValueChange(this.field.attribute, value)
        }
    },
}
</script>
