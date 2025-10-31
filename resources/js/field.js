import FormField from './components/FormField.vue'
import IndexField from './components/IndexField.vue'
import DetailField from './components/DetailField.vue'

Nova.booting((app, store) => {
  app.component('form-nova-radio-field', FormField)
  app.component('index-nova-radio-field', IndexField)
  app.component('detail-nova-radio-field', DetailField)
})
