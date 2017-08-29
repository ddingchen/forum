<template>
    <div class="alert alert-message" role="alert" 
        :class="'alert-'+this.level"
        v-show="this.show">
        {{ this.levelTitle }}! {{ body }}
    </div>
</template>

<script>
    export default {
        props: ['message', 'status'],
        data() {
            return {
                body: '',
                show: false,
                level: 'success'
            }
        },
        computed: {
            levelTitle() {
                switch(this.level) {
                    case 'success': return 'Success'
                    case 'danger': return 'Failed'
                }
            }
        },
        created() {
            if(this.message) {
                this.flash(this.message, this.status)
            }
            window.events.$on('flash', ({message, status}) => this.flash(message, status))
        },
        methods: {
            flash(message, status = 'success') {
                this.body = message
                this.level = status
                this.show = true
                this.hide()
            },
            hide() {
                setTimeout(() => {
                    this.show = false
                }, 3000)
            }
        }
    }
</script>

<style type="text/css">
    .alert-message {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>
