import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
    app.component('index-map-component', IndexField)
    app.component('detail-map-component', DetailField)
    app.component('form-map-component', FormField)
})
