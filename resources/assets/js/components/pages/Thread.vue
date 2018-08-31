<script>
import replies from '../Replies.vue';
import sub from '../SubscribeBtn.vue';
export default {
    props: ['proprepliescount'],
    components:{
        'replies' : replies,
        'sub-btn': sub
    },
    data(){
        return {
            repliesCount:this.proprepliescount
        }
    }
}
</script>
