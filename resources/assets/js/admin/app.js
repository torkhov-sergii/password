/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');

//other libs
require('jquery-validation');
require('datatables.net');
require('datatables.net-bs4');
// require('moment');
require('jquery-jcrop');
require('jquery-file-upload');
require('summernote/dist/summernote-bs4');
require('../../vendor/summernote-cleaner/summernote-cleaner');
require('select2');
require('jquery-ui-dist/jquery-ui');
require('bootstrap-datepicker'); //!!!after jquery-ui!!!

//metronic
require('malihu-custom-scrollbar-plugin');
require('bootstrap-notify');
window.swal = require('sweetalert2');
require('chart.js');
require('bootstrap-markdown/js/bootstrap-markdown.js');
require('bootstrap-timepicker');
// require('../../vendor/metronic_5061/dist/default/assets/vendors/base/vendors.bundle.js'); //metronic base
require('../../vendor/metronic_5061/dist/default/assets/demo/default/base/scripts.bundle.js'); //metronic base

//custom
require('../additionally'); //всякий непотреб
require('./base'); //base functionality
require('./location'); //location
require('./wysiwyg_editor'); //ckeditor or other
require('./translation'); //translation

//require('x-editable/dist/bootstrap3-editable/js/bootstrap-editable');
//require('./translation');

// window.Vue = require('vue');
//
// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */
//
// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });

// const functions = require('./app2.js');
// functions.myAwesomeFunction();


// import fontawesome from '@fortawesome/fontawesome'
// import regular from '@fortawesome/fontawesome-free-regular'
// import solid from '@fortawesome/fontawesome-free-solid'
// import brands from '@fortawesome/fontawesome-free-brands'
//
// fontawesome.library.add(regular)
// fontawesome.library.add(solid)
// fontawesome.library.add(brands)
//
// console.log(123);