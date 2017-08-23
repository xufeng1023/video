<template>
    <div id="flash" :class="[alert, alertType]" v-show="show">
        <strong>{{ message }}</strong>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                type: '',
                message: '',
                show: false,
                alert: 'alert'
            }
        },
        created() {
            Bus.$on('flash', data => this.flash(data))
        },
        computed: {
            alertType() {
                return 'alert-' + this.type
            }
        },
        methods: {
            flash(data) {
                this.message = data.message
                this.type = data.type
                this.toggle()
            },
            toggle() {
                this.show = true
                setTimeout(() => {this.show = false}, 3000)
            }
        }
    }
</script>

<style>
    #flash {
        position: fixed;
        bottom: 1em;
        right: 1em;
    }
</style>
