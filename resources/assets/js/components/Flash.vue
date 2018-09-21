<template>
    <div v-show="show" 
    class="alert alert-flash" 
    :class="'alert-' + level">
        {{body}}.
    </div>
</template>
<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: '',
                show: false,
                level:'success'
            }
        },
        methods:{
            flash(data){
                this.body = data.message
                this.level = data.level
                this.show = true

                this.hide()
            },
            hide(){
                setTimeout(() => {
                    this.show = false
                    // this.level = success 
                }, 3000)
            }
        },
        created(){
            if(this.message){
                this.flash(message)
            }
            window.events.$on('flash', data => {
                this.flash(data)
            })
        }
    }
</script>
<style>
    .alert-flash{
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>
