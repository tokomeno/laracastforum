<template>
	 <button class="btn btn-primery float-right"
	 	:class="{ 'btn-primary' : active}"
        @click='toggle'
	 >
	 	<i class="fas fa-heart"></i>{{count}}
	 </button>
</template>

<script>
	export default {
		props: ['reply'],
        data() {
            return {
            	count:this.reply.favorites_count,
            	active: this.reply.isFavorited,
            }
        },
        methods:{
        	toggle(){
        		if(this.active){
        			axios.delete(`/replies/${this.reply.id}/favorites`)
                    .catch(error => console.log(error))
                    this.active = false
                    this.count--
        		}else{
                    axios.post(`/replies/${this.reply.id}/favorites`)
                    .catch(error => console.log(error))
                    this.active = true
                    this.count++
                }
        	}
        }
      }
</script>
