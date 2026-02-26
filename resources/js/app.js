import './bootstrap';


import Alpine from 'alpinejs';
import ticketBoard from './components/ticketBoard';
import unit from './components/unit';
import toast from './components/toast';


window.Alpine = Alpine;

Alpine.data('ticketBoard', ticketBoard);
Alpine.data('unit', unit);
Alpine.data('toast', toast);


Alpine.start();
