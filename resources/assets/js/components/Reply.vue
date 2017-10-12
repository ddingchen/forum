<template>
    <div :id='"reply-" + this.attributes.id' class="panel" :class="isBest ? 'panel-success' : 'panel-default'">
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
            	<form @submit="update">
	                <div class="form-group">
	                    <textarea class="form-control" v-model="body" required></textarea>
	                </div>
	                <button class="btn btn-primary btn-xs">Confirm</button>
	                <button class="btn btn-link btn-xs" type="button" @click="cancel">Cancel</button>
                </form>
            </div>
            <div v-else v-text="body"></div>
        </div>

        <div class="panel-footer level">
            <div v-if="authorize('updateReply', reply)">
                <button class="btn btn-default btn-xs mr" @click="edit">Edit</button>
                <button class="btn btn-default btn-xs mr" @click="destroy">Delete</button>
            </div>

            <button class="btn btn-default btn-xs ml-a" v-show="!isBest" @click="markBestReply">Best Reply</button>
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
				body: this.attributes.body,
				oldBody: '',
                isBest: false,
                reply: this.attributes
			}
		},
		methods: {
			edit() {
				this.oldBody = this.body
				this.editing = true
			},
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
			cancel() {
				this.body = this.oldBody
				this.editing = false
			},
			destroy() {
				axios.delete(`/reply/${this.attributes.id}`)

				this.$emit('deleted')

			},
            markBestReply() {
                this.isBest = true
            }
		}
	}
</script>
