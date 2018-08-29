<template>
	<div>
		<nav aria-label="Page navigation example" v-if="shouldPaginate">
		  <ul class="pagination">
		    <li class="page-item" v-show="pervUrl">
		      <a class="page-link" @click.prevent="prevPage" href="#" aria-label="Previous">
		        <span aria-hidden="true">&laquo; Previous</span>
		        <!-- <span class="sr-only"></span> -->
		      </a>
		    </li>


		    <li class="page-item" v-show="nextUrl">
		      <a class="page-link" @click.prevent="nextPage" href="#" aria-label="Next">
		        <span aria-hidden="true">Next &raquo;</span>
		        <!-- <span class="sr-only"></span> -->
		      </a>
		    </li>
		  </ul>
		</nav>
	</div>
</template>

<script>
	export default{
		props:['dataset'],
		data(){
			return{
				page:1,
				pervUrl:false,
				nextUrl:false
			}
		},
		methods:{
			broadcast(){
				this.updateUrl()
				this.$emit('changePage', this.page)
			},
			nextPage(){
				console.log(this.page)
				this.page++
				console.log(this.page)
				this.broadcast()
			},
			prevPage(){
				console.log(this.page)
				this.page--
				console.log(this.page)
				this.broadcast()
			},
	        updateUrl(){
	            history.pushState(null, null, '?page=' + this.page)
	        }
		},
		watch:{
			dataset: function(){
				this.page = this.dataset.current_page
				this.pervUrl = this.dataset.prev_page_url
				this.nextUrl = this.dataset.next_page_url
			},
			// page:function(){
			// 	console.log('page watcher')
			// 	this.broadcast()
			// }
		},
		computed:{
			shouldPaginate: function(){
				return !!this.pervUrl || !!this.nextUrl
			}
		}
	}
</script>
