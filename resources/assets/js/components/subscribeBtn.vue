<template>
    <button class="btn mt-3" :class="active ? 'btn-danger' : 'btn-primery'" @click="subscribe">subscribe</button>
</template>


<script>
export default {
    props:['active'],
    methods:{
        subscribe(){

            axios.post(location.pathname + '/subscriptions')

            flash("subscibed")
        }

        
    }
}
</script>
