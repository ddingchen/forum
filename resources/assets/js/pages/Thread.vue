<script type="text/javascript">
	import Replies from '../components/Replies.vue'

	export default {
		props: ['initRepliesCount'],
		components: { Replies },
		data() {
			return {
				count: this.initRepliesCount
			}
		},
		methods: {
			
		}
	}
</script>