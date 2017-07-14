<template>
	<nav v-if="shouldPaginate" aria-label="Page navigation">
	  <ul class="pagination">
	    <li v-show="prevUrl">
	      <a href="#" aria-label="Previous" rel="prev" @click.prevent="page--">
	        <span aria-hidden="true">&laquo; Previous</span>
	      </a>
	    </li>
	    <li v-show="nextUrl">
	      <a href="#" aria-label="Next" rel="next" @click.prevent="page++">
	        <span aria-hidden="true">Next &raquo;</span>
	      </a>
	    </li>
	  </ul>
	</nav>
</template>

<script>
	export default {
		props: ['dataSet'],
		data() {
			return {
				prevUrl: false,
				nextUrl: false,
				page: 1
			}
		},
		computed: {
			shouldPaginate() {
				return !! (this.prevUrl || this.nextUrl)
			}
		},
		watch: {
			dataSet() {
				this.page = this.dataSet.current_page
				this.prevUrl = this.dataSet.prev_page_url
				this.nextUrl = this.dataSet.next_page_url
			},
			page() {
				this.boardcast().updateUrl()
			}
		},
		methods: {
			boardcast() {
				return this.$emit('update', this.page)
			},
			updateUrl() {
				history.pushState(null, null, `?page=${this.page}`)
			}
		}
	}
</script>