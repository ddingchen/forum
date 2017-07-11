<template>
	<div>
	<!-- @if(Auth::check()) -->
        <!-- <form method="post" action="{{ $thread->path() }}/reply"> -->
            <!-- {{ csrf_field() }} -->
        <div v-if="signedIn">
            <div class="form-group">
                <textarea
                	class="form-control" 
                	rows="5" 
                	placeholder="say something ..."
                	v-model='body'
                	></textarea>
            </div>
            <button 
            	class="btn btn-default"
            	@click='confirm'>Submit</button>
        </div>
        <!-- </form> -->
    <!-- @else -->
    	<div v-else>
        	<p class="text-center">Please <a href="/login">sign in</a> to participate in forum.</p>
        </div>
    <!-- @endif -->
    </div>
</template>

<script>
	export default {
		data() {
			return {
				body: ''
			}
		},
		computed: {
			signedIn() {
				return window.App.signedIn
			}
		},
		methods: {
			confirm() {
				axios.post(`${location.pathname}/reply`, {
					body: this.body
				}).then(({ data }) => {
					this.body = ''
					this.$emit('new', data)
				})
			}
		}
	}
</script>