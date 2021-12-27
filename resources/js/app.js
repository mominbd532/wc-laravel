/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';

import { Form, HasError, AlertError } from 'vform';
window.Form = Form;

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

import Swal from 'sweetalert2';


const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
window.Swal = Swal;
window.Toast = Toast;

import WooCommerceRestApi from "@woocommerce/woocommerce-rest-api";

const diniApi = new WooCommerceRestApi({
    url: process.env.MIX_WC_URL,
    consumerKey: process.env.MIX_WC_CONSUMER_KEY,
    consumerSecret: process.env.MIX_WC_CONSUMER_SECRET,
    version: process.env.MIX_WC_VERSION
});

window.diniApi = diniApi;

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  });


Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


/**
 * Routes imports and assigning
 */
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import routes from './routes';

const router = new VueRouter({
    mode: 'history',
    routes
});
// Routes End


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// Components
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('dashboard', require('./components/Dashboard.vue'));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);

// Filter Section

Vue.filter('myDate',function(created){
    return moment(created).format('MMMM Do YYYY');
});

Vue.filter('yesno', value => (value ? '<i class="fas fa-check green"></i>' : '<i class="fas fa-times red"></i>'));

// end Filter

Vue.component('example-component', require('./components/ExampleComponent.vue'));



const app = new Vue({
    el: '#app',
    router
});


// Canva code

var VELOCITY = 1;
var PARTICLES = 400;

var mouse = {x:0, y:0};
var particles = [];
var colors = [ "#000000","#FF0000","#FFFF00" ];
var canvas = document.getElementById('projector');
var context;

if (canvas && canvas.getContext) {
    context = canvas.getContext('2d');

    for( var i = 0; i < PARTICLES; i++ ) {
        particles.push( {
            x: Math.random()*window.innerWidth,
            y: Math.random()*window.innerHeight,
            vx: ((Math.random()*(VELOCITY*2))-VELOCITY),
            vy: ((Math.random()*(VELOCITY*2))-VELOCITY),
            size: 1+Math.random()*3,
            color: colors[ Math.floor( Math.random() * colors.length ) ]
        } );
    }

    Initialize();
}

function Initialize() {
    canvas.addEventListener('mousemove', MouseMove, false);
    window.addEventListener('mousedown', MouseDown, false);
    window.addEventListener('resize', ResizeCanvas, false);
    setInterval( TimeUpdate, 40 );

    ResizeCanvas();
}

function TimeUpdate(e) {

    context.clearRect(0, 0, window.innerWidth, window.innerHeight);

    var len = particles.length;
    var particle;

    for( var i = 0; i < len; i++ ) {
        particle = particles[i];

        if (!particle.frozen) {
            particle.x += particle.vx;
            particle.y += particle.vy;

            if (particle.x > window.innerWidth) {
                particle.vx = -VELOCITY - Math.random();
            }
            else if (particle.x < 0) {
                particle.vx = VELOCITY + Math.random();
            }
            else {
                particle.vx *= 1 + (Math.random() * 0.005);
            }

            if (particle.y > window.innerHeight) {
                particle.vy = -VELOCITY - Math.random();
            }
            else if (particle.y < 0) {
                particle.vy = VELOCITY + Math.random();
            }
            else {
                particle.vy *= 1 + (Math.random() * 0.005);
            }

            var distanceFactor = DistanceBetween( mouse, particle );
            distanceFactor = Math.max( Math.min( 15 - ( distanceFactor / 10 ), 10 ), 1 );

            particle.currentSize = particle.size*distanceFactor;
        }

        context.fillStyle = particle.color;
        context.beginPath();
        context.arc(particle.x,particle.y,particle.currentSize,0,Math.PI*2,true);
        context.closePath();
        context.fill();

    }
}

function MouseMove(e) {
    mouse.x = e.layerX;
    mouse.y = e.layerY;
}

function MouseDown(e) {
    var len = particles.length;

    var closestIndex = 0;
    var closestDistance = 1000;

    for( var i = 0; i < len; i++ ) {
        var thisDistance = DistanceBetween( particles[i], mouse );

        if( thisDistance < closestDistance ) {
            closestDistance = thisDistance;
            closestIndex = i;
        }

    }

    if (closestDistance < particles[closestIndex].currentSize) {
        particles[closestIndex].frozen = true;
    }
}

function ResizeCanvas(e) {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}

function DistanceBetween(p1,p2) {
    var dx = p2.x-p1.x;
    var dy = p2.y-p1.y;
    return Math.sqrt(dx*dx + dy*dy);
}
