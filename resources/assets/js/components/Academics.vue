<template>
    <div class="ui segment override wrapper general-body content">
        <div class="ui segment override header content-header">
            <div class="header-title">
                <i class="star icon"></i>
                <div class="title">Academics</div>
            </div>
            <div class="header-actions">
                <button class="ui mini teal button overrides default override text-button" @click="addUser">
                    Create User
                </button>
            </div>
        </div>

        <!-- admin Table -->
        <div class="ui segment loaders general-body-content content-body">
            <div class="ui inverted dimmer" :class="{ 'active':  users.length == 0}">
                <div class="ui text loader">Loading</div>
            </div>
            <div class="content-body-form">
                <small>Note: You can search for an ID, Name, Username, Email or Role.</small>
                <div class="search-options">
                    <button class="ui icon button white override icon-only" @click="fetchUsers('')">
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
                                <select v-model="showRows">
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
                                <select v-model="sortColumn">
                                    <option v-for="col in columns" :value="col.columnValue" @click="sortBy">{{ col.columnName }}</option>
                                </select>
                            </div>
                            <div class="item"></div>
                        </div>
                    </div>
                </div>
                <table class="ui small very basic table override">
                    <thead>
                        <tr>
                            <th class="center aligned">Status</th>
                            <th class="center aligned">#</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Username</th>
                            <th>Email Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users.data
                            | filterBy searchUser
                            | orderBy sortColumn sortOrder
                            | orderBy active 0
                        ">
                            <td class="collapsing center aligned">
                                <i class="check icon green td-status" v-if="user.active == 1"></i>
                                <i class="remove icon red td-status" v-if="user.active != 1"></i>
                            </td>
                            <td class="collapsing">
                                <small><div class="ui horizontal label override number">{{ user.user_id }}</div></small>
                            </td>
                            <td>
                                <h4 class="ui image header override">
                                    <img :src="root_url + 'images/profile_images/' + user.staffs.photo" class="ui mini circular image">
                                    <div class="content">
                                        <span>{{ user.staffs.firstname }} {{ user.staffs.lastname }}</span>
                                        <div class="sub header">
                                            <small>Created {{ user.created_at | moments "MM.DD.YYYY"}}</small>
                                        </div>
                                    </div>
                                </h4>
                            </td>
                            <td>
                                <span>{{ user.roles.role_name }}</span>
                            </td>
                            <td>
                                <span><i class="user icon"></i> {{ user.username }}</span>
                            </td>
                            <td>
                                <span><i class="mail icon"></i> {{ user.staffs.email_address }}</span>
                            </td>
                            <td class="collapsing">
                                <div class="ui buttons btn-actions">
                                    <button class="ui icon button mini" @click="viewUser(user)" title="View">
                                        <i class="search icon"></i>
                                    </button>
                                    <button class="ui icon button mini" @click="editUser(user)" title="Edit">
                                        <i class="edit icon"></i>
                                    </button>
                                    <button v-if="user.active != 0" class="ui icon button mini" @click="deleteUser(user)" title="Delete">
                                        <i class="trash icon"></i>
                                    </button>
                                    <button v-if="user.active == 0" class="ui icon button mini" @click="restoreUser(user)" title="Restore">
                                        <i class="refresh icon"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pagination-wrapper">
            <label>Showing {{ tableInfo.firstItem }} to {{ tableInfo.lastItem }} of {{ tableInfo.total }} entries</label>
            <div class="ui pagination menu override default" v-show="pages.length > 0">
                <a class="icon item"
                   :class="{ 'disabled': users.current_page == 1 }"
                   @click.prevent="fetchUsers('?page=1')"
                >
                    <i class="left chevron icon"></i>
                </a>
                <a class="item"
                   v-for="page in pages"
                   :class="{ 'active': users.current_page == page }"
                   @click.prevent="fetchUsers('?page=' + page)"
                >
                    {{ page }}
                </a>
                <a class="icon item"
                   :class="{ 'disabled': users.current_page == users.last_page }"
                   @click.prevent="fetchUsers('?page=' + users.last_page)"
                >
                    <i class="right chevron icon"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Account Modals -->
    <view-user :root_url="root_url"></view-user>
    <add-user :root_url="root_url" :resource="resource" :userroles="userroles"></add-user>
    <edit-user :root_url="root_url" :resource="resource" :userroles="userroles"></edit-user>
    <delete-user :root_url="root_url" :resource="resource"></delete-user>
</template>

<script>
    var addUser = require('../components/Academics/Add.vue');
    var viewUser = require('../components/Academics/View.vue');
    var editUser = require('../components/Academics/Edit.vue');
    var deleteUser = require('../components/Academics/Delete.vue');

    export default {

        parent: Dashboard.app,

        props: ['breadcrumbs'],

        data() {
            return {

                root_url: window.url_rootDIR,
                resource: this.$resource('acad{/user_id}'),
                cur_breadcrumbs: { name: 'Academics - View Teachers', icon: 'star' },
                userroles: {},
                users: [],
                tableInfo: [],
                pages: [],
                showRows: 10,
                searchQuery: '',
                columns: [
                    { columnName: 'Role', columnValue: 'role_id' },
                    { columnName: 'Status', columnValue: 'active' },
                    { columnName: 'User ID', columnValue: 'user_id' },
                    { columnName: 'Fullname', columnValue: 'staffs.firstname' },
                    { columnName: 'Username', columnValue: 'username' },
                    { columnName: 'Email Address', columnValue: 'staffs.email_address' }
                ],
                sortColumn: '',
                sortOrder: 0

            }
        },

        components: {
            'addUser' : addUser,
            'viewUser' : viewUser,
            'editUser' : editUser,
            'deleteUser' : deleteUser
        },

        watch: {
            'showRows': function(){ this.fetchUsers(''); },
        },

        methods: {

            searchUser(user){
                return String(user.user_id).indexOf(this.searchQuery) != -1 ||
                       user.roles.role_name.toLowerCase().indexOf(this.searchQuery) != -1 ||
                       user.username.toLowerCase().indexOf(this.searchQuery) != -1 ||
                       user.staffs.firstname.toLowerCase().indexOf(this.searchQuery) != -1 ||
                       user.staffs.lastname.toLowerCase().indexOf(this.searchQuery) != -1 ||
                       user.staffs.email_address.toLowerCase().indexOf(this.searchQuery) != -1;
            },

            fetchRoles() {
                // Fetch user roles
                this.resource.get({id: 1}).then((response) => {
                    this.$set('userroles', response.json());
                });
            },

            fetchUsers(page) {
                // Clear users variable
                this.users = [];
                // Clear sorting
                this.sortColumn = '';
                // Retrieve users
                this.$http.get('acad/list/' + this.showRows + page).then((response) => {
                    this.$set('users', response.data.user);
                    this.$set('tableInfo', {
                        firstItem: response.data.firstItem,
                        lastItem: response.data.lastItem,
                        total: response.data.total
                    });
                    this.getPagination();
                });
            },

            addUser() {
                $('.add-user-modal').fadeIn();
            },

            viewUser(user) {
                $('.view-user-modal').fadeIn();
                this.$broadcast('callFetchUserView', user);
            },

            editUser(user) {
                $('.edit-user-modal').fadeIn();
                this.$broadcast('callFetchUserEdit', user);
            },

            deleteUser(user) {
                $('.delete-user-modal').fadeIn();
                this.$broadcast('callFetchUserDelete', user, true);
            },

            restoreUser(user) {
                $('.delete-user-modal').fadeIn();
                this.$broadcast('callFetchUserDelete', user, false);
            },

            getPagination() {
                var link_limit = 7;

                // Clear pages array
                this.pages = [];

                // Set pages
                if(this.users.last_page > 1) {
                    for(var i = 1; i <= this.users.last_page; i++) {
                        var half_total_links =  _.floor(link_limit / 2);
                        var from = this.users.current_page - half_total_links;
                        var to = this.users.current_page + half_total_links;

                        if(this.users.current_page < half_total_links) {
                            to += half_total_links - this.users.current_page;
                        }
                        if((this.users.last_page - this.users.current_page) < half_total_links) {
                            from -= half_total_links - (this.users.last_page - this.users.current_page) - 1;
                        }
                        if(from < i && to > i) {
                            this.pages.push(i);
                        }
                    }
                }
            },

            sortBy() {
                this.sortOrder = (this.sortOrder == -1) ? 0:-1;
            },

        },

        events: {

            callFetchUsers() {
                this.fetchUsers('');
            }

        },

        ready() {

            this.breadcrumbs = this.cur_breadcrumbs;

            // Enable dropdowns
            $('.ui.dropdown').dropdown();

            // Fetch user roles
            this.fetchRoles();

            // Fetch users
            this.fetchUsers('');

            // Enable dropdown
            $('.record-count').dropdown();

            // Hide modals
            $('.user-modal').hide();

            $(".dashboard-right .body-right .general-body.content .content-body").mCustomScrollbar({
                scrollButtons:{enable:true},
                theme:"dark-3",
                scrollbarPosition:"inside",
                mouseWheel:{ enable: true },
            });

        }

    }

</script>
