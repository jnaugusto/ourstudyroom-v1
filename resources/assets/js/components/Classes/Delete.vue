<template>
    <div class="general-container-override delete-class-modal user-modal">
        <div class="general-wrap-override">
            <div class="modal-container">
                <span class="modal-close" @click="disposeResources">
                    <i class="remove icon"></i>
                </span>
                <div class="modal-header">
                    <div class="header-title">
                        <strong>Delete</strong>
                        <span>Class Schedule</span>
                    </div>
                    <small class="header-subtext">
                        Displayed below is the schedule that you want to delete.
                    </small>
                </div>
                <div class="modal-nav override">
                    <strong>Class Schedule</strong>
                </div>
                <div class="modal-body ui segment loaders">
                    <div class="ui inverted dimmer" :class="{'active': showLoading}">
                        <div class="ui text loader">Loading</div>
                    </div>
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
                        </div>
                    </div>
                </div>
                <div class="modal-footer view-user">
                    <div class="ui white left labeled icon deny button override tiny custom" @click="cancelDelete">
                        <i class="remove icon"></i>
                        Cancel
                    </div>
                    <div class="ui teal right labeled icon button override tiny custom" @click="deleteClass">
                        Delete Class
                        <i class="checkmark icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-no-image delete-class-modal user-modal"></div>
</template>

<script>

    export default {

        parent: Dashboard.classes,

        props: ['root_url', 'resource'],

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
                $('.delete-class-modal').fadeOut();
            },

            cancelDelete() {
                this.disposeResources();
                setTimeout(function(){$('.view-class-modal').fadeIn();}, 300);
            },

            deleteClass() {
                // Display loading
                this.showLoading = true;

                this.resource.delete({class_id: this.events[0].original.class_id +'_'+ this.events[0].original.student_id}).then((response) => {
                    var flashMessage = {
                        icon: response.data.icon,
                        header: response.data.header,
                        body: response.data.body
                    }
                    $('.delete-class-modal').fadeOut();
                    this.showLoading = false;
                    // Call parent dashboard event to open the "Flash Message"
                    this.$dispatch('callOpenFlashChild', flashMessage);
                    // Add events to main calendar
                    this.$dispatch('refetchEvents');

                    // Clear form
                    this.disposeResources();
                });
            }

        },

        events: {

            getDeleteEvents(event) {
                this.events = [];
                this.events = event;
                this.selectedDate = event.dateOffset;

            }

        }

    }

</script>
