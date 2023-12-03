import DefaultField from './../../../../vendor/laravel/nova/resources/js/components/DefaultField.vue'

Vue.component('DefaultField', DefaultField)
Vue.mixin({
    methods: {
        __(key, replacements) {
            return __(key, replacements)
        },
        logout() {
        },
        stopImpersonating() {
        }
    },
    data() {
        return {
            value: String|Number|null,
            currentField: Object,
            errors: Object,
            showHelpText: Boolean,
            fullWidthContent: Boolean,
            field: {
                'attribute': String,
                'component': String,
                'compact': Boolean,
                'displayedAs': null,
                'fullWidth': Boolean,
                'helpText': null,
                'indexName': String,
                'inline': Boolean,
                'name': String,
                'nullable': Boolean,
                'panel': String,
                'placeholder': String|null,
                'prefixComponent': Boolean,
                'readonly': Boolean,
                'required': Boolean,
                'sortable': Boolean,
                'sortableUriKey': String,
                'stacked': Boolean,
                'textAlign': String,
                'uniqueKey': String,
                'usesCustomizedDisplay': Boolean,
                'validationKey': String,
                'value': String|Number,
                'visible': Boolean,
                'withLabel': Boolean,
                'wrapping': Boolean,
                'dependentComponentKey': String,
                'dependsOn': String|null,
                'dependentShouldEmitChangesEvent': Boolean,
                'options': Object,
                'radioHelps': Object|null,
                'classes': Array,
                'labelClasses': Array,
                'styles': Array,
                'labelStyles': Object|Array,
                'titleClasses': Object|Array,
                'titleStyles': Object|Array,
                'title': String|null,
            }
        }
    }
})
