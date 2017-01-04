<template>
    <div class="ui segment override wrapper general-body content">
        <div class="ui segment override header content-header">
            <div class="header-title">
                <i class="calendar icon"></i>
                <div class="title">Classes</div>
            </div>
            <div class="header-actions">
                <button class="ui mini teal button overrides default override icon-only header-button" title="Table View" v-show="!showCalendar" @click="showCalendar = !showCalendar">
                    <i class="tasks icon"></i>
                </button>
                <button class="ui mini teal button overrides default override icon-only header-button" title="Calendar View" v-show="showCalendar" @click="showCalendar = !showCalendar">
                    <i class="calendar icon"></i>
                </button>
                <button class="ui mini teal button overrides default override text-button" @click="addClass">
                    Create Class
                </button>
            </div>
        </div>

        <!-- admin Table -->
        <div class="ui segment loaders general-body-content content-body">
            <div class="ui inverted dimmer">
                <div class="ui text loader">Loading</div>
            </div>

            <div class="content-body-form" v-show="showCalendar">
                <calendar :events.sync="events"></calendar>
            </div>
            <div class="content-body-form"  v-show="!showCalendar">
                <small>Note: You can search for an ID, Date, Name, Email or Course.</small>
                <div class="search-options">
                    <button class="ui icon button white override icon-only" @click="">
                        <i class="refresh icon"></i>
                    </button>
                    <div class="ui input custom-border">
                        <input placeholder="Search..." type="text" class="search-input" v-model="searchQuery">
                    </div>
                    <div class="ui icon top right pointing dropdown button teal override icon-only record-count">
                        <i class="options icon"></i>
                        <div class="menu">
                            <div class="header">Other Options</div>
                            <div class="divider"></div>
                            <div class="ui search input">
                                <label>Show rows:</label>
                                <select v-model="">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="60">60</option>
                                    <option value="70">70</option>
                                    <option value="80">80</option>
                                    <option value="90">90</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="divider"></div>
                            <div class="ui search input sortby">
                                <label>Sort by:</label>
                                <select v-model="">

                                </select>
                            </div>
                            <div class="item"></div>
                        </div>
                    </div>
                </div>
                <table class="ui small very basic table override classes">
                    <thead>
                        <tr>
                            <th class="last-right-padding center aligned">Status</th>
                            <th>#</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Teacher</th>
                            <th>Student</th>
                            <th class="collapsing center aligned">Level</th>
                            <th class="collapsing center aligned">Lesson</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="classes in class_schedules
                                  | filterBy searchClass
                                  | orderBy sortColumn sortOrder
                                  | orderBy active 0
                        ">
                            <td class="collapsing">
                                <div class="ui horizontal label override"
                                     :class="{'teal': classes.active == 1}"
                                >
                                    {{ classes.active == 1 ? 'Active' : 'Inactive' }}
                                </div>
                            </td>
                            <td class="collapsing"><small>#{{ classes.class_id }}</small></td>
                            <td>
                                <span><i class="wait icon"></i> {{ classes.from | moments "MMM DD, YYYY" }}</span>
                            </td>
                            <td>
                                <small>{{ classes.class_type == '1:1' ? 'Single Type(1:1)' : 'Group Type(1:4)' }}</small>
                            </td>
                            <td>
                                <h4 class="ui image header override">
                                    <img :src="root_url + 'images/profile_images/' + classes.teacher_photo" class="ui mini circular image">
                                    <div class="content">
                                        <span>{{ classes.teacher_firstname }} {{ classes.teacher_lastname }}</span>
                                        <div class="sub header">
                                            <small>{{ classes.teacher_email }}</small>
                                        </div>
                                    </div>
                                </h4>
                            </td>
                            <td>
                                <h4 class="ui image header override" v-if="classes.students != null">
                                    <img :src="root_url + 'images/profile_images/' + classes.students.photo" class="ui mini circular image">
                                    <div class="content">
                                        <span>{{ classes.student_firstname }} {{ classes.student_lastname }}</span>
                                        <div class="sub header">
                                            <small>{{ classes.student_course | capitalize }}</small>
                                        </div>
                                    </div>
                                </h4>
                                <small v-if="classes.students == null">(No Student)</small>
                            </td>
                            <td class="center aligned">
                                <small v-if="classes.students != null">{{ classes.student_level }}</small>
                                <small v-if="classes.students == null">(Empty)</small>
                            </td>
                            <td class="center aligned">
                                <small v-if="classes.students != null">{{ classes.lesson }}</small>
                                <small v-if="classes.students == null">(Empty)</small>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Classes Modals -->
    <add-class :root_url="root_url" :resource="resource" :teachers="teachers" :students="students" :event-schedules.sync="event_schedules" :offset="offset"></add-class>
    <view-class :root_url="root_url"></view-class>
    <edit-class :root_url="root_url" :resource="resource" :teachers="teachers" :students="students" :event-schedules.sync="event_schedules" :offset="offset"></edit-class>
    <delete-class :root_url="root_url" :resource="resource"></delete-class>
</template>

<script>

    var calendar = require('../components/Classes/Calendar.vue');
    var addClass = require('../components/Classes/Add.vue');
    var viewClass = require('../components/Classes/View.vue');
    var editClass = require('../components/Classes/Edit.vue');
    var deleteClass = require('../components/Classes/Delete.vue');

    export default {

        parent: Dashboard.app,

        props: ['breadcrumbs'],

        data() {
            return {

                root_url: window.url_rootDIR,
                resource: this.$resource('classes{/class_id}'),
                cur_breadcrumbs: { name: 'Classes', icon: 'calendar' },
                offset: moment().tz(window.timezone).format("Z"),
                showCalendar: true,
                searchQuery: '',
                sortColumn: '',
                sortOrder: 0,
                original_events: [],
                event_schedules: [],
                class_schedules: [],
                teachers: [],
                students: [],
                events: []

            }
        },

        components: {
            'calendar' : calendar,
            'addClass': addClass,
            'viewClass': viewClass,
            'editClass': editClass,
            'deleteClass': deleteClass
        },

        methods: {

            addClass() {
                $('.add-class-modal').fadeIn();
            },

            viewClass() {
                $('.view-class-modal').fadeIn();
            },

            fetchTeachers() {
                // Fetch teachers
                this.resource.get({id: 1}).then((response) => {
                    this.$set('teachers', response.json());
                    this.teachers = _.sortBy(this.teachers, 'staffs.firstname');
                });
            },

            fetchStudents() {
                // Fetch teachers
                this.$http.get('classes/list/students/get').then((response) => {
                    this.$set('students', response.json());
                    this.students = _.sortBy(this.students, 'staffs.firstname');
                });
            },

            fetchEvents() {
                this.offset = this.offset.split(":")[0].replace('0', '');
                this.events = [];
                this.class_schedules = [];
                this.event_schedules = [];

                // Fetch events
                this.$http.get('classes/events/' + moment().tz(window.timezone).subtract(1, 'months').format("YYYY-MM-01")).then((response) => {
                    var self = this;
                    _.forEach(response.data, function(val, key) {
                        var newSched = moment(val.sched_date).add(self.offset, 'hours').format();
                        var schedDate = moment(newSched).format("YYYY-MM-DD"),
                            dateToday = moment().tz(window.timezone).format("YYYY-MM-DD");

                        var schedules = {
                            unique: moment(newSched).format("YYYYMMDDHH") + val.staff_id,
                            from: moment(newSched).format(),
                            to: moment(newSched).add(1, 'hours').format(),
                            active: val.active,
                            class_id: val.class_id,
                            class_type: val.class_type,
                            teacher_id: val.staffs.staff_id,
                            teacher_firstname: val.staffs.firstname,
                            teacher_lastname: val.staffs.lastname,
                            teacher_photo: val.staffs.photo,
                            teacher_email: val.staffs.email_address,
                            students: val.students,
                            student_firstname: (val.students != null)?val.students.firstname:null,
                            student_lastname: (val.students != null)?val.students.lastname:null,
                            student_course: (val.students != null)?val.students.student_class[0].course[0].course_name:null,
                            student_level: (val.students != null)?val.students.student_class[0].level[0].level_name:null,
                            lesson: (val.students != null)?val.students.student_class[0].lesson_num:null
                        };
                        if(!(moment(schedDate).isBefore(dateToday))) self.class_schedules.push(schedules);
                        self.event_schedules.push(schedules);
                        self.events.push({
                            id: val.class_id,
                            title  : 'Teacher '+val.staffs.lastname,
                            start  : moment(newSched).format(),
                            end    : moment(newSched).add(1, 'hours').format(),
                            availability: (val.students != null)?val.students:false
                        });
                    });
                    this.events = _.sortBy(this.events, 'start');
                    this.event_schedules = _.sortBy(this.event_schedules, 'from');
                    // Refetch newly added events
                    this.$broadcast('reload-events');
                    this.$set('original_events', response.data);
                });
            },

            viewEvents(date) {
                var arrViewEvents = [],
                    self = this,
                    selectedDate = moment(date).format("YYYY-MM-DD");
                _.forEach(this.original_events, function(val, key) {
                    var valuedDate = moment(val.sched_date).add(self.offset, 'hours').format('YYYY-MM-DD');
                    if(valuedDate === selectedDate) {
                        arrViewEvents.push({
                            original: val,
                            dateOffset: moment(val.sched_date).add(self.offset, 'hours').format()
                        });
                    }
                });
                arrViewEvents = _.sortBy(arrViewEvents, 'dateOffset');
                // Pass events to view modal
                this.$broadcast('viewEvents', arrViewEvents, date);
                // Open view modal
                this.viewClass();
            },

            searchClass(classes){
                var returnSearch;
                if(classes.students != null) {
                    returnSearch = String(classes.class_id).indexOf(this.searchQuery) != -1 ||
                           classes.teacher_firstname.toLowerCase().indexOf(this.searchQuery) != -1 ||
                           classes.teacher_lastname.toLowerCase().indexOf(this.searchQuery) != -1 ||
                           classes.teacher_email.toLowerCase().indexOf(this.searchQuery) != -1 ||
                           moment(classes.from).format("MMM DD, YYYY").toLowerCase().indexOf(this.searchQuery) != -1 ||
                           moment(classes.from).format("MMMM DD, YYYY").toLowerCase().indexOf(this.searchQuery) != -1 ||
                           classes.student_firstname.toLowerCase().indexOf(this.searchQuery) != -1 ||
                           classes.student_lastname.toLowerCase().indexOf(this.searchQuery) != -1 ||
                           classes.student_course.toLowerCase().indexOf(this.searchQuery) != -1;
                } else {
                    returnSearch = String(classes.class_id).indexOf(this.searchQuery) != -1 ||
                           classes.teacher_firstname.toLowerCase().indexOf(this.searchQuery) != -1 ||
                           classes.teacher_lastname.toLowerCase().indexOf(this.searchQuery) != -1 ||
                           classes.teacher_email.toLowerCase().indexOf(this.searchQuery) != -1 ||
                           moment(classes.from).format("MMM DD, YYYY").toLowerCase().indexOf(this.searchQuery) != -1 ||
                           moment(classes.from).format("MMMM DD, YYYY").toLowerCase().indexOf(this.searchQuery) != -1;
                }

                return returnSearch;
            }

        },

        events: {

            editClass(event) {
                this.$broadcast('getEditEvents', event);
                $('.view-class-modal').fadeOut();
                setTimeout(function(){$('.edit-class-modal').fadeIn();}, 300);
            },

            deleteClass(event) {
                var arrEvent = [];
                arrEvent.push(event);
                this.$broadcast('getDeleteEvents', arrEvent);
                $('.view-class-modal').fadeOut();
                setTimeout(function(){$('.delete-class-modal').fadeIn();}, 300);
            },

            daySelected(date) {
                this.viewEvents(date.format());
            },

            eventSelected(event) {
                this.viewEvents(event.start.format());
            },

            eventLimitClick(cellInfo, jsEvent) {
                this.viewEvents(cellInfo.date.format());
            },

            refetchEvents() {
                this.fetchEvents();
            }

        },

        ready() {

            this.breadcrumbs = this.cur_breadcrumbs;

            // Fetch teachers
            this.fetchTeachers();

            // Fetch students
            this.fetchStudents();

            // Fetch events
            this.fetchEvents();

            // Hide modals
            $('.user-modal').hide();
            //$('.delete-class-modal').fadeIn();

            // Enable dropdown
            $('.ui.dropdown').dropdown();

            $(".dashboard-right .body-right .general-body.content .content-body").mCustomScrollbar({
                scrollButtons:{enable:true},
                theme:"dark-3",
                scrollInertia: 500,
                scrollbarPosition:"inside",
                mouseWheel:{ enable: true },
            });

        }

    }

</script>
