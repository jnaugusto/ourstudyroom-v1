<template>
    <div class="general-container-override edit-class-modal user-modal">
        <div class="general-wrap-override">
            <div class="modal-container">
                <span class="modal-close" @click="cancelEdit">
                    <i class="remove icon"></i>
                </span>
                <div class="modal-header">
                    <div class="header-title">
                        <strong>Edit</strong>
                        <span>Class Schedule</span>
                    </div>
                    <small class="header-subtext">
                        Double check first before changing the class schedule.
                    </small>
                </div>
                <div class="modal-nav override">
                    <strong>Class Schedule</strong>
                </div>
                <div class="modal-body ui segment loaders">
                    <div class="ui inverted active dimmer" v-show="showLoading">
                        <div class="ui text loader">Loading</div>
                    </div>
                    <div class="ui inverted active dimmer add-class-result" v-show="showResult">
                        <div class="div-column">
                            <i class="massive yellow warning sign icon"></i>
                            <strong>This student don't have course hours left.</strong>
                            <div class="ui white icon button override tiny custom" @click="showResult = !showResult">OK</div>
                        </div>
                    </div>
                    <div class="body-title">
                        {{ selectedDate | moments "MMMM DD, YYYY" }} Class
                    </div>
                    <div class="body-form ui grid form override">
                        <div class="sixteen wide column ui segment loaders">
                            <div class="time-selector">
                                <div class="two fields">
                                    <div class="field">
                                        <label>TEACHER</label>
                                        <div class="ui search selection dropdown teacher-dropdown teacher">
                                            <input type="hidden">
                                            <div class="default text">Select a teacher</div>
                                            <i class="dropdown icon"></i>
                                            <div class="menu">
                                                <div class="item" v-for="teacher in teachers" data-value="{{teacher.staffs.staff_id}}" @click="teacherSelect(teacher)">
                                                    <h4 class="ui image header override">
                                                        <img :src="root_url + 'images/profile_images/' + teacher.staffs.photo" class="ui mini circular image">
                                                        <div class="content">
                                                            <span>{{ teacher.staffs.firstname + ' ' + teacher.staffs.lastname }}</span>
                                                            <div class="sub header">
                                                                <small>{{ teacher.roles.role_name | capitalize }}</small>
                                                            </div>
                                                        </div>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="two fields">
                                    <div class="field">
                                        <label>FROM TIME</label>
                                        <div class="ui selection dropdown sched-time timeSelection">
                                            <input type="hidden" v-model="timeFromSelected">
                                            <div class="default text">Select Time</div>
                                            <i class="dropdown icon"></i>
                                            <div class="menu">
                                                <div class="item" v-for="time in timeFrom.time" track-by="$index" data-value="{{ time | moments 'YYYY-MM-DD HH:00:00' }}">
                                                    {{ time | moments "hA" }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label>TO TIME</label>
                                        <div class="ui selection dropdown">
                                            <input type="hidden">
                                            <div class="text">{{ timeTo | moments "hA" }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="two fields class-type">
                                    <div class="field">
                                        <label>CLASS TYPE</label>
                                        <div class="inline fields">
                                            <div class="field">
                                                <div class="ui radio checkbox">
                                                    <input type="radio" name="editclasstype" @click="editEvent.original.class_type = '1:1'" :checked="classType_single">
                                                    <label>Single Type (1:1)</label>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <div class="ui radio checkbox">
                                                    <input type="radio" name="editclasstype" @click="editEvent.original.class_type = '1:4'" :checked="!classType_single">
                                                    <label>Group Type (1:4)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="two fields">
                                    <div class="field">
                                        <label>STUDENT<small>&nbsp;(Optional)</small></label>
                                        <div class="ui search selection dropdown teacher-dropdown student-dropdown student">
                                            <input type="hidden">
                                            <div class="default text">Select a student</div>
                                            <i class="dropdown icon"></i>
                                            <div class="menu">
                                                <div class="item" data-value="0" @click="studentSelect(0)">
                                                    <h4 class="ui image header override">
                                                        <img :src="root_url + 'images/profile_images/default.png'" class="ui mini circular image">
                                                        <div class="content">
                                                            <span>NO STUDENT SELECTED</span>
                                                            <div class="sub header">
                                                                <small>No student selected</small>
                                                            </div>
                                                        </div>
                                                    </h4>
                                                </div>
                                                <div class="item" v-for="student in students" data-value="{{student.students.student_id}}" @click="studentSelect(student)">
                                                    <h4 class="ui image header override">
                                                        <img :src="root_url + 'images/profile_images/' + student.students.photo" class="ui mini circular image">
                                                        <div class="content">
                                                            <span>{{ student.students.firstname + ' ' + student.students.lastname }}</span>
                                                            <div class="sub header">
                                                                <small>{{ student.roles.role_name | capitalize }}</small>
                                                            </div>
                                                        </div>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer view-user">
                    <div class="ui white left labeled icon deny button override tiny custom" @click="cancelEdit">
                        <i class="remove icon"></i>
                        Cancel
                    </div>
                    <div class="ui teal right labeled icon button override tiny custom" @click="updateClass">
                        Update Class
                        <i class="checkmark icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-no-image edit-class-modal user-modal"></div>
</template>

<script>

    export default {

        parent: Dashboard.classes,

        props: ['root_url', 'resource', 'teachers', 'students', 'eventSchedules', 'offset'],

        data() {
            return {

                showLoading: false,
                showResult: false,
                selectedDate: moment().tz(window.timezone).format("YYYY-MM-DD"),
                timeFromSelected: moment(this.selectedDate).format("YYYY-MM-DD 01:00:00"),
                classType_single: true,
                editEvent: [],
                timeFrom: {
                    time: [],
                    teacher_id: 0
                },

            }
        },

        filter: {

            customFirst(firstname) {
                return firstname.split(" ")[0];
            }

        },

        computed: {

            timeTo() {
                return moment(this.timeFromSelected).add(1, 'hours').format();
            },

        },

        methods: {

            disposeResources() {
                $('.edit-class-modal').fadeOut();
            },

            cancelEdit() {
                this.disposeResources();
                setTimeout(function(){$('.view-class-modal').fadeIn();}, 300);
            },

            teacherSelect(teacher) {
                this.editEvent.original.staff_id = teacher.staffs.staff_id;
            },

            studentSelect(student) {
                if(student == 0) this.editEvent.original.student_id = null;
                else {
                    this.editEvent.original.student_id = student.students.student_id;
                    this.editEvent.original.students = student.students;
                }
            },

            updateClass() {
                // Display loading
                this.showLoading = true;

                // Update sched_date from the array
                this.editEvent.original.sched_date = moment(this.timeFromSelected).subtract(this.offset, 'hours').format("YYYY-MM-DD HH:mm:ss");

                if(this.editEvent.original.student_id == this.editEvent.original.past_student_id) {
                    this.editEvent.original.past_student_id = null;
                    this.editEvent.original.allowHourUpdate = false;
                } else this.editEvent.original.allowHourUpdate = true;

                this.resource.update({class_id: this.editEvent.original.class_id}, {data: this.editEvent.original}).then((response) => {
                    this.showLoading = false;

                    if(response.data == 'nohours') this.showResult = true;
                    else {
                        var flashMessage = {
                            icon: response.data.icon,
                            header: response.data.header,
                            body: response.data.body
                        }

                        $('.edit-class-modal').fadeOut();

                        // Call parent dashboard event to open the "Flash Message"
                        this.$dispatch('callOpenFlashChild', flashMessage);
                        // Add events to main calendar
                        this.$dispatch('refetchEvents');

                        // Clear form
                        this.disposeResources();
                    }
                });
            },

            filterClassTime(teacher_id) {
                // Clear timeFrom collection
                this.timeFrom.time = [];

                this.timeFrom.teacher_id = teacher_id;
                var timeToAppend = moment(this.selectedDate).subtract(1, 'days').format("YYYY-MM-DD 23:00:00"), self = this;
                for (var i = 1; i <= 24; i++) {
                    timeToAppend = moment(timeToAppend).add(1, 'hours').format();
                    self.timeFrom.time.push(timeToAppend);
                }
                _.forEach(self.eventSchedules, function(event_val, key) {
                    _.forEach(self.timeFrom.time, function(time_val, key) {
                        if((event_val.from == time_val && event_val.teacher_id == self.timeFrom.teacher_id) && event_val.from != self.timeFromSelected) {
                            self.timeFrom.time.splice(key, 1);
                            return false;
                        }
                    });
                });

                // Set default dropdown from time
                setTimeout(function(){
                    $('.ui.dropdown.timeSelection').dropdown('set selected', moment(self.timeFromSelected).format('YYYY-MM-DD HH:00:00'));
                    $('.ui.dropdown.timeSelection').dropdown('set text', moment(self.timeFromSelected).format('hA'));
                }, 100);
            }

        },

        events: {

            getEditEvents(event) {
                this.editEvent = [];
                this.editEvent = event;
                this.selectedDate = event.dateOffset;
                this.timeFromSelected = event.dateOffset;
                this.classType_single = (event.original.class_type == '1:1')?true:false;
                this.editEvent.original.past_student_id = event.original.student_id;
                this.editEvent.original.allowHourUpdate = false;
                this.filterClassTime(event.original.staff_id);

                // Set default dropdown from time
                setTimeout(function(){
                    $('.ui.dropdown.teacher-dropdown.teacher').dropdown('set selected', event.original.staff_id);
                    if(event.original.student_id!=null) $('.ui.dropdown.student-dropdown.student').dropdown('set selected', event.original.student_id);
                    else $('.ui.dropdown.student-dropdown.student').dropdown('restore defaults');
                }, 100);
            },

        }

    }

</script>
