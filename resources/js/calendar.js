import { Calendar } from '@fullcalendar/core';
import multiMonthPlugin from '@fullcalendar/multimonth';
import esLocale from '@fullcalendar/core/locales/es';

window.Calendar = Calendar;
window.multiMonthPlugin = multiMonthPlugin;
window.esLocale = esLocale;

Alpine.data('calendar', ({ visits }) => ({
    modal: {
        title: '',
        description: '',
    },
    init() {
        const calendarEl = this.$el.querySelector('#calendar-container-visits');
        // const visits = @json($visits);
        const calendar = new Calendar(calendarEl, {
            plugins: [multiMonthPlugin],
            locale: esLocale,
            initialView: 'multiMonthYear',
            themeSystem: 'minty',
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
