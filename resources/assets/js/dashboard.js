// Global Dashboard Variable
window.Dashboard = {
    app: '',
    e404: '',
    dashboard: '',
    staff: ''
}


/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

/**
 * Register Global Components
 */
Vue.component('clock', require('./components/General/Clock.vue'));
Vue.component('modal', require('./components/General/Modal.vue'));

// Error Component
Dashboard.e404 = require('./components/E404.vue');

// Home Component
Dashboard.dashboard = require('./components/Dashboard.vue');

// Administrator Components
Dashboard.administrator = require('./components/Administrator.vue');

// Academics Components
Dashboard.academics = require('./components/Academics.vue');

// Classes Components
Dashboard.classes = require('./components/Classes.vue');


/**
 * Register Global Filters
 */
Vue.filter('momentformat', function(value, format) {
    return moment(value).tz(window.timezone).format(format);
});
Vue.filter('cutFirstname', function(value) {
    return value.split(" ")[0]
});


// Define routes
const routes = [
    { path: '/dashboard', name: 'dashboard', component: Dashboard.dashboard },
    { path: '/admin', name: 'administrator', component: Dashboard.administrator },
    { path: '/acad', name: 'academics', component: Dashboard.academics },
    { path: '/classes', name: 'classes', component: Dashboard.classes }
];

// Create router instance
const router = new VueRouter({
    root: window.url_rootDIR,
    routes // short for routes: routes
})

// Start Router
Dashboard.app = new Vue({
    router,
    methods: {

        openFlash: function(flashMessage) {
            this.$broadcast('openFlash', flashMessage);
        },

        setBreadcrumb(name, icon, event) {
            this.breadcrumbs.name = name;
            this.breadcrumbs.icon = icon;
            //router.push($(event.currentTarget).attr('data-id'));
        },

        showSubNavigation(e) {
            var subnav = $(e.target).parent().find('.sub-navigation');
            if($(subnav).css('display') == 'none') $(subnav).slideDown();
            else $(subnav).slideUp();
        }

    },

    events: {

        callOpenFlashChild: function(flashMessage){
            this.openFlash(flashMessage);
        }

    },

    ready: function() {

        $('.ui.dropdown').dropdown();

    },

    data: {
        toggleLeft: false,
        breadcrumbs: { name: 'Dashboard', icon: 'dashboard' },
        country_flags: [
            { flag: 'ad', country: 'Andorra' },{ flag: 'ae', country: 'U.A.E' },{ flag: 'af', country: 'Afghanistan' },
            { flag: 'ag', country: 'Antigua' },{ flag: 'ai', country: 'Anguilla' },{ flag: 'al', country: 'Albania' },
            { flag: 'am', country: 'Armenia' },{ flag: 'an', country: 'Netherlands Antilles' },{ flag: 'ao', country: 'Angola' },
            { flag: 'ar', country: 'Argentina' },{ flag: 'as', country: 'American Samoa' },{ flag: 'at', country: 'Austria' },
            { flag: 'au', country: 'Australia' },{ flag: 'aw', country: 'Aruba' },{ flag: 'ax', country: 'Aland Islands' },
            { flag: 'az', country: 'Azerbaijan' },{ flag: 'ba', country: 'Bosnia' },{ flag: 'bb', country: 'Barbados' },
            { flag: 'bd', country: 'Bangladesh' }, { flag: 'be', country: 'Belgium' },{ flag: 'bf', country: 'Burkina Faso' },
            { flag: 'bg', country: 'Bulgaria' },{ flag: 'bh', country: 'Bahrain' },{ flag: 'bi', country: 'Burundi' },
            { flag: 'bj', country: 'Benin' },{ flag: 'bm', country: 'Bermuda' },{ flag: 'bn', country: 'Brunei' },
            { flag: 'bo', country: 'Bolivia' },{ flag: 'br', country: 'Brazil' },{ flag: 'bs', country: 'Bahamas' },
            { flag: 'bt', country: 'Bhutan' },{ flag: 'bv', country: 'Bouvet Island' },{ flag: 'bw', country: 'Botswana' },
            { flag: 'by', country: 'Belarus' }, { flag: 'bz', country: 'Belize' },{ flag: 'ca', country: 'Canada' },
            { flag: 'cc', country: 'Cocos Islands' },{ flag: 'cd', country: 'Congo' },{ flag: 'cf', country: 'Central African Republic' },
            { flag: 'cg', country: 'Congo Brazzaville' },{ flag: 'ch', country: 'Switzerland' },{ flag: 'ci', country: 'Cote Divoire' },
            { flag: 'ck', country: 'Cook Islands' },{ flag: 'cl', country: 'Chile' },{ flag: 'cm', country: 'Cameroon' },
            { flag: 'cn', country: 'China' },{ flag: 'co', country: 'Colombia' },{ flag: 'cr', country: 'Costa Rica' },
            { flag: 'cs', country: 'Serbia' }, { flag: 'cu', country: 'Cuba' },{ flag: 'cv', country: 'Cape Verde' },
            { flag: 'cx', country: 'Christmas Island' },{ flag: 'cy', country: 'Cyprus' },{ flag: 'cz', country: 'Czech Republic' },
            { flag: 'de', country: 'Germany' },{ flag: 'dj', country: 'Djibouti' },{ flag: 'dk', country: 'Denmark' },
            { flag: 'dm', country: 'Dominica' },{ flag: 'do', country: 'Dominican Republic' },{ flag: 'dz', country: 'Algeria' },
            { flag: 'ec', country: 'Ecuador' },{ flag: 'ee', country: 'Estonia' },{ flag: 'eg', country: 'Egypt' },
            { flag: 'eh', country: 'Western Sahara' }, { flag: 'er', country: 'Eritrea' },{ flag: 'es', country: 'Spain' },
            { flag: 'et', country: 'Ethiopia' },{ flag: 'eu', country: 'European Union' },{ flag: 'fi', country: 'Finland' },
            { flag: 'fj', country: 'Fiji' },{ flag: 'fk', country: 'Falkland Islands' },{ flag: 'fm', country: 'Micronesia' },
            { flag: 'fo', country: 'Faroe Islands' },{ flag: 'fr', country: 'France' },{ flag: 'ga', country: 'Gabon' },
            { flag: 'gb', country: 'United Kingdom' },{ flag: 'gb sct', country: 'Scotland' },{ flag: 'gb wls', country: 'Wales' },
            { flag: 'gd', country: 'Grenada' }, { flag: 'ge', country: 'Georgia' },{ flag: 'gf', country: 'French Guiana' },
            { flag: 'gh', country: 'Ghana' },{ flag: 'gi', country: 'Gibraltar' },{ flag: 'gl', country: 'Greenland' },
            { flag: 'gm', country: 'Gambia' },{ flag: 'gn', country: 'Guinea' },{ flag: 'gp', country: 'Guadeloupe' },
            { flag: 'gq', country: 'Equatorial Guinea' },{ flag: 'gr', country: 'Greece' },{ flag: 'gs', country: 'Sandwich Islands' },
            { flag: 'gt', country: 'Guatemala' },{ flag: 'gu', country: 'Guam' },{ flag: 'gw', country: 'Guinea-bissau' },
            { flag: 'gy', country: 'Guyana' }, { flag: 'hk', country: 'Hong Kong' },{ flag: 'hm', country: 'Heard Island' },
            { flag: 'hn', country: 'Honduras' },{ flag: 'hr', country: 'Croatia' },{ flag: 'ht', country: 'Haiti' },
            { flag: 'hu', country: 'Hungary' },{ flag: 'id', country: 'Indonesia' },{ flag: 'ie', country: 'Ireland' },
            { flag: 'il', country: 'Israel' },{ flag: 'in', country: 'India' },{ flag: 'io', country: 'Indian Ocean Territory' },
            { flag: 'iq', country: 'Iraq' },{ flag: 'ir', country: 'Iran' },{ flag: 'is', country: 'Iceland' },
            { flag: 'it', country: 'Italy' }, { flag: 'jm', country: 'Jamaica' },{ flag: 'jo', country: 'Jordan' },
            { flag: 'jp', country: 'Japan' },{ flag: 'ke', country: 'Kenya' },{ flag: 'kg', country: 'Kyrgyzstan' },
            { flag: 'kh', country: 'Cambodia' },{ flag: 'ki', country: 'Kiribati' },{ flag: 'km', country: 'Comoros' },
            { flag: 'kn', country: 'Saint Kitts And Nevis' },{ flag: 'kp', country: 'North Korea' },{ flag: 'kr', country: 'South Korea' },
            { flag: 'kw', country: 'Kuwait' },{ flag: 'ky', country: 'Cayman Islands' },{ flag: 'kz', country: 'Kazakhstan' },
            { flag: 'la', country: 'Laos' }, { flag: 'lb', country: 'Lebanon' },{ flag: 'lc', country: 'Saint Lucia' },
            { flag: 'li', country: 'Liechtenstein' },{ flag: 'lk', country: 'Sri Lanka' },{ flag: 'lr', country: 'Liberia' },
            { flag: 'ls', country: 'Lesotho' },{ flag: 'lt', country: 'Lithuania' },{ flag: 'lu', country: 'Luxembourg' },
            { flag: 'lv', country: 'Latvia' },{ flag: 'ly', country: 'Libya' },{ flag: 'ma', country: 'Morocco' },
            { flag: 'mc', country: 'Monaco' },{ flag: 'md', country: 'Moldova' },{ flag: 'me', country: 'Montenegro' },
            { flag: 'mg', country: 'Madagascar' }, { flag: 'mh', country: 'Marshall Islands' },{ flag: 'mk', country: 'Macedonia' },
            { flag: 'ml', country: 'Mali' },{ flag: 'mm', country: 'Burma' },{ flag: 'mn', country: 'Mongolia' },
            { flag: 'mo', country: 'Macau' },{ flag: 'mp', country: 'Northern Mariana Islands' },{ flag: 'mq', country: 'Martinique' },
            { flag: 'mr', country: 'Mauritania' },{ flag: 'ms', country: 'Montserrat' },{ flag: 'mt', country: 'Malta' },
            { flag: 'mu', country: 'Mauritius' },{ flag: 'mv', country: 'Maldives' },{ flag: 'mw', country: 'Malawi' },
            { flag: 'mx', country: 'Mexico' }, { flag: 'my', country: 'Malaysia' },{ flag: 'mz', country: 'Mozambique' },
            { flag: 'na', country: 'Namibia' },{ flag: 'nc', country: 'New Caledonia' },{ flag: 'ne', country: 'Niger' },
            { flag: 'nf', country: 'Norfolk Island' },{ flag: 'ng', country: 'Nigeria' },{ flag: 'ni', country: 'Nicaragua' },
            { flag: 'nl', country: 'Netherlands' },{ flag: 'no', country: 'Norway' },{ flag: 'np', country: 'Nepal' },
            { flag: 'nr', country: 'Nauru' },{ flag: 'nu', country: 'Niue' },{ flag: 'nz', country: 'New Zealand' },
            { flag: 'om', country: 'Oman' }, { flag: 'pa', country: 'Panama' },{ flag: 'pe', country: 'Peru' },
            { flag: 'pf', country: 'French Polynesia' },{ flag: 'pg', country: 'New Guinea' },{ flag: 'ph', country: 'Philippines' },
            { flag: 'pk', country: 'Pakistan' },{ flag: 'pl', country: 'Poland' },{ flag: 'pm', country: 'Saint Pierre' },
            { flag: 'pn', country: 'Pitcairn Islands' },{ flag: 'pr', country: 'Puerto Rico' },{ flag: 'ps', country: 'Palestine' },
            { flag: 'pt', country: 'Portugal' },{ flag: 'pw', country: 'Palau' },{ flag: 'py', country: 'Paraguay' },
            { flag: 'qa', country: 'Qatar' }, { flag: 're', country: 'Reunion' },{ flag: 'ro', country: 'Romania' },
            { flag: 'rs', country: 'Serbia' },{ flag: 'ru', country: 'Russia' },{ flag: 'rw', country: 'Rwanda' },
            { flag: 'sa', country: 'Saudi Arabia' },{ flag: 'sb', country: 'Solomon Islands' },{ flag: 'sc', country: 'Seychelles' },
            { flag: 'sd', country: 'Sudan' },{ flag: 'se', country: 'Sweden' },{ flag: 'sg', country: 'Singapore' },
            { flag: 'sh', country: 'Saint Helena' },{ flag: 'si', country: 'Slovenia' },{ flag: 'sj', country: 'Jan Mayen' },
            { flag: 'sk', country: 'Slovakia' }, { flag: 'sl', country: 'Sierra Leone' },{ flag: 'sm', country: 'San Marino' },
            { flag: 'sn', country: 'Senegal' },{ flag: 'so', country: 'Somalia' },{ flag: 'sr', country: 'Suriname' },
            { flag: 'st', country: 'Sao Tome' },{ flag: 'sv', country: 'El Salvador' },{ flag: 'sy', country: 'Syria' },
            { flag: 'sz', country: 'Swaziland' },{ flag: 'tc', country: 'Caicos Islands' },{ flag: 'td', country: 'Chad' },
            { flag: 'tf', country: 'French Territories' },{ flag: 'tg', country: 'Togo' },{ flag: 'th', country: 'Thailand' },
            { flag: 'tj', country: 'Tajikistan' }, { flag: 'tk', country: 'Tokelau' },{ flag: 'tl', country: 'Timorleste' },
            { flag: 'tm', country: 'Turkmenistan' },{ flag: 'tn', country: 'Tunisia' },{ flag: 'to', country: 'Tonga' },
            { flag: 'tr', country: 'Turkey' },{ flag: 'tt', country: 'Trinidad' },{ flag: 'tv', country: 'Tuvalu' },
            { flag: 'tw', country: 'Taiwan' },{ flag: 'tz', country: 'Tanzania' },{ flag: 'ua', country: 'Ukraine' },
            { flag: 'ug', country: 'Uganda' },{ flag: 'um', country: 'Us Minor Islands' },{ flag: 'us', country: 'United States' },
            { flag: 'uy', country: 'Uruguay' }, { flag: 'uz', country: 'Uzbekistan' },{ flag: 'va', country: 'Vatican City' },
            { flag: 'vc', country: 'Saint Vincent' },{ flag: 've', country: 'Venezuela' },{ flag: 'vg', country: 'British Virgin Islands' },
            { flag: 'vi', country: 'Us Virgin Islands' },{ flag: 'vn', country: 'Vietnam' },{ flag: 'vu', country: 'Vanuatu' },
            { flag: 'wf', country: 'Wallis And Futuna' },{ flag: 'ws', country: 'Samoa' },{ flag: 'ye', country: 'Yemen' },
            { flag: 'yt', country: 'Mayotte' },{ flag: 'za', country: 'South Africa' },{ flag: 'zm', country: 'Zambia' },
            { flag: 'zw', country: 'Zimbabwe' }
        ]
    },

}).$mount('#dashcontainer');
