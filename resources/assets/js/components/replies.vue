<template>
	<div>
		<div v-for="(item, index) in items" :key='item.id'>
			<reply :attributes="item" @deleted="remove(index)"></reply>
		</div>

		<paginator :dataSet="dataSet" @update="fetch"></paginator>

		<new-reply @new="add"></new-reply>
	</div>
</template>

<script>
	import Reply from './Reply.vue'
	import NewReply from '../components/NewReply.vue'
	import collection from '../mixins/collection'

	export default {
		// props: ['replies'],
		components: { Reply, NewReply },
		data() {
			return {
				dataSet: []
			}
		},
		mixins: [ collection ],
		created() {
			this.fetch()
		},
		methods: {
			fetch(page) {
				axios.get(this.url(page))
					.then(this.refresh)
			},
			url(page) {
				if(!page) {
					let query = location.search.match(/page=(\d)/)
					page = query ? query[1] : 1
				}
				return `${window.location.pathname}/reply?page=${page}`
			},
			refresh(res) {
				this.dataSet = res.data
				this.items = res.data.data
			}
		}
	}
</script>