<template>
    <DefaultField
        :field="currentField"
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
import {DependentFormField, HandlesValidationErrors} from 'laravel-nova'

export default {
    mixins: [HandlesValidationErrors, DependentFormField],

    data: () => ({
        selectedOption: null,
    }),

    created() {
        this.$nextTick(() => {
            this.changed(this.value)
        })
    },

    methods: {
        fill(formData) {
            this.fillIfVisible(formData, this.field.attribute, this.value ?? '')
        },

        /**
         * Handle on synced field.
         */
        changed(value) {
            this.emitFieldValueChange(this.field.attribute, value)
        },

        /**
         * Handle on synced field.
         */
        onSyncedField() {
            if (this.currentField) {
                for (let fieldItem of ['options', 'radioHelps', 'classes', 'labelClasses', 'styles', 'labelStyles']) {
                    if (this.currentField[fieldItem] && this.currentField[fieldItem] != this.field[fieldItem]) {
                        this.field[fieldItem] = this.currentField[fieldItem]
                    }
                }
            }
            this.changed()
        },
    },
}
</script>
