<template>
     

    <li class="nav-item dropdown" v-if="notes.length">
        <a id="noteDrop" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Notes<span class="caret"></span>
        </a>
    
         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="noteDrop">
                
             <a v-for="note in notes" href="" class='dropdown-item'>
                 Foobar
             </a>
        </div>

    </li>
</template>


<script>
export default {
    data(){
        return {
            notes:[]
        }
    },
    mounted(){

        axios.get('/profiles/' + window.App.user.name + '/notifications')
        .then(res => {
            this.notes = res.data
        })
    }
}
</script>
