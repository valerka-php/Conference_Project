import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
    app.component('index-available-time', IndexField)
    app.component('detail-available-time', DetailField)
    app.component('form-available-time', FormField)
})
