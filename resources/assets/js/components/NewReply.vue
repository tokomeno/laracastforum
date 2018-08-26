<template>
     <div>
              <div class="form-group">
                <label for="">Text</label>
                <textarea id="" class="form-control" required rows="3" name='body' v-model="body"></textarea>
              </div>

              <button class="btn" @click="submit">Submit</button>

      </div>
</template>
<script>
    export default {
        props: [''],
        data() {
            return {
                body: '',
                endpoint:''
            }
        },
        methods:{
            submit(){
                axios.post(this.endpoint, {
                    body:this.body
                })
                .then(data => {
                    this.body = ''
                    flash('Reply has been added')
                    events.$emit('newReply', data)
                })
            }

       }
    }
</script>
<style>

</style>
