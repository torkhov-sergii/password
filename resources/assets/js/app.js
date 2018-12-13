
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//other libs
require('jquery-validation');
require('jquery-aniview');
require('owl.carousel');

//custom
require('./additionally'); //всякий непотреб
require('./site/categories');
require('./site/main');
require('./site/search');
require('./site/subscribe');
require('./site/modal');
require('./site/zoom');

window.Vue = require('vue');

//cookie
var VueCookie = require('vue-cookie');
Vue.use(VueCookie);

//vuex
var Vuex = require('vuex');
const store = new Vuex.Store();

//localization in app.js (compressed) - example: {{ $t('messages.sss') }}
// import vuexI18n from 'vuex-i18n';
// import Locales from './vue-i18n-locales.generated.js';
// Vue.use(vuexI18n.plugin, store);
// Vue.i18n.add('ru', Locales.ru);
// Vue.i18n.set('ru');

//localization - /js/lang.js
Vue.prototype.trans = string => _.get(window.i18n, string);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//vue component
Vue.component('social-sharing', require('vue-social-sharing'));
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('faq-component', require('./components/FaqComponent.vue'));
Vue.component('search-component', require('./components/SearchComponent.vue'));
Vue.component('filters-component', require('./components/FiltersComponent.vue'));
Vue.component('items-component', require('./components/ItemsComponent.vue'));
Vue.component('subscribe-header', require('./components/SubscribeHeader.vue'));
Vue.component('article-component', require('./components/ArticleComponent.vue'));
Vue.component('slider-articles-component', require('./components/SliderArticlesComponent.vue'));

window.eventHub = new Vue();

const app = new Vue({
    el: '#app',
    store,
});

//fontawesome
import fontawesome from '@fortawesome/fontawesome';
import regular from '@fortawesome/fontawesome-free-regular' ;
import solid from '@fortawesome/fontawesome-free-solid';
import brands from '@fortawesome/fontawesome-free-brands';
fontawesome.library.add(regular);
fontawesome.library.add(solid);
fontawesome.library.add(brands);

