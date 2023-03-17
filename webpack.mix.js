const mix = require('laravel-mix')

require('vuetifyjs-mix-extension')

mix.copy('node_modules/chart.js/dist/chart.js', 'public/chart.js/chart.js');

mix.js('resources/js/app.js', 'public/js').vuetify().vue()
