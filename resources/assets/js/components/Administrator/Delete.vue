<template>
    <div>
        <div class="general-container-override delete-user-modal user-modal">
            <div class="general-wrap-override">
                <div class="modal-container">
                    <span class="modal-close" @click="disposeResources">
                        <i class="remove icon"></i>
                    </span>
                    <div class="modal-header">
                        <div class="header-title">
                            <strong>Delete</strong>
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
                            User <strong>{{ user.username }}</strong> Informations
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
                                            <div class="ui mini icon error message override" v-if="showDelete">
                                                <div class="content">
                                                    Are you sure you want to continue deleting this account?
                                                </div>
                                            </div>
                                            <div class="ui mini icon positive message override" v-if="!showDelete">
                                                <div class="content">
                                                    Are you sure you want to continue restoring this account?
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer delete-user">
                        <div class="ui white fluid left labeled icon button override tiny custom" @click="disposeResources">
                            <i class="remove icon"></i>
                            Cancel
                        </div>
                        <div class="ui teal fluid right labeled icon button override tiny custom" 
                             v-if="showDelete"
                             @click="executeQuery('-delete')"
                        >
                            Delete User
                            <i class="checkmark icon"></i>
                        </div>
                        <div class="ui teal fluid right labeled icon button override tiny custom" 
                             v-if="!showDelete"
                             @click="executeQuery('-restore')"
                        >
                            Restore User
                            <i class="checkmark icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-no-image delete-user-modal user-modal"></div>
    </div>
</template>

<script>
    
    export default {

        parent: Dashboard.administrator,

        props: ['root_url', 'resource'],

        data() {
            return {

                showLoading: false,
                showDelete: true,
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

            callFetchUserDelete(user, command) {
                this.showLoading = true;
                this.showDelete = command;
                this.fetchUser(user);
            }

        },

        methods: {

            fetchUser(user) {
                // Retrieve users
                this.$set('user', user);
                this.showLoading = false;
            },

            executeQuery(command) {
                this.resource.delete({user_id: this.user.user_id + command}).then((response) => {
                    var flashMessage = {
                        icon: response.data.icon,
                        header: response.data.header,
                        body: response.data.body
                    }

                    $('.delete-user-modal').fadeOut();
                    this.showLoading = false;
                    //this.$dispatch('callOpenFlashChild', flashMessage);

                    // Refresh administrator list
                    //this.$dispatch('callFetchUsers');
                });
            },

            disposeResources() {
                $('.delete-user-modal').fadeOut();
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
