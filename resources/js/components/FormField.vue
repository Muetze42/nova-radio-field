<template>
    <DefaultField
        :field="currentField"
        :errors="errors"
        :show-help-text="showHelpText"
        :full-width-content="fullWidthContent"
    >
        <template #field>
            <h3 v-if="field.title" :class="field.titleClasses" :style="field.titleStyles">
                {{ field.title }}
            </h3>
            <div :class="field.classes" :style="field.styles">
                <label v-for="option in field.options" :class="field.labelClasses" :style="field.labelStyles">
                    <span class="block flex gap-1.5">
                        <span class="block">
                            <input
                                :id="option.value === value ? field.attribute : null"
                                :key="option.value"
                                :value="option.value"
                                :name="formUniqueId + '_' + field.attribute"
                                type="radio"
                                v-model="selectedOption"
                                class="checkbox rounded-full"
                                @input="changed(option.value)"
                                :disabled="field.readonly"
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
import find from "lodash/find";

export default {
    mixins: [HandlesValidationErrors, DependentFormField],

    props: ['formUniqueId'],

    data: () => ({
        selectedOption: null,
    }),

    created() {
        if (this.field.value !== null) {
            this.selectedOption = this.value
            this.$nextTick(() => {
                this.changed(this.value)
            })
        }
        if (!this.selectedOption && this.field.value === null) {
            this.changed()
        }
    },

    methods: {
        fill(formData) {
            this.fillIfVisible(formData, this.field.attribute, this.value ?? '')
        },

        /**
         * Handle on synced field.
         */
        changed(value = null) {
            let firstValue = null
            this.value = null
            if (value === null && this.selectedOption) {
                value = this.selectedOption
            }
            Object.entries(this.field.options).forEach(([k,v]) => {
                if (firstValue === null) {
                    firstValue = v.value
                }
                if (v.value === value) {
                    this.value = v.value
                }
            })
            if (!this.selectedOption) {
                this.selectedOption = firstValue
            }
            if (this.value === null) {
                this.value = this.selectedOption
            }
            this.emitFieldValueChange(this.field.attribute, this.value)
        },

        /**
         * Handle on synced field.
         */
        onSyncedField() {
            if (this.currentField) {
                for (let fieldItem of ['options', 'readonly', 'radioHelps', 'classes', 'labelClasses', 'styles', 'labelStyles']) {
                    if (this.currentField[fieldItem] && this.currentField[fieldItem] != this.field[fieldItem]) {
                        this.field[fieldItem] = this.currentField[fieldItem]
                    }
                }
            }
            // Keep
            if (!this.currentField.readonly) {
                this.field.readonly = false
            }
            this.changed()
        },
    },
}
</script>
