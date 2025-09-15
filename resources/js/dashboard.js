import featherIcons from "feather-icons"
// Initialize Feather Icons
featherIcons.replace()


import './bootstrap';
import './jquery-global.js';
import "./sidebar.js"
import "./theme.js"
import "./create-ad.js"

import { initCharts } from './charts.js';

document.addEventListener('DOMContentLoaded', () => {
    initCharts();
});

import persianDate from 'persian-date/dist/persian-date.min';
window.persianDate = persianDate;
import 'persian-datepicker/dist/js/persian-datepicker.min';

import select2 from 'select2';
select2(jQuery);

import Swal from 'sweetalert2';

const Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
document.addEventListener('livewire:initialized', () => {
    Livewire.on('toast', (event) => {
        Toast.fire({
            icon: event.icon,
            title: event.title
        });
    });
})
