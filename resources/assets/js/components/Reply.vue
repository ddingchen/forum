<template>
    <div :id='"reply-" + this.attributes.id' class="panel panel-default">
        <div class="panel-heading">
        	<div class="level">
            	<h5 class="flex">
            		<a :href="'/profile/' + this.attributes.owner.name" v-text="this.attributes.owner.name"></a> said {{ this.attributes.created_at }}
            	</h5>

                <favorite v-if='signedIn' :reply="attributes"></favorite>

        	</div>
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-primary btn-xs" @click="update">Confirm</button>
                <button class="btn btn-link btn-xs" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        <div v-if="canUpdate" class="panel-footer level">
            <button class="btn btn-default btn-xs mr" @click="editing = true">Edit</button>
            <button class="btn btn-default btn-xs mr" @click="destroy">Delete</button>
        </div>
    </div>
</template>

<script>
	import Favorite from './Favorite.vue'

	export default {
		props: ['attributes'],
		components: { Favorite },
		data: function() {
			return {
				editing: false,
				body: this.attributes.body
			}
		},
		computed: {
			signedIn() {
				return window.App.signedIn
			},
			canUpdate() {
				return this.authorize(user => this.attributes.user_id == user.id)
			}
		},
		methods: {
			update() {
				axios.patch(`/reply/${this.attributes.id}`, {
					body: this.body
				}).then(() => {
					this.editing = false
					flash('Reply has been updated!')
				}).catch(({ response }) => {
					flash(response.data, 'danger')
				})
			},
			destroy() {
				axios.delete(`/reply/${this.attributes.id}`)

				this.$emit('deleted')

			}
		}
	}
</script>