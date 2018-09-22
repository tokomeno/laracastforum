<template>
    <div>
        <div v-for="(item, index) in items" :key="item.id">
            <reply @deleted="remove(index)" :data="item"></reply>
        </div>
        <new-reply @created="add"> </new-reply>

        <paginator @changePage="fetch" :dataset="dataSet" ></paginator>
    </div>
</template>


<script>
import Reply from './Reply.vue';
import NewReply from './NewReply.vue';
import collections from '../mixins/collection.js'
export default {
    components: { 'reply': Reply, 'new-reply':NewReply },
    mixins:[collections],
    // props:['data'],
    data(){
        return{
            dataSet:false
        }
    },
    methods:{
        fetch(page){
            console.log('fetching page' + page)
            axios.get(this.url(page))
            .then(this.refresh)
        },
        refresh({data}){
            this.dataSet = data
            this.items = data.data
            console.log('refresh in replies.vue')
            window.scrollTo(0, 0)
        },
        url(page){
            if(! page){
                let query = location.search.match(/page=(\d+)/);
                page = query ? query[1] : 1;
            }
            return `${location.pathname}/replies?page=${page}`
        },

    },
    created(){
        this.fetch()
    }
}
</script>
