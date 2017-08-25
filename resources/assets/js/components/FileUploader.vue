<template>
    <input type="file" accept="image/*" @change="fileChanged">
</template>

<script>
    export default {
        methods: {
            fileChanged(event) {
                if(event.target.files.length == 0) {
                    return
                }
                let file = event.target.files[0]
                let reader = new FileReader()
                reader.readAsDataURL(file)
                reader.onload = event => {
                    let dataUrl = event.target.result
                    this.$emit('loaded', { dataUrl, file })
                }
            },
        }
    }
</script>
