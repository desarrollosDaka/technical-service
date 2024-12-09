<div x-show="displayCalendarMode === 'calendar'">
    <div id="calendar-container-visits" wire:ignore>
    </div>
</div>

@script
    <script>
        const calendarEl = $wire.el.querySelector('#calendar-container-visits');
        const calendar = new Calendar(calendarEl, {
            plugins: [multiMonthPlugin],
            initialView: 'multiMonthYear',
        });
        calendar.render();
    </script>
@endscript
