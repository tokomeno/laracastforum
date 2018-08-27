<template>
    <div>
        <div v-for="(item, index) in items" :key="item.id">
            <reply @deleted="remove(index)" :data="item"></reply>
        </div>
          <new-reply @created="add"> </new-reply>
    </div>
</template>


<script>
import Reply from './Reply.vue';
import NewReply from './NewReply.vue';
export default {
    components: { 'reply': Reply, 'new-reply':NewReply },
    props:['data'],
    data(){
        return{
            items:this.data,
        }
    },
    methods:{
        remove(index){
            console.log('remove' + index)
            this.items.splice(index, 1)
            this.$emit('removed')
            flash('reply has been deleted')
        },
        add(data){
             this.$emit('added')
            this.items.push(data)
        }
    }
}
</script>
