/**
=========================================================
* Vue Soft UI Dashboard - v3.0.0
=========================================================

* Product Page: https://creative-tim.com/product/vue-soft-ui-dashboard-laravel
* Copyright 2022 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
*/

import { createApp } from "vue";
import App from "./App.vue";
import store from "./store";
import router from "./router";
import "./assets/css/nucleo-icons.css";
import "./assets/css/nucleo-svg.css";
import SoftUIDashboard from "./soft-ui-dashboard";

import VueTippy from 'vue-tippy'
import 'tippy.js/dist/tippy.css';

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faEdit, faTrash } from '@fortawesome/free-solid-svg-icons';

library.add(faEdit, faTrash);

const appInstance = createApp(App);
appInstance.use(store);
appInstance.use(router);
appInstance.use(SoftUIDashboard);
appInstance.mount("#app");

// Use Tippy plugin
appInstance.use(VueTippy);
  
// Register FontAwesomeIcon globally
appInstance.component('font-awesome-icon', FontAwesomeIcon);