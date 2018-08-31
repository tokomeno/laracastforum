<template>
  <div class="my-4">
      <div v-if="signedIn">
          <div class="form-group">
            <label for="">Text</label>
            <textarea id="" class="form-control" required rows="3" name='body' v-model="body"></textarea>
          </div>

          <button class="btn" @click="submit">Submit</button>
      </div>
      <div v-else>
          Please sign in..
      </div>
  </div>
</template>
<script>
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
            }

       },
       computed:{
        signedIn(){
            return window.App.signedIn;
          }
       }
    }
</script>
<style>

</style>
