<template>
    <div>
        <div v-for="(item, index) in items" :key="item.id">
            <reply @deleted="remove(index)" :data="item"></reply>
        </div>
    </div>
</template>


<script>
import Reply from './Reply.vue';
export default {
    components: { 'reply': Reply },
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
        }
    }
}
</script>
