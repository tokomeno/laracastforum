<script>
import replies from '../Replies.vue';
export default {
    props: ['proprepliescount'],
    components:{
        replies
    },
    data(){
        return {
            repliesCount:this.proprepliescount
        }
    }
}
</script>
