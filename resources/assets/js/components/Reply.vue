<script>
	import favorite from './Favorite.vue';
	export default {
		components: { 'favorite': favorite },
		props: ['reply'],
        data() {
            return {
                editing: false,
                body:this.reply.body
            }
        },
        methods:{
        	update(){
        		axios.post('/replies/' + this.reply.id, {
        			body:this.body
        		}).then(() => {
        			this.editing = false
        			flash('reply has been updated')
        		})
        	},
        	destroy(){
        		axios.delete('/replies/' + this.reply.id)
        		.then(() => {
        			this.editing = false
        			flash('reply has been deleted')
        			$(this.$el).fadeOut(400);
        		})
        	}
        }
     }
</script>

