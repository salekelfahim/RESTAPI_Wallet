<template>

      <div class="container-fluid p-3 my-3">
      <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Sender</th>
      <th scope="col">Receiver</th>
      <th scope="col">Amount</th>
    </tr>
  </thead>
  <tbody v-for="transaction in transactions" :key="transaction.id">
    <tr>
      <th scope="row">{{ transaction.id }}</th>
      <td>{{ transaction.sender }}</td>
      <td>{{ transaction.receiver }}</td>
      <td>{{ transaction.amount }}</td>
    </tr>
  </tbody>
</table>
</div>

</template>

<script>
import axios from 'axios'

export default {
 data() {
   return {
     transactions: []
   }
 },
 mounted() {
   const token = localStorage.getItem('token');
           console.log(token);

           const apiUrl = 'http://127.0.0.1:8000/api/transactions';
           const headers = {
               Authorization: 'Bearer ' + token,
           };
   axios
     .get(apiUrl, { headers })
     .then((response) => {
     console.log(response.data.transactions)
       this.transactions = response.data.transactions
     })
     .catch(error => {
       console.error();
     }
     
     )
     console.log(this.transactions.user)
 },

 }

</script>

<style scoped>

</style>