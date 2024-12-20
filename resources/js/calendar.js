import { Calendar } from '@fullcalendar/core';
import multiMonthPlugin from '@fullcalendar/multimonth';
import dayGridPlugin from '@fullcalendar/daygrid'; // Importa el plugin para vista mensual
import esLocale from '@fullcalendar/core/locales/es';
import _ from 'lodash';
import dayjs from 'dayjs';

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
                ...visit,
            })),
            eventClick: (info) => {
                $openModal('simpleModal');
                document.getElementById('modal-title').textContent = info.event.title;
                document.getElementById('modal-observation').textContent = info.event.extendedProps.observation;
                document.getElementById('modal-date').textContent = info.event._instance.range.start.toLocaleDateString();

                let reprogramming = '';
                _.each(info.event.extendedProps.reprogramming, (value, key) => {
                    let listReprogramming = '';

                    _.each(value, (item) => {
                        /* html */
                        listReprogramming += `
                            <div class="flex justify-between mt-2 text-sm">
                                <p><b>Motivo:</b> ${item.extend_reason}</p>
                                <div class="border-l pl-2">
                                    <p>Fecha previa: ${dayjs(item.old_date).format('DD/MM/YYYY HH:mm')}</p>
                                    <p>Fecha nueva: ${dayjs(item.new_date).format('DD/MM/YYYY HH:mm')}</p>
                                </div>
                            </div>
                        `;
                    });

                    /* html */
                    reprogramming += `
                        <div class="border-t pt-2">
                            <h5 class="font-semibold text-slate-700 text-sm">Reprogramaciones hecha por ${key === 'client' ? 'el cliente' : ''}${key === 'technical' ? 'el técnico' : ''}${key === 'other' ? 'Otro motivo' : ''}</h5>
                            ${listReprogramming}
                        </div>
                    `;
                });

                if (reprogramming !== '') {
                    document.getElementById('modal-reprogramming').innerHTML = reprogramming;
                }
            }
        });

        calendar.render();
    }
}));
