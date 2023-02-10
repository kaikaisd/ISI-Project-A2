const mix = require('laravel-mix')

require('vuetifyjs-mix-extension')

mix.js('resources/js/app.js', 'public/js').vuetify().vue()
//if you use vuetify-loader
mix.js('resources/js/app.js', 'public/js').vuetify('vuetify-loader').vue()
