<script type="text/javascript">
	import Replies from '../components/Replies.vue'

	export default {
		props: ['thread'],
		components: { Replies },
		data() {
			return {
				count: this.thread.replies_count,
				locked: this.thread.locked,
				title: this.thread.title,
				body: this.thread.body,
				form: {},
				editing: false
			}
		},
		created() {
			this.resetForm()
		},
		methods: {
			toggleLock () {
				let uri = '/locked-thread/' + this.thread.slug
				axios[this.locked ? 'delete' : 'post'](uri);
				this.locked = !this.locked;
			},
			edit() {
				this.editing = true
			},
			resetForm() {
				this.form = {
					title: this.thread.title,
					body: this.thread.body
				}
				this.editing = false
			},
			update() {
				let uri = '/thread/' + this.thread.channel.name + '/' + this.thread.slug
				axios.patch(uri, this.form).then(() => {
					this.editing = false
					this.title = this.form.title
					this.body = this.form.body
					flash('Thread was updated!')
				})
			},
		}
	}
</script>
