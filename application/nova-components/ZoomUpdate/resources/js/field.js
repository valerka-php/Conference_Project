import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
    app.component('index-zoom-update', IndexField)
    app.component('detail-zoom-update', DetailField)
    app.component('form-zoom-update', FormField)
})
