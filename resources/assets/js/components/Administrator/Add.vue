<template>
    <div>
        <div class="general-container-override add-user-modal user-modal">
            <div class="general-wrap-override">
                <div class="modal-container">
                    <span class="modal-close" @click="disposeResources">
                        <i class="remove icon"></i>
                    </span>
                    <div class="modal-header">
                        <div class="header-title">
                            <strong>Create</strong>
                            <span>user profile</span>
                        </div>
                        <small class="header-subtext">
                            Fill out the form below with valid information.
                        </small>
                    </div>
                    <div class="modal-nav override">
                        <strong>Administrator Account</strong>
                    </div>
                    <div class="modal-body ui segment loaders">
                        <div class="ui inverted dimmer" :class="{ 'active':  showLoading }">
                            <div class="ui text loader">Loading</div>
                        </div>
                        <div class="capture-container" v-show="showCamera">
    		                <div class="camera-wrap">
    		                    <strong>Webcamera</strong>
    		                    <div id="video-camera-add" class="video-camera"></div>
    		                    <div class="camera-buttons" v-show="showCaptureBtn">
    		                        <button class="ui labeled icon button override tiny teal" @click="takeSnapshot">
    		                            <i class="camera icon"></i>
    		                            Capture
    		                        </button>
    		                        <button class="ui right labeled icon button override tiny red" @click="closeCamera">
    		                            <i class="remove icon"></i>
    		                            Cancel
    		                        </button>
    		                    </div>
    		                    <div class="camera-buttons" v-show="!showCaptureBtn">
    		                        <button class="ui labeled icon button override tiny teal" @click="setCameraImage">
    		                            <i class="check icon"></i>
    		                            Save
    		                        </button>
    		                        <button class="ui right labeled icon button override tiny red" @click="retakeSnapshot">
    		                            <i class="camera icon"></i>
    		                            Re-Capture
    		                        </button>
    		                    </div>
    		                </div>
    		            </div>
                        <div class="body-title">
                            Basic and Account Informations
                        </div>
                        <div class="body-form ui grid form override">
                            <div class="seven wide column profile-photo">
                                <img class="ui tiny circular image overrides" :src="newUser.imageURI.src">
                                <div class="ui pointing icon dropdown override cmbProfilePhoto">
                                    <strong>Choose Picture</strong>
                                    <div class="menu">
                                        <div class="header">Profile Picture</div>
                                        <div class="divider"></div>
                                        <div class="item" @click="openCamera">
                                            <i class="photo icon"></i>
                                            Take Photo
                                        </div>
                                        <div class="item" @click="selectPhotoUpload">
                                        	<input type="file" accept="image/*" ref="upload-photo" class="hidden override">
                                            <i class="upload icon"></i>
                                            Upload Photo
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="nine wide column">
                                <div class="field" :class="{ 'error': !validation.firstname && showError }">
                                    <label>First Name</label>
                                    <input placeholder="First Name" type="text" v-model="newUser.firstname" autofocus>
                                </div>
                                <div class="field" :class="{ 'error': !validation.lastname && showError }">
                                    <label>Last Name</label>
                                    <input placeholder="Last Name" type="text" v-model="newUser.lastname">
                                </div>
                            </div>
                            <div class="sixteen wide column">
                                <div class="field" :class="{ 'error': (!validation.email_empty || !validation.email_check) && showError }">
                                    <label>Email Address</label>
                                    <input placeholder="Email Address" type="text" v-model="newUser.email_address">
                                </div>
                            </div>
                            <div class="sixteen wide column">
                                <div class="field" :class="{ 'error': !validation.username && showError }">
                                    <label>Username</label>
                                    <div class="ui left icon input">
                                        <input placeholder="Username" type="text" v-model="newUser.username">
                                        <i class="user icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="sixteen wide column">
                                <div class="two fields">
                                    <div class="field" :class="{ 'error': !validation.password && showError }">
                                        <label>Password</label>
                                        <div class="ui left icon input">
                                            <input placeholder="Password" type="password" v-model="newUser.password">
                                            <i class="lock icon"></i>
                                        </div>
                                    </div>
                                    <div class="field" :class="{ 'error': (!validation.c_password || !validation.pass_mismatch) && showError }">
                                        <label>Confirm Password</label>
                                        <div class="ui left icon input">
                                            <input placeholder="Confirm Password" type="password" v-model="newUser.c_password">
                                            <i class="lock icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sixteen wide column">
                                <div class="ui mini error message override" v-if="!isValid && showError">
                                    <div class="header">
                                        There was some errors with your submission
                                    </div>
                                    <ul class="list">
                                        <li v-show="!validation.firstname">You need to enter your Firstname.</li>
                                        <li v-show="!validation.lastname">You need to enter your Lastname.</li>
                                        <li v-show="!validation.email_empty">You need to enter your Email Address.</li>
                                        <li v-show="!validation.email_check">Please enter a valid Email Address.</li>
                                        <li v-show="!validation.username">You need to enter your Username.</li>
                                        <li v-show="!validation.password">You need to enter your Password.</li>
                                        <li v-show="!validation.c_password">You need to re-enter your Password.</li>
                                        <li v-show="!validation.pass_mismatch">Passwords did not match, please re-type again.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="ui white deny button override tiny custom" @click="disposeResources">
                            Cancel
                        </div>
                        <div class="ui teal right labeled icon button override tiny custom" @click="saveUser">
                            Create User
                            <i class="checkmark icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-no-image add-user-modal user-modal"></div>
    </div>
</template>

<script>
    var emailRE = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    export default {

        parent: Dashboard.app,

        props: ['root_url', 'resource'],

        data() {
            return {

                showCaptureBtn: true,
                showCamera: false,
                showLoading: false,
                showError: false,
                newUser: {
                    firstname: '', 
                    lastname: '', 
                    email_address: '', 
                    username: '', 
                    password: '', 
                    c_password: '', 
                    role_id: 1,
                    imageURI: {
                        src: this.root_url + 'images/profile_images/default.png',
                        name: 'default.png'
                    }
                },

            }
        },

        computed: {
            validation() {
                return {
                    firstname: !!this.newUser.firstname.trim(),
                    lastname: !!this.newUser.lastname.trim(),
                    email_empty: !!this.newUser.email_address.trim(),
                    email_check: emailRE.test(this.newUser.email_address),
                    username: !!this.newUser.username.trim(),
                    password: !!this.newUser.password.trim(),
                    c_password: !!this.newUser.c_password.trim(),
                    pass_mismatch: (this.newUser.c_password.trim() != this.newUser.password.trim())?false:true
                }
            },

            isValid() {
                var validation = this.validation
                return Object.keys(validation).every(function (key) {
                    return validation[key]
                })
            }
        },

        methods: {
            /*** Profile Photo ***/
            // Webcamera methods
            startVideoCamera() {
                Webcam.set({
                    width: 320, height: 240,
                    dest_width: 320, dest_height: 240,
                    crop_width: 240, crop_height: 240,
                    image_format: 'jpeg', jpeg_quality: 90,
                    flip_horiz: true
                });
                Webcam.attach('#video-camera-add');
            },
            takeSnapshot() {
                this.showCaptureBtn = !this.showCaptureBtn;
                Webcam.freeze();
            },
            retakeSnapshot() {
                this.showCaptureBtn = !this.showCaptureBtn;
                Webcam.unfreeze();
            },
            closeCamera() {
                this.showCamera = false;
                Webcam.reset();
            },
            openCamera() {
                this.startVideoCamera();
                this.showCamera = true;
            },
            setCameraImage() {
                var self = this;
                Webcam.snap(function(image_uri) {
                    self.newUser.imageURI.src = image_uri;
                    self.newUser.imageURI.name = moment().format('x') + '.jpg';
                    self.retakeSnapshot();
                    self.closeCamera();
                });
            },
            // Upload Image Methods
            selectPhotoUpload() {
                this.$refs.uploadPhoto.click();
            },
            setUploadedImage: function(event) {
                var input = event.target.files[0];
                var reader = new FileReader();
                var self = this;
                reader.onload = function(e){ self.newUser.imageURI.src = e.target.result; }
                self.newUser.imageURI.name = input.name;
                reader.readAsDataURL(input);
            },


            disposeResources() {
                this.showError = false;
                if(this.showCamera) this.closeCamera();
                $('.add-user-modal').fadeOut();
                this.clearUser();
            },

            displayFlash(flashMessage) {
                // Call parent dashboard event to open the "Flash Message"
                //this.$dispatch('callOpenFlashChild', flashMessage);
            },

            saveUser() {
                // Display errors if there are any
                this.showError = true;

                if(this.isValid) {
                    // Store to temp variable
                    var user = this.newUser;

                    // Delete confirm password from temp variable
                    delete user.c_password;

                    // Display loading
                    this.showLoading = true;

                    // Send post request
                    this.resource.save({id: 1}, {data: user}).then((response) => {
                        var flashMessage = {
                            icon: response.data.icon,
                            header: response.data.header,
                            body: response.data.body
                        }
                        $('.add-user-modal').fadeOut();
                        this.showLoading = false;
                        this.displayFlash(flashMessage);

                        // Refresh administrator list
                        //this.$dispatch('callFetchUsers');

                        // Clear form
                        this.clearUser();
                    });
                }
            },

            clearUser() {
                this.showLoading = false;
                this.newUser = {
                    firstname: '', 
                    lastname: '', 
                    email_address: '', 
                    username: '', 
                    password: '', 
                    c_password: '', 
                    role_id: 1,
                    imageURI: {
                        src: this.root_url + 'images/profile_images/default.png',
                        name: 'default.png'
                    }
                }
            }

        },

        mounted() {
            
            // Watch if input file changes
            $('input[type="file"]').change(this.setUploadedImage.bind(this));

        }

    }

</script>
