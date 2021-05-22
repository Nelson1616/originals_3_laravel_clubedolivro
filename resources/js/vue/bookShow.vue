<template>
    <div class="book-show">
        <h3>{{ item.title }}</h3>
        
        <span> Autor: {{ item.author }} </span>
        <br>
        <span> Dono: {{ item.user.name }} </span>
        <br>
        <span> Descrição: {{ item.description }} </span>
        <br>
        <hr>
        <h3>Reservar Livro</h3>
        inicio
        <br>
        <input type="datetime-local" v-model="start">
        <br>
        <br>
        fim
        <br>
        <input type="datetime-local" v-model="end">
        <br>
        <br>
        <button @click="doLend(item.id)">Reservar</button>
        <hr>
        <h3>Reservas Atuais</h3>
        <book-lends :lends='item.lends' :user_id='user_id'/>
    </div>
</template>

<script>
import bookLends from './bookLends.vue'
export default {
    components: { bookLends },
    props: ['user_id', 'item'],
    data() {
        return {
            end: '',
            start: '',
        }
    },
    methods: {
        doLend(id) { 
            axios.post('api/lends/', {user_id: this.user_id,
                                     book_id: id, 
                                     start: this.start,
                                     end: this.end})
          .then( response => {
              this.start = ''
              this.end = ''
              console.log(response.data.data)
              this.$emit('userLendBookList')
          })
          .catch( e => {
              console.log(e)
          })
        }
    },
}
</script>