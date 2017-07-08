<template>
	<button :class="classes" @click="toggle">
		<span class="glyphicon glyphicon-heart"></span>
		<span v-text="count"></span>
	</button>
</template>

<script>
	export default {
		props: ['reply'],
		data () {
			return {
				count: this.reply.favoritesCount,
				active: this.reply.isFavorited
			}
		},
		computed: {
			classes() {
				return 'btn ' + (this.active ? 'btn-primary' : 'btn-default')
			},
			endPoint() {
				return `/reply/${this.reply.id}/favorites`
			}
		},
		methods: {
			toggle() {
				this.active ? this.unfavorite() : this.favorite()
			},
			favorite() {
				axios.post(this.endPoint)
				this.count++
				this.active = true
			},
			unfavorite() {
				axios.delete(this.endPoint)
				this.count--
				this.active = false
			}
		}
	}
</script>