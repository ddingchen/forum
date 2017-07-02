<template>
    <div class="alert alert-success alert-message" role="alert" v-show="this.show">
        Success! {{ body }}
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: '',
                show: false
            }
        },
        created() {
            if(this.message) {
                this.flash(this.message)

                window.events.$on('flash', message => this.flash(message))
            }
        },
        methods: {
            flash(message) {
                this.body = this.message
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
