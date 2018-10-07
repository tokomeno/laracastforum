<template>
	<div>
		<img :src="avatar" width="150" height="150" alt="">
		  <form v-if="canUpdate" enctype="multipart/form-data" method="post">
		    <div class="form-group">
		    	<image-upload class="form-control" @loaded="onLoad" ></image-upload>
		    </div>
		    <button type='submit' class="btn">Submit</button>
		  </form>
	</div>
</template>


<script>
	import ImageUpload from './ImageUpload.vue'
	export default {
		components:{
			'image-upload' : ImageUpload
		},
		props: ['user'],
		data(){
			return {
				avatar:this.user.avatar_path,
			}
		},
		methods:{
			onLoad(data){
				this.avatar = data.src

				this.postImage(data.file)
			},
			postImage(file){
				let data = new FormData()

				data.append('avatar', file)

				axios.post('/api/users/'+this.user.name + '/avatar', data)
					.then(() => flash('Avatar uploaded!'))
			}
		},
		computed:{
			canUpdate(){
				return this.authorize(user => user.id == this.user.id)
			}
		}
	}
</script>
