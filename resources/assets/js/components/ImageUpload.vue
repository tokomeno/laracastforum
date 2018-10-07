<template>
	<div>
		<input @change="onChange" accept="image/*" type="file">
	</div>

</template>

<script>
	export default {
		methods:{
			onChange(e){
				if(! e.target.files.length) return
				let file = e.target.files[0]
				let reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = e => {
					this.$emit('loaded', {
						file,
						// data url for displaing file
						src: e.target.result
					})
				}
			},
		}
	}
</script>
