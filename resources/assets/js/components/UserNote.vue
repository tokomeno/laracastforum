<template>
     

    <li class="nav-item dropdown" v-if="notes.length">
        <a id="noteDrop" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            Notes<span class="caret"></span>
        </a>
    
         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="noteDrop">
                
             <a v-for="note in notes" :key="note.id" :href="note.data.link" class='dropdown-item' @click="markRead(note)">
                 {{note.data.message}}
             </a>
        </div>

    </li>
</template>


<script>
export default {
    data(){
        return {
            notes:false
        }
    },
    methods:{
        markRead(note){
            axios.delete('/profile/' + window.App.user.name + '/notifications/' + note.id)
        }
    },
    mounted(){ 
        axios.get('/profile/' + window.App.user.name + '/notifications')
        .then(res => {
            this.notes = res.data
        })
    }
}
</script>
