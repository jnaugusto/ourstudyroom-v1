<template>
    <div v-el:calendar id="calendar"></div>
</template>

<script>

    export default {

        parent: Dashboard.classes,

        props: {
            events: {
                default() {
                    return []
                },
            },

            eventSources: {
                default() {
                    return []
                },
            },

            editable: {
                default() {
                    return false
                },
            },

            selectable: {
                default() {
                    return false
                },
            },

            selectHelper: {
                default() {
                    return false
                },
            },

            header: {
                default() {
                    return {
                        left:   'prev,next today',
                        center: 'title',
                        right:  'month,listMonth'
                    }
                },
            },

            defaultView: {
                default() {
                    return 'month'
                },
            },

            sync: {
                default() {
                    return false
                }
            },
        },

        ready() {
            const cal = $(this.$els.calendar),
                self = this

            $(this.$els.calendar).fullCalendar({
                header: this.header,
                defaultView: this.defaultView,
                editable: this.editable,
                selectable: this.selectable,
                selectHelper: this.selectHelper,
                aspectRatio: .98,
                height: "100%",
                timeFormat: 'hh(:mm)a',
                eventLimitText: 'more classes',
                events: self.events,
                eventLimit: true,
                eventSources: self.eventSources,

                eventRender(event, element) {
                    if (this.sync) {
                        self.events = cal.fullCalendar('clientEvents')
                    }
                    if(!event.availability) {
                        $(element).find('.fc-content').prepend('<i class="check circle icon green"></i>');
                    } else {
                        $(element).find('.fc-content').prepend('<i class="ban icon red"></i>');
                    }
                    var date = moment().tz(window.timezone).format();
                    if(moment(event.start.format()).isBefore(date) && $(element).attr('class') != "fc-list-item") {
                        $(element).prepend('<div class="fc-overlay"></div>');
                    }
                },

                eventDestroy(event) {
                    if (this.sync) {
                        self.events = cal.fullCalendar('clientEvents')
                    }
                },

                eventClick(event) {
                    self.$dispatch('eventSelected', event)
                },

                eventDrop(event) {
                    self.$dispatch('event-drop', event)
                },

                eventResize(event) {
                    self.$dispatch('event-resize', event)
                },

                eventLimitClick(cellInfo, jsEvent) {
                    self.$dispatch('eventLimitClick', cellInfo, jsEvent)
                },

                select(start, end, jsEvent) {
                    self.$dispatch('eventCreated', {
                        start,
                        end,
                        allDay: !start.hasTime() && !end.hasTime(),
                    })
                },

                dayClick(date) {
                    self.$dispatch('daySelected', date)
                },
            })
        },

        watch: {
            events: {
                deep: true,
                handler(val) {
                    $(this.$els.calendar).fullCalendar('rerenderEvents')
                },
            }
        },

        events: {
            'remove-event'(event) {
                $(this.$els.calendar).fullCalendar('removeEvents', event.id)
            },
            'rerender-events'(event) {
                $(this.$els.calendar).fullCalendar('rerenderEvents')
            },
            'refetch-events'(event) {
                $(this.$els.calendar).fullCalendar('refetchEvents')
            },
            'render-event'(event) {
                $(this.$els.calendar).fullCalendar('renderEvent', event)
            },
            'reload-events'() {
                $(this.$els.calendar).fullCalendar('removeEvents')
                $(this.$els.calendar).fullCalendar('addEventSource', this.events)
            },
            'rebuild-sources'() {
                $(this.$els.calendar).fullCalendar('removeEvents')
                this.eventSources.map(event => {
                    $(this.$els.calendar).fullCalendar('addEventSource', event)
                })
            },
        },
    }
</script>
