<template>
    <div class="card card-info card-outline">
        <div class="card-header">
            <h3 class="card-title">Events Calendar</h3>
        </div>
        <div class="card-body p-0">
            <div ref="calendarElement"></div>
        </div>
    </div>
</template>

<script>
import {Calendar} from 'admin-lte/plugins/fullcalendar/main';
import dayGridPlugin from 'admin-lte/plugins/fullcalendar-daygrid/main';
import timeGridPlugin from 'admin-lte/plugins/fullcalendar-timegrid/main';
import bootstrapPlugin from 'admin-lte/plugins/fullcalendar-bootstrap/main';
import interactionPlugin from 'admin-lte/plugins/fullcalendar-interaction/main';

export default {
    mounted() {
        this.initializeCalendar();
    },
    data() {
        return {
            calendar: null,
            events: [],
        }
    },
    methods: {
        initializeCalendar() {
            let calendarElement = this.$refs.calendarElement;
            let date = new Date();
            let d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();
            this.events = [
                {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false,
                    backgroundColor: '#0073b7',
                    borderColor: '#0073b7'
                },
                {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false,
                    backgroundColor: '#0073b7',
                    borderColor: '#0073b7'
                },
                {
                    title: 'Birthday Party',
                    start: new Date(y, m, d + 1, 19, 0),
                    end: new Date(y, m, d + 1, 22, 30),
                    allDay: false,
                    backgroundColor: '#0073b7',
                    borderColor: '#0073b7'
                },
                {
                    title: 'Click for Google',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'https://google.com/',
                    backgroundColor: '#0073b7',
                    borderColor: '#0073b7'
                }
            ];
            this.calendar = new Calendar(calendarElement, {
                plugins: [bootstrapPlugin, interactionPlugin, dayGridPlugin, timeGridPlugin],
                header: {
                    left: 'prev,next, today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',
                events: this.events, //Random default events
                editable: true,
                droppable: false, // this allows things to be dropped onto the calendar !!!
            });

            this.calendar.render();
        }
    }
}
</script>

<style scoped>

</style>
