<template>
  <div class="my-4">
      <div v-if="signedIn">
          <div class="form-group">
            <label for="">Text</label>
            <textarea id="body" class="form-control" required rows="3" name='body' v-model="body"></textarea>
          </div>

          <button class="btn" @click="submit">Submit</button>
      </div>
      <div v-else>
          Please sign in..
      </div>
  </div>
</template>
<script>
  import 'at.js';
  import 'jquery.caret';
    export default {
        data() {
            return {
                body: '',
            }
        },
        methods:{
            submit(){
                axios.post(`${location.pathname}/replies`, { body:this.body })
                .then(data => {
                    this.body = ''
                    flash('Reply has been added')
                    this.$emit('created', data.data)
                })
                 .catch(error => {
                    console.log(error.response)
                    flash(error.response.data, 'danger')
                })
            }

       },
       computed:{
        signedIn(){
            return window.App.signedIn;
          }
       },

       mounted(){
        $('#body').atwho({
          at:"@",
          delay: 650,
          callbacks: {
            remoteFilter: function(query, callback){
              $.getJSON("/api/users", {q: query}, function(username){
                callback(username)
              });
            }
          }
        })
       }
    }
</script>
<style>

</style>
