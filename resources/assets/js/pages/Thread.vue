<script type="text/javascript">
	import Replies from '../components/Replies.vue'

	export default {
		props: ['dataRepliesCount', 'dataLocked'],
		components: { Replies },
		data() {
			return {
				count: this.dataRepliesCount,
				locked: this.dataLocked
			}
		},
		methods: {
			
		}
	}
</script>
