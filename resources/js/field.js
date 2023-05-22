import FormField from './components/FormField'
import IndexField from './components/IndexField'
import DetailField from './components/DetailField'

Nova.booting((app, store) => {
  app.component('form-nova-radio-field', FormField)
  app.component('index-nova-radio-field', IndexField)
  app.component('detail-nova-radio-field', DetailField)
})
