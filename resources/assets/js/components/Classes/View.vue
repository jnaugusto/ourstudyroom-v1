<template>
    <div class="general-container-override view-class-modal user-modal">
        <div class="general-wrap-override">
            <div class="modal-container">
                <span class="modal-close" @click="disposeResources">
                    <i class="remove icon"></i>
                </span>
                <div class="modal-header">
                    <div class="header-title">
                        <strong>View</strong>
                        <span>Class Schedule</span>
                    </div>
                    <small class="header-subtext">
                        Displayed below are the classes for this today.
                    </small>
                </div>
                <div class="modal-nav override">
                    <strong>Class Schedule</strong>
                </div>
                <div class="modal-body ui segment loaders">
                    <div class="body-title">
                        {{ selectedDate | moments "MMMM DD, YYYY" }} Classes
                    </div>
                    <div class="body-form ui grid form override view-user">
                        <div v-for="event in events" class="event-wrapper" data-from="{{ event.dateOffset }}">
                            <div class="event-left">
                                <span class="fc-time">
                                    <div class="fc-time-only">{{ event.dateOffset | moments "hh" }}</div>
                                    <div class="fc-time-zone">{{ event.dateOffset | moments "A" }}</div>
                                </span>
                                <span class="fc-title ui cards">
                                    <div class="card">
                                        <div class="content">
                                            <img class="left floated mini ui image" :src="root_url + 'images/profile_images/' + event.original.staffs.photo">
                                            <div class="header">
                                                {{ event.original.staffs.firstname | cutFirstname event.original.staffs.firstname }} {{ event.original.staffs.lastname }}
                                            </div>
                                            <div class="meta">
                                                <i class="info circle icon"></i>
                                                Teacher-{{(event.original.class_type == '1:1')?'Single type':'Group type'}}({{event.original.class_type}})/Class No. {{ event.original.class_id }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card" v-if="event.original.student_id != null">
                                        <div class="content">
                                            <img class="left floated mini ui image" :src="(event.original.student_id != null)?root_url + 'images/profile_images/' + event.original.students.photo:''">
                                            <div class="header">
                                                {{ (event.original.student_id != null)?event.original.students.firstname+' '+event.original.students.lastname:0}}
                                            </div>
                                            <div class="meta">
                                                <i class="ticket icon"></i>
                                                Student-Student No. {{(event.original.student_id != null)?event.original.students.student_id:0}}
                                            </div>
                                        </div>
                                    </div>
                                </span>
                            </div>
                            <div class="event-right">
                                <i class="edit icon grey" @click="editClass(event)"></i>
                                <i class="remove circle icon grey" @click="deleteClass(event)"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer view-user">
                    <div class="ui teal deny button override tiny custom" @click="disposeResources">
                        Close
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-no-image view-class-modal user-modal"></div>
</template>

<script>

    export default {

        parent: Dashboard.classes,

        props: ['root_url'],

        data() {
            return {

                showLoading: false,
                selectedDate: moment().tz(window.timezone).format(),
                events: [],

            }
        },

        filter: {

            customFirst(firstname) {
                return firstname.split(" ")[0];
            }

        },

        methods: {

            disposeResources() {
                $('.view-class-modal').fadeOut();
            },

            editClass(event) {
                this.$dispatch('editClass', event);
            },

            deleteClass(event) {
                this.$dispatch('deleteClass', event);
            }

        },

        events: {

            viewEvents(events, date) {
                this.events = [];
                this.events = events;
                this.selectedDate = date;
                var self = this;
                setTimeout(function() {
                    $('.event-wrapper').each( function( index, element ){
                        $(this).find('.fc-overlay').remove();
                        var date = moment().tz(window.timezone).format();
                        var from = moment($(this).attr('data-from')).format();
                        if(moment(from).isBefore(date)) {
                            $(this).find('.event-right').remove();
                            $(this).append('<div class="fc-overlay"></div>');
                        }
                    });
                }, 100);

            }

        }

    }

</script>
