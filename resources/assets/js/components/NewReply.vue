<template>
	<div>
        <div v-if="signedIn">
            <div class="form-group">
                <wysiwyg v-model='body' placeholder="say something ..."></wysiwyg>
            </div>
            <button 
            	class="btn btn-default"
            	@click='confirm'>Submit</button>
        </div>
    	<div v-else>
        	<p class="text-center">Please <a href="/login">sign in</a> to participate in forum.</p>
        </div>
    </div>
</template>

<script>
	import 'jquery.caret'
	import 'at.js'

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
		mounted() {
			$('#body').atwho({
			  at: "@",
			  callbacks: {
			    remoteFilter: function(query, callback) {
			      $.getJSON("/api/users", {q: query}, function(usernames) {
			        callback(usernames)
			      });
			    }
			  }
			})
		},
		methods: {
			confirm() {
				axios.post(`${location.pathname}/reply`, {
					body: this.body
				}).then(({ data }) => {
					this.body = ''
					this.$emit('new', data)
                    this.$emit('complete')
				}).catch(({ response }) => {
					flash(response.data, 'danger')
				})
			}
		}
	}
</script>
