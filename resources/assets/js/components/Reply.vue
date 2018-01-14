<template>
    <div :id='"reply-" + reply.id' class="panel" :class="isBest ? 'panel-success' : 'panel-default'">
        <div class="panel-heading">
        	<div class="level">
            	<h5 class="flex">
            		<a :href="'/profile/' + reply.owner.name" v-text="reply.owner.name"></a> said {{ reply.created_at }}
            	</h5>

                <favorite v-if='signedIn' :reply="reply"></favorite>

        	</div>
        </div>

        <div class="panel-body">
            <div v-if="editing">
            	<form @submit.prevent="update">
	                <div class="form-group">
                        <wysiwyg v-model="body"></wysiwyg>
	                </div>
	                <button class="btn btn-primary btn-xs">Confirm</button>
	                <button class="btn btn-link btn-xs" type="button" @click="cancel">Cancel</button>
                </form>
            </div>
            <div v-else v-html="body"></div>
        </div>

        <div class="panel-footer level"
            v-if="authorize('owner', reply) || authorize('owner', reply.thread)">

            <div v-if="authorize('owner', reply)">
                <button class="btn btn-default btn-xs mr" @click="edit">Edit</button>
                <button class="btn btn-default btn-xs mr" @click="destroy">Delete</button>
            </div>

            <button class="btn btn-default btn-xs ml-a"
                v-if="authorize('owner', reply.thread)"
                v-show="!isBest" 
                @click="markBestReply">Best Reply</button>
        </div>
    </div>
</template>

<script>
	import Favorite from './Favorite.vue'

	export default {
		props: ['reply'],
		components: { Favorite },
		data: function() {
			return {
				editing: false,
				body: this.reply.body,
				oldBody: '',
                isBest: this.reply.isBest
			}
		},
        created() {
            window.events.$on('best-reply', (bestReply) => {
                this.isBest = this.reply.id == bestReply.id
            });
        },
		methods: {
			edit() {
				this.oldBody = this.body
				this.editing = true
			},
			update() {
				axios.patch(`/reply/${this.reply.id}`, {
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
				axios.delete(`/reply/${this.reply.id}`)

				this.$emit('deleted')

			},
            markBestReply() {
                axios.post(`/reply/${this.reply.id}/best`);
                window.events.$emit('best-reply', this.reply);
                this.isBest = true
            }
		}
	}
</script>
