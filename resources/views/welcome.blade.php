<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/semantic.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/fullcalendar.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom-scroll.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/flag.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
        <style type="text/css">
            
            a.router-link-active {
                color: #f66;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height" id="application">
            <h1>Hello App!</h1>
            <p>
                <!-- use router-link component for navigation. -->
                <!-- specify the link by passing the `to` prop. -->
                <!-- <router-link> will be rendered as an `<a>` tag by default -->
                <router-link :to="{ name: 'haha' }">Go to Foo</router-link>
                <router-link :to="{ name: 'hehe' }">Go to Bar</router-link>
                <router-link :to="{ name: 'haha' }">Go to Bar</router-link>
            </p>
            <!-- route outlet -->
            <!-- component matched by the route will render here -->
            <router-view></router-view>
        </div>

        <script src="{{ asset('js/plugins/jquery.min.js') }}"></script>
        <script src="{{ asset('js/plugins/jstz.min.js') }}"></script>
        <script src="{{ asset('js/plugins/moment.min.js') }}"></script>
        <script src="{{ asset('js/plugins/moment-timezone.min.js') }}"></script>
        <script src="https://unpkg.com/vue/dist/vue.js"></script>
        <script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
        <script type="text/javascript">
            
            const Foo = { template: '<div>foo</div>' }
            const Bar = { template: '<div>bar</div>' }

            const routes = [
                { path: '/foo', name: 'haha', component: Foo },
                { path: '/bar', name: 'hehe', component: Bar }
            ]

            const router = new VueRouter({
                routes // short for routes: routes
            })

            const app = new Vue({
                router
            }).$mount('#application')

        </script>
    </body>
</html>
