<template>
    <div class="book-lends">
        <div v-for="lend in lends" :key="lend.id">
            <span> {{ lend.user.name }} de {{ lend.start }} a {{ lend.end }}</span>
            <button 
                @click="deleteLend(lend.id)"
                v-if="user_id == lend.user.id || user_id == lend.book.user_id">
                 Desfazer Reserva </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['user_id', 'lends'],
    methods: {
        deleteLend(id) {
            axios.delete('api/lends/' + id)
            .then( response => {
                console.log(response.data.data)
            }).catch( e => {
                console.log(e)
            })
        }
    },
}
</script>