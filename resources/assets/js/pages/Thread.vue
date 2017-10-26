<script type="text/javascript">
	import Replies from '../components/Replies.vue'

	export default {
		props: ['thread'],
		components: { Replies },
		data() {
			return {
				count: this.thread.replies_count,
				locked: this.thread.locked
			}
		},
		methods: {
			toggleLock () {
				axios[this.locked ? 'delete' : 'post']('/locked-thread/' + this.thread.slug);
				this.locked = !this.locked;
			}
		}
	}
</script>
