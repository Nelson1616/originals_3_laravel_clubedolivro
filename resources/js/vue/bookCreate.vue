<template>
    <div class="book-create">
        <input type="text" placeholder="Título" v-model="item.title">
        <input type="text" placeholder="Autor" v-model="item.author">
        <br>
        <br>
        <textarea cols="30" rows="10" placeholder="Descrição" v-model="item.description"></textarea>
        <br>
        <br>
        <button @click="createBook()">Criar</button>
    </div>
</template>

<script>
export default {
    props: ['user_id'],
    data: function() {
        return {
            item: {
                user_id: this.user_id,
                title: '',
                author: '',
                description: '',
            }
        }
    },
    methods: {
      createBook() {
          axios.post('api/books/', {user_id: this.item.user_id,
                                     title: this.item.title, 
                                     author: this.item.author,
                                     description: this.item.description})
          .then( response => {
              this.item.title = ''
              this.item.author = ''
              this.item.description = ''
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