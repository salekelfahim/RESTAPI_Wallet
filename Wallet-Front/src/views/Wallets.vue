<template>

     <!-- Button trigger modal -->
<button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
 Create Wallet
</button>

    <div class="container-fluid p-3 my-3" v-for="wallet in wallets" :key="wallet.index">
        <div class="height-100 d-flex justify-content-center align-items-center">
              <div class="card p-3">
              <div class="d-flex justify-content-between align-items-center">
                <img src="https://i.imgur.com/gfp4wrR.png" width="50" />  
                <h1>{{ wallet.type }}</h1>
              </div>
              <div class="px-2 number mt-3 d-flex justify-content-between align-items-center">
                  <span>{{ wallet.id }}</span>
              </div>
                  <div class="p-4 card-border mt-4">
                      <div class="d-flex justify-content-between align-items-center">
                          <span class="cardholder">Card Holder</span>
                          <span class="expires">Expires</span>
                      </div>
                      <div class="d-flex justify-content-between align-items-center">
                          <span class="name">{{ wallet.user.fistname }}</span>
                          <span class="date">10/20</span>
                      </div>
                  </div>
              </div>
        
        </div>
       </div>

    
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form @submit.prevent="createWallet">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
        <label for="type" class="form-label">Wallet Type:</label>
        <select v-model="form.type" name="type" id="type" class="form-control">
          <option value="VIP">VIP</option>
          <option value="standard">Standard</option>
        </select>
        </div>
        <div class="mb-3">
        <label for="balance" class="form-label">Balance:</label>
        <input v-model="form.balance" type="float" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" @click="closeModal">Close</button>
        <button type="submit" class="btn btn-primary">Create Wallet</button>
      </div>
    </div>
  </div>
</form>
</div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      wallets: [],  
      form: {
        type: '',
        balance: ''
      }
    }
  },
  mounted() {
    const token = localStorage.getItem('token');
            console.log(token);

            const apiUrl = 'http://127.0.0.1:8000/api/wallets';
            const headers = {
                Authorization: 'Bearer ' + token,
            };
    axios
      .get(apiUrl, { headers })
      .then((response) => {
      console.log(response.data.wallets)
        this.wallets = response.data.wallets
      })
      .catch(error => {
        console.error();
      }
      
      )
  },
  methods: {
    closeModal() {
      this.isModalOpen = false;
    },
    createWallet() {
      const token = localStorage.getItem('token');
      const apiUrl = 'http://127.0.0.1:8000/api/addwallet';
            const headers = {
                Authorization: 'Bearer ' + token,
            };
      axios
        .post(apiUrl, this.form, { headers })
        .then(() => {
          this.closeModal(); 
          this.form.type = '';
          this.form.balance = '';
        })
        .catch(error => {
          console.error(error);
        });
    }
  }
  }

</script>

<style scoped>
body{
     background-color:#eee;
     
 }
 
 .height-100{
     height:100vh;
 }
 
 .card{
     border:none;
     width:400px; 
     border-radius:12px;
     color:#fff;
     background-image: linear-gradient(to right top, #280537, #56034c, #890058, #bc005b, #eb1254);
 }
 
.number span{
    
    font-size:20px;
    font-weight:600;
}

 .cardholder , .expires{
     font-weight:600;
     font-size:17px;
 }
 
 .name,.date{
     
     font-size:15px;
     
 }
 
 .card-border{
     
     border-top-left-radius:30px !important;
     border-top-right-radius:30px !important;
     border:none;
     border-radius:6px;
     background-color:blue;
     color:#fff;
     background-image: linear-gradient(to right top, #0c0537, #440b51, #7f005d, #b9005b, #eb124b);
 }
</style>