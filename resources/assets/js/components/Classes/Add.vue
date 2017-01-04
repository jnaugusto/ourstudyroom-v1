<template>
    <div class="general-container-override add-class-modal user-modal">
        <div class="general-wrap-override">
            <div class="modal-container">
                <span class="modal-close" @click="disposeResources">
                    <i class="remove icon"></i>
                </span>
                <div class="modal-header">
                    <div class="header-title">
                        <strong>Create</strong>
                        <span>Class Schedule</span>
                    </div>
                    <small class="header-subtext">
                        Select the date and time of the class to be added.
                    </small>
                </div>
                <div class="modal-nav override">
                    <strong>Class Schedule</strong>
                </div>
                <div class="modal-body ui segment loaders calendar-modal">
                    <div class="ui inverted active dimmer" v-show="showLoading">
                        <div class="ui text loader">Saving class, please wait...</div>
                    </div>
                    <div class="ui inverted active dimmer add-class-result" v-show="showResult">
                        <div class="div-column" v-show="dataResult.success">
                            <i class="massive teal check circle outline icon"></i>
                            <strong>Class schedule successfully added!</strong>
                            <div class="ui white icon button override tiny custom" @click="showResult = !showResult">OK</div>
                        </div>
                        <div class="div-column" v-show="dataResult.failed">
                            <i class="massive red remove circle outline icon"></i>
                            <strong>Class schedule adding failed!</strong>
                            <div class="ui white icon button override tiny custom" @click="showResult = !showResult">OK</div>
                        </div>
                        <div class="div-column" v-show="dataResult.nohours">
                            <i class="massive yellow warning sign icon"></i>
                            <strong>This student don't have course hours left.</strong>
                            <div class="ui white icon button override tiny custom" @click="showResult = !showResult">OK</div>
                        </div>
                    </div>
                    <div class="body-form ui grid form override">
                        <div class="sixteen wide column ui segment loaders">
                            <div v-el:minicalendar id="minicalendar" v-show="!showTime"></div>
                            <div class="time-selector" v-show="showTime">
                                <div class="field class-type">
                                    <div class="date-selected-wrap">
                                        <label>Date Selected</label>
                                        <strong>{{ dateSelected | moments "dddd, MMMM DD, YYYY" }}</strong>
                                    </div>
                                </div>
                                <div class="two fields">
                                    <div class="field">
                                        <label>TEACHER</label>
                                        <div class="ui search selection dropdown teacher-dropdown teacher">
                                            <input type="hidden">
                                            <div class="default text">Select a teacher</div>
                                            <i class="dropdown icon"></i>
                                            <div class="menu">
                                                <div class="item" v-for="teacher in teachers" @click="teacherSelect(teacher)">
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
                                        <div class="ui selection dropdown sched-time timeSelection disabled add">
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
                                        <div class="ui selection dropdown sched-time disabled add">
                                            <input type="hidden" v-model="timeTo">
                                            <div class="text">{{ timeTo | moments "hA" }}</div>
                                        </div>
                                    </div>
                                </div>
                                <small v-if="!addSched" class="student-hours-error">*Please select another time.</small>
                                <div class="two fields class-type">
                                    <div class="field">
                                        <label>CLASS TYPE</label>
                                        <div class="inline fields">
                                            <div class="field">
                                                <div class="ui radio checkbox">
                                                    <input type="radio" name="addclasstype" checked="checked" @click="classtype = '1:1'">
                                                    <label>Single Type (1:1)</label>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <div class="ui radio checkbox">
                                                    <input type="radio" name="addclasstype" @click="classtype = '1:4'">
                                                    <label>Group Type (1:4)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="two fields">
                                    <div class="field">
                                        <label>STUDENT<small>&nbsp;(Optional)</small></label>
                                        <div class="ui search selection dropdown teacher-dropdown student-dropdown disabled add">
                                            <input type="hidden">
                                            <div class="default text">Select a student</div>
                                            <i class="dropdown icon"></i>
                                            <div class="menu">
                                                <div class="item" @click="studentSelect(0)">
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
                                                <div class="item" v-for="student in students" @click="studentSelect(student)">
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
                                <div class="field select-another-date">
                                    <small @click="showTime = !showTime">Select another date</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" v-show="showTime">
                    <div class="ui white deny button override tiny custom" @click="disposeResources" :class="{'disabled':showLoading}">
                        Cancel
                    </div>
                    <div class="ui teal right labeled icon button override tiny custom disabled" @click="addClass" id="btnAddClass" :class="{'disabled':showLoading}">
                        Add Class
                        <i class="checkmark icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-no-image add-class-modal user-modal"></div>
</template>

<script>

    export default {

        parent: Dashboard.classes,

        props: ['root_url', 'resource', 'teachers', 'students', 'eventSchedules', 'offset'],

        data() {
            return {

                showTime: false,
                showLoading: false,
                showResult: false,
                showForm: true,
                addSched: true,
                dataResult: {
                    success: false,
                    failed: false,
                    nohours: false
                },
                dateSelected: moment().tz(window.timezone).format("YYYY-MM-DD"),
                timeFromSelected: moment(this.dateSelected).format("YYYY-MM-DD 01:00:00"),
                classtype: '1:1',
                studentID: 0,
                teacherInfo: {},
                timeFrom: {
                    time: [],
                    teacher_id: 0
                },

            }
        },

        computed: {

            timeTo() {
                return moment(this.timeFromSelected).add(1, 'hours').format();
            },

        },

        methods: {

            disposeResources() {
                $('.add-class-modal').fadeOut();
                this.setDefault();
            },

            setDefault() {
                $('.ui.dropdown.teacher-dropdown.teacher').dropdown('restore defaults');
                $('#btnAddClass, .sched-time.add, .student-dropdown.add').addClass('disabled');
            },

            dayClick(date) {
                this.setDefault();
                var curDate = moment().tz(timezone.determine().name()).format("YYYY-MM-DD");
                if(!(moment(date).isBefore(curDate))) {
                    this.dateSelected = date.format();
                    this.showTime = true;
                }
            },

            addClass() {
                // Display loading
                this.showLoading = true;

                // Set default value
                this.dataResult.success = false;
                this.dataResult.failed = false;
                this.dataResult.nohours = false;

                var schedule = {
                    unique: moment(this.timeFromSelected).format("YYYYMMDDHH") + this.teacherInfo.user_id,
                    from: moment(this.timeFromSelected).format(),
                    to: moment(this.timeFromSelected).add(1, 'hours').format(),
                    sched_date: moment(this.timeFromSelected).subtract(this.offset, 'hours').format("YYYY-MM-DD HH:mm:ss"),
                    class_type: this.classtype,
                    teacher_id: this.teacherInfo.staffs.staff_id,
                    student_id: this.studentID
                }

                this.resource.save({id: 1}, {data: schedule}).then((response) => {
                    this.showLoading = false;
                    this.showResult = true;

                    if(response.data == 'success') this.dataResult.success = true;
                    else if(response.data == 'failed') this.dataResult.failed = true;
                    else if(response.data == 'nohours') this.dataResult.nohours = true;

                    // Get FROM TIME value and remove time from dropdown
                    var timeValue = moment($('.ui.dropdown.timeSelection').dropdown('get value')).format();
                    this.timeFrom.time.splice(_.findIndex(this.timeFrom.time, function(o) { return o == timeValue; }), 1);
                    // Set default dropdown from time
                    setTimeout(function(){
                        self.timeFromSelected = $('.ui.dropdown.timeSelection .menu .item:nth-child(1)').attr('data-value');
                        $('.ui.dropdown.timeSelection').dropdown('set selected', self.timeFromSelected);
                    }, 100);

                    // Add events to main calendar
                    this.$dispatch('refetchEvents');
                    // Remove time that already exist in the schedule
                    this.filterClassTime();
                });
            },

            teacherSelect(teacher) {
                this.teacherInfo = teacher;
                $('#btnAddClass, .sched-time, .student-dropdown').removeClass('disabled');

                this.filterClassTime();
            },

            studentSelect(student) {
                if(student == 0) this.studentID = 0;
                else this.studentID = student.students.student_id;
            },

            filterClassTime() {
                // Clear timeFrom collection
                this.timeFrom.time = [];

                this.timeFrom.teacher_id = this.teacherInfo.staffs.staff_id;
                var timeToAppend = moment(this.dateSelected).subtract(1, 'days').format("YYYY-MM-DD 23:00:00"), self = this;
                for (var i = 1; i <= 24; i++) {
                    timeToAppend = moment(timeToAppend).add(1, 'hours').format();
                    self.timeFrom.time.push(timeToAppend);
                }
                _.forEach(self.eventSchedules, function(event_val, key) {
                    _.forEach(self.timeFrom.time, function(time_val, key) {
                        if(event_val.from == time_val && event_val.teacher_id == self.timeFrom.teacher_id) {
                            self.timeFrom.time.splice(key, 1);
                            return false;
                        }
                    });
                });
                // Set default dropdown from time
                setTimeout(function(){
                    self.timeFromSelected = $('.ui.dropdown.timeSelection .menu .item:nth-child(1)').attr('data-value');
                    $('.ui.dropdown.timeSelection').dropdown('set selected', self.timeFromSelected);
                }, 100);
            }

        },

        ready() {

            const cal = $(this.$els.minicalendar),
                self = this

            $(this.$els.minicalendar).fullCalendar({
                header: {
                    left:   'prev,next',
                    center: 'title',
                    right: 'today'
                },
                defaultView: 'month',
                editable: false,
                selectable: true,
                aspectRatio: 1.23,
                timeFormat: 'HH:mm',

                dayClick(date) {
                    self.dayClick(date);
                },

                dayRender: function(date, cell){
                    if(moment(date).isBefore(self.dateSelected)) {
                        $(cell).addClass('fc-past');
                    }
                }
            });

        }

    }

</script>
