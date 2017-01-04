<template>
    <div class="general-container-override view-user-modal user-modal">
        <div class="general-wrap-override">
            <div class="modal-container">
                <span class="modal-close" @click="disposeResources">
                    <i class="remove icon"></i>
                </span>
                <div class="modal-header">
                    <div class="header-title">
                        <strong>View</strong>
                        <span>user profile</span>
                    </div>
                    <small class="header-subtext">
                        This information should not be released publicly.
                    </small>
                </div>
                <div class="modal-nav override">
                    <strong>Administrator Account</strong>
                </div>
                <div class="modal-body ui segment loaders">
                    <div class="ui inverted dimmer" :class="{ 'active':  showLoading }">
                        <div class="ui text loader">Loading</div>
                    </div>
                    <div class="body-title">
                        Basic and Account Information
                    </div>
                    <div class="body-form ui grid form override view-user">
                        <div class="view-photo">
                             <img :src="root_url + 'images/profile_images/' + user.staffs.photo">
                             <div class="ui tiny label override">No. {{ user.user_id }}</div>
                        </div>
                        <div class="ui special cards">
                            <div class="card override">
                                <div class="content">
                                    <div class="header">{{ user.staffs.firstname }} {{ user.staffs.lastname }}</div>
                                    <div class="meta">
                                        <a><i class="mail outline icon"></i> {{ user.staffs.email_address }}</a>
                                    </div>
                                    <div class="description">
                                        Hi, <label v-show="user.staffs.nickname != null ">you can call me {{ user.staffs.nickname }}.</label>
                                        I am an {{ user.active == 1 ? 'active' : 'inactive' }} Administrator
                                        from {{ user.staffs.country }}<label v-show="user.staffs.contact != null "> and my contact number is
                                        {{ user.staffs.contact }}</label>.
                                    </div>
                                </div>
                                <div class="extra content">
                                    <span class="right floated">
                                        Joined in {{ user.created_at | moments "MMM DD, YYYY" }}
                                    </span>
                                    <span>
                                        <i class="user icon"></i>
                                        {{ user.username }}
                                    </span>
                                </div>
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
    <div class="bg-no-image view-user-modal user-modal"></div>
</template>

<script>

    export default {

        parent: Dashboard.administrator,

        props: ['root_url'],

        data() {
            return {

                showLoading: false,
                user: {
                    active: 1,
                    created_at: "2016-10-05 14:09:58",
                    role_id: 1,
                    staffs: {
                        contact: '',
                        country: "Philippines",
                        email_address: "jess.default@gmail.com",
                        firstname: "Jess",
                        lastname: "Default",
                        nickname: '',
                        photo: "default.png",
                        staff_id: 19,
                    },
                    user_id: 1,
                    username: "jess.default"
                },

            }
        },

        events: {

            callFetchUserView(user) {
                this.showLoading = true;
                this.fetchUser(user);
            }

        },

        methods: {

            fetchUser(user) {
                // Retrieve users
                this.$set('user', user);
                this.showLoading = false;
            },

            disposeResources() {
                $('.view-user-modal').fadeOut();
                this.user = {
                    active: 1,
                    created_at: "2016-10-05 14:09:58",
                    role_id: 1,
                    staffs: {
                        contact: '',
                        country: "Philippines",
                        email_address: "jess.default@gmail.com",
                        firstname: "Jess",
                        lastname: "Default",
                        nickname: '',
                        photo: "default.png",
                        staff_id: 19,
                    },
                    user_id: 1,
                    username: "jess.default"
                }
            },

        },

    }

</script>
