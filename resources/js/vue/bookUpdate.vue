<template>
    <div class="book-update">
        <input type="text" placeholder="Título" v-model="updated_item.title">
        <input type="text" placeholder="Autor" v-model="updated_item.author">
        <br>
        <br>
        <textarea cols="30" rows="10" placeholder="Descrição" v-model="updated_item.description"></textarea>
        <br>
        <br>
        <button @click="updateBook()">Atualizar</button>
    </div>
</template>

<script>
export default {
    props: ['item', 'user_id'],
    data: function() {
        return {
            updated_item: {
                user_id: this.user_id,
                title: this.item.title,
                author: this.item.author,
                description: this.item.description,
            }
        }
    },
    methods: {
      updateBook() {
          axios.put('api/books/' + this.item.id, {user_id: this.updated_item.user_id,
                                     title: this.updated_item.title, 
                                     author: this.updated_item.author,
                                     description: this.updated_item.description})
          .then( response => {
              this.updated_item.title = ''
              this.updated_item.author = ''
              this.updated_item.description = ''
              console.log(response.data.data)
              this.$emit('userBookList')
          })
          .catch( e => {
              console.log(e)
          })
      }  
    },
}
</script>