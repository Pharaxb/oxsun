import featherIcons from "feather-icons"
// Initialize Feather Icons
featherIcons.replace()

import './bootstrap';
import "./sidebar.js"
import "./theme.js"

import { initCharts } from './charts.js';

document.addEventListener('DOMContentLoaded', () => {
    initCharts();
});
