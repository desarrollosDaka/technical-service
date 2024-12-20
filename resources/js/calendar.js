import { Calendar } from '@fullcalendar/core';
import multiMonthPlugin from '@fullcalendar/multimonth';
import dayGridPlugin from '@fullcalendar/daygrid'; // Importa el plugin para vista mensual
import esLocale from '@fullcalendar/core/locales/es';

window.Calendar = Calendar;
window.multiMonthPlugin = multiMonthPlugin;
window.dayGridPlugin = dayGridPlugin;
window.esLocale = esLocale;

Alpine.data('calendar', ({ visits }) => ({
    modal: {
        title: '',
        description: '',
    },
    init() {
        const calendarEl = this.$el.querySelector('#calendar-container-visits');

        // Encuentra la fecha de la última visita
        let initialDate;

        if (visits.length > 0) {
            const lastVisitDate = visits.reduce((latest, visit) => {
                return new Date(latest.visit_date) > new Date(visit.visit_date) ? latest : visit;
            }).visit_date;

            initialDate = lastVisitDate;
        } else {
            initialDate = new Date().toISOString().slice(0, 10); // Fecha actual en formato ISO
        }

        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin], // Usa dayGridPlugin para vista mensual
            locale: esLocale,
            initialView: 'dayGridMonth', // Cambia a vista mensual
            themeSystem: 'minty',
            initialDate, // Establece la fecha inicial al mes de la última visita
            events: visits.map(visit => ({
                title: visit.title,
                start: visit.visit_date,
                description: visit.observations,
            })),
            eventClick: (info) => {
                $openModal('simpleModal');
                document.getElementById('modal-title').textContent = info.event.title;
                document.getElementById('modal-description').textContent = info.event.extendedProps.description;
                document.getElementById('modal-date').textContent = info.event._instance.range.start.toLocaleDateString();
            }
        });

        calendar.render();
    }
}));
