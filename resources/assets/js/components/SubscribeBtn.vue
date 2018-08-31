<template>
	<div>
		<button class="btn" :class="{ 'btn-success': active }" @click="subscribe">Subscribe</button>
	</div>
</template>

<script>
export default {
	props:['propactive'],
    data(){
		return { 
			active:this.propactive,
		}
	},
	methods:{
		subscribe(){
				axios[this.active ? 'delete' : 'post'](location.pathname + '/subscriptions')

				this.active = ! this.active
				flash('thread has been subscirbed')
			}
	}
}
</script>
