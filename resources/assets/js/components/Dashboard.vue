<template>
    <div class="ui segment override wrapper general-body content">
        <div class="ui segment override header content-header">
            <div class="header-title">
                <i class="dashboard icon"></i>
                <div class="title">Dashboard</div>
            </div>
        </div>

        <div class="general-body-content content-body override">
            <h1>DASHBOARD</h1>
            <small>Add home contents inside here.</small>
        </div>
    </div>
</template>

<script>
    
    export default {

        parent: Dashboard.app,

        props: ['breadcrumbs'],

        data() {
            return {

                cur_breadcrumbs: { name: 'Dashboard', icon: 'dashboard' },

            }
        },

        ready() {

            this.breadcrumbs = this.cur_breadcrumbs;

        }

    }

</script>
