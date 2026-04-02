import Alpine from "alpinejs";
import collapse from '@alpinejs/collapse';
import intersect from '@alpinejs/intersect';
import "./dashboard.js";

window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.plugin(intersect);
Alpine.start();
