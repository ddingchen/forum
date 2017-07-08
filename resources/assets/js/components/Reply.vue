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
		methods: {
			update() {
				axios.patch(`/reply/${this.attributes.id}`, {
					body: this.body
				})

				this.editing = false
				flash('Reply has been updated!')
			},
			destroy() {
				axios.delete(`/reply/${this.attributes.id}`)
				$(this.$el).fadeOut(300, () => {
					flash('Reply has been deleted!')
				})
				

			}
		}
	}
</script>