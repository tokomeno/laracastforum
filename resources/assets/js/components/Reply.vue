<template>
  <div class="card mt-3" :id="'reply-'+data.id">
    <div class="card-header" :class="{'badge-dark' : isBest}">
      <div class="d-flex">
        <a :href="'/profile/'+data.owner.name" v-text="data.owner.name">
		</a> said
      {{ago}} ago

        <div class="flex-fill">
          <favorite :reply="data" v-if='signedIn'></favorite>
        </div>

      </div>

    </div>
    <div class="card-body">

        <div v-if='!editing' v-html="body">
        </div>

        <div v-else>
          <div class="form-group">
          <textarea class='form-control' v-model="body"></textarea>
          </div>

          <button class="btn btn-sm btn-danger" @click="update">save</button>
          <button class="btn btn-sm btn-warning" @click="editing = false">cancel</button>

        </div>
    </div>

<!-- @can('update', $reply) -->
      <div class="card-footer justify-content-start" v-if="authorize('owns', reply) || authorize('owns', thread)">
        <!-- <div  v-if="canUpdate"> -->
        <div  v-if="authorize('owns', reply)">
            <button @click="destroy" class="btn btn-sm btn-danger">Delete</button>
            <button class="btn btn-sm" @click="editing = true">Edit</button>
        </div>

         <button v-if=" authorize('owns', thread)" class="btn btn-sm btn-info ml-auto" @click="markBestReply" >Best Reply</button>
      </div>
    <!-- @endcan -->

  </div>

</template>

<script>
  import favorite from './Favorite.vue';
  import moment from 'moment'
	export default {
		components: { 'favorite': favorite },
		props: ['data'],
        data() {
            return {
                reply:this.data,
				        id:this.data.id,
                editing: false,
                body:this.data.body,
                isBest: this.data.isBest,
                thread: this.data.thread
            }
        },
        created(){
          window.events.$on('best-reply-selected', data => {
            if(data.id != this.id){
              this.isBest = false
            }
          })
        },
        methods:{
        	update(){
        		axios.post('/replies/' + this.data.id, {
        			body:this.body
            })
            .then(() => {
        			this.editing = false
        			flash('reply has been updated')
            })
            .catch(errors => {
              flash(errors.response.data, 'danger')
            })
        	},
        	destroy(){
        		axios.delete('/replies/' + this.data.id)
        		// .then(() => {
            //   this.editing = false
            //   this.$emit('deleted', this.data.id)
            // })
            this.editing = false
              this.$emit('deleted', this.data.id)
        	},
          markBestReply(){
            axios.post(`/replies/${this.reply.id}/best`)
            this.isBest = ! this.isBest

            window.events.$emit('best-reply-selected', this.data)
          }
        },
        computed:{
          signedIn(){
            return window.App.signedIn;
          },
          // canUpdate(){
          //   // return this.data.owner.id == window.App.user.id;
          //   return this.authorize(user => {
          //     // console.log(user)
          //     // console.log(this.data.owner.id)
          //         return user.id == this.data.owner.id }
          //     )
          // },
          ago(){
            return moment(this.data.created_at).fromNow()
          }
        },
     }
</script>

