export default {
	data() {
		return {
			items: []
		}
	},
	methods: {
		remove(index) {
			this.items.splice(index, 1)
			this.$emit('removed')
			flash('Reply has been removed!')
		},
		add(reply) {
			this.items.push(reply)
			this.$emit('created')
			flash('New reply created!')
		}
	}
}