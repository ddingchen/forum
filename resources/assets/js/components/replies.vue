<template>
	<div>
		<div v-for="(item, index) in items" :key='item.id'>
			<reply :attributes="item" @deleted="deleteReply(index)"></reply>
		</div>
	</div>
</template>

<script>
	import Reply from './Reply.vue'

	export default {
		props: ['replies'],
		components: { Reply },
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
			}
		}
	}
</script>