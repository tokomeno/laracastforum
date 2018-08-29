<script>
import replies from '../Replies.vue';
import subscribeBtn from '../subscribeBtn.vue';
export default {
    props: ['proprepliescount', 'subscribeBtn'],
    components:{
        replies,
        'subscribe-btn': subscribeBtn
    },
    data(){
        return {
            repliesCount:this.proprepliescount
        }
    }
}
</script>
