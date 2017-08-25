<template>
    <div>
        <div class="level">
            <img class="mr" :src="selectedAvatar" width="40" height="40" />
            <h4 v-text="user.name"></h4>
        </div>

        <!-- <input type="file" accept="image/*" 
            v-if="canUpdate"
            @change="avatarChange"> -->
        <form v-if="canUpdate">
            <file-uploader @loaded="fileLoaded"></file-uploader>
        </form>
    </div>
</template>

<script>
    import FileUploader from './FileUploader.vue'

    export default {
        components: {
            FileUploader
        },
        props: ['user'],
        data() {
            return {
                selectedAvatar: this.user.avatar_path
            }
        },
        computed: {
            canUpdate() {
                return this.authorize(authUser => authUser.id == this.user.id)
            }
        },
        methods: {
            fileLoaded(event) {
                debugger
                this.selectedAvatar = event.dataUrl
                this.persist(event.file)
            },
            persist(file) {
                let formData = new FormData()
                formData.append('avatar', file)
                axios.post(`/api/user/${this.user.name}/avatar`, formData)
                    .then(response => {
                        flash('Avatar update successfully!')
                    })
            }
        }
    }
</script>
