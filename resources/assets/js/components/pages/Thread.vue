<script>
import replies from '../Replies.vue';
import sub from '../SubscribeBtn.vue';
export default {
    props: ['proprepliescount', 'data_locked', 'thread'],
    components:{
        'replies' : replies,
        'sub-btn': sub,
    },
    data(){
        return {
            repliesCount:this.proprepliescount,
            locked: this.data_locked,
        }
    },

    methods: {
        lock(){
            axios[this.locked ? 'delete' : 'post']('/lock-thread/' + this.thread.slug)
            this.locked = !this.locked
        }
    }
}
</script>
