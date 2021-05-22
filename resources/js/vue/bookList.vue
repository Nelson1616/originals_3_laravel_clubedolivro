<template>
    <div>
        <div v-for="item in items" :key="item.tile">
            <book-item
            :item="item"/>
            <button @click="getItemId(item.id)">Ver Mais</button>
            <button v-if="item.user_id == user_id" @click="editBook(item.id)">Editar</button>
            <button v-if="item.user_id == user_id" @click="deleteBook(item.id)">Deletar</button>
            <br>
            <br>
        </div>
        
    </div>
</template>

<script>
import bookItem from './bookItem.vue'
export default {
    props: ['items', 'user_id'],
    components: {
        bookItem 
    },
    methods: {
        getItemId(id){
            this.$emit('itemid', id)
        },
        editBook(id){
            this.$emit('editBook', id)
        },
        deleteBook(id){
            this.$emit('deleteBook', id)
        },
    }
    
}
</script>