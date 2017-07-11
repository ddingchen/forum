<template>
	<div>
		<div v-for="(item, index) in items" :key='item.id'>
			<reply :attributes="item" @deleted="deleteReply(index)"></reply>
		</div>

		<new-reply @new="newReply"></new-reply>
	</div>
</template>

<script>
	import Reply from './Reply.vue'
	import NewReply from '../components/NewReply.vue'

	export default {
		props: ['replies'],
		components: { Reply, NewReply },
		data() {
			return {
				items: this.replies
			}
		},
		methods: {
			deleteReply(index) {
				this.items.splice(index, 1)
				this.$emit('removed')
				flash('Reply has been removed!')
			},
			newReply(reply) {
				this.items.push(reply)
				this.$emit('created')
				flash('New reply created!')
			}
		}
	}
</script>