<template>
	<button :class="classes" @click="subscribe">Subscribe</button>
</template>

<script>
	export default {
		props: ['actived'],
		data() {
			return {
				active:  this.actived
			}
		},
		computed: {
			classes() {
				return ['btn', this.active ? 'btn-primary' : 'btn-default']
			}
		},
		methods: {
			subscribe() {
				let requestType = this.active ? 'delete' : 'post';
				axios[requestType](window.location.pathname + '/subscription')
				this.active = !this.active
				flash('Thread subscribed!')
			}
		}
	}
</script>