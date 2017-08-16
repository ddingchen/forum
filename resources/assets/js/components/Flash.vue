<template>
    <div class="alert alert-message" role="alert" 
        :class="'alert-'+this.level"
        v-show="this.show">
        {{ this.levelTitle }}! {{ body }}
    </div>
</template>

<script>
    export default {
        props: ['message'],
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
                this.flash(this.message)
            }
            window.events.$on('flash', ({message, level}) => this.flash(message, level))
        },
        methods: {
            flash(message, level = 'success') {
                this.body = message
                this.level = level
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
