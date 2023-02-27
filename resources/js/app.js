/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
window._ = require("lodash");
window.axios = require("axios");

var notifications = [];

function makeNotification(notification) {
  var to = routeNotification(notification);
  var notificationText = makeNotificationText(notification);
  var notification_model = `<li class="uk-padding-remove uk-border-rounded" style="margin-bottom:3px; margin-top:0;"><a href="${to}" class="uk-link-reset">
  <div class="uk-card uk-card-small  grey-text uk-border-rounded white lighten-4">
    <div class="uk-card-header uk-padding-remove uk-border-rounded ${notification.data.color} accent-3" style="border-bottom:1px solid grey;">
        <div class="uk-grid-collapse uk-flex-middle" uk-grid>
            <div class="uk-width-auto" style="padding:0.25em;">
                <span class="mdi mdi-18px ${notification.data.icon} white-text"></span>
            </div>
            <div class="uk-width-expand" style="padding:0.25em;">
                <h5 class="white-text uk-margin-remove-bottom uk-text-bold">${notification.data.title}</h5>
                <p class="white-text uk-text-meta uk-margin-remove-top">${notification.created_at}</p>
            </div>
        </div>
        </div>
    <div class="uk-card-body uk-text-small " style="padding:3px;">
        <p>${notificationText}</p>
    </div>
</div></a></li>`;
  return notification_model;
}
function showNotifications(notifications, target) {
  if (notifications.length) {
    var htmlElements = notifications.map(function(notification) {
      return makeNotification(notification);
    });
    let notification_menu = document.getElementById(target + "Menu");
    notification_menu.innerHTML = htmlElements.join("");
    let notification_btn = document.getElementById(target);
    notification_btn.classList.toggle("yellow-text", true);
    notification_btn.classList.toggle("white-text", false);
    notification_btn.classList.toggle("uk-animation-shake", true);
  } else {
    let notification_menu = document.getElementById(target + "Menu");
    let notification_btn = document.getElementById(target);
    notification_menu.innerHTML = "<li><p>No Notifications</p></li>";
    notification_menu = document.getElementById(target + "Menu");
    notification_btn.classList.toggle("uk-animation-shake", false);
    notification_btn.classList.toggle("grey-text", true);
    notification_btn.classList.toggle("orange-text", false);
  }
}
function addNotifications(newNotifications, target) {
  notifications = _.concat(notifications, newNotifications);
  notifications.slice(0, 5);
  showNotifications(notifications, target);
}
if (Laravel.userId) {
  axios.get("/user/notifications").then(function(res) {
    addNotifications(res.data, "notifications");
  });
}
// get the notification route based on it's type
function routeNotification(notification) {
  var to = "#";
  to = notification.data.action + "?read=" + notification.id;
  return to;
}

// get the notification text based on it's type
function makeNotificationText(notification) {
  var text = "";
  const notification_message = notification.data.message;
  text += notification_message;
  return text;
}
window.Vue = require("vue");
// import VueAxios from "vue-axios";
import Lang from "lang.js";
const default_locale = window.default_language;
const fallback_locale = window.fallback_locale;
import messages from "../assets/js/ll_messages";
import VueSweetalert2 from "vue-sweetalert2";
import Paginate from "vuejs-paginate";
import axios from "axios";
import { vue } from "laravel-mix";
Vue.prototype.trans = new Lang({
  messages: messages,
  locale: default_locale,
  fallback: fallback_locale
});
Vue.use(axios);
Vue.use(VueSweetalert2);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component("paginate", Paginate);
const files = require.context("./", true, /\.vue$/i);
files.keys().map(key =>
  Vue.component(
    key
      .split("/")
      .pop()
      .split(".")[0],
    files(key).default
  )
);

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

if (document.getElementById("admin")) {
  const admin = new Vue({
    el: "#admin"
  });
}
if (document.getElementById("user")) {
  const user = new Vue({
    el: "#user"
  });
}
