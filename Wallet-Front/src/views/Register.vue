
<template>
  <section class="vh-100 bg-image"
  style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Create an account</h2>

              <form @submit.prevent="register">

                <div class="form-outline mb-4">
                  <label class="form-label" name="firstname" for="firstname">First Name</label>
                  <input type="text" id="firstname" class="form-control form-control-lg" v-model="data.firstname" />
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" name="lastname" for="lastname">Last Name</label>
                  <input type="text" id="lastname" class="form-control form-control-lg" v-model="data.lastname" />
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" name="email" for="email">Email</label>
                  <input type="email" id="email" class="form-control form-control-lg" v-model="data.email"/>
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" name="password" for="password">Password</label>
                  <input type="password" id="pasword" class="form-control form-control-lg" v-model="data.password" />
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" name="type" for="type">Choose Your Walet Type:</label>
                  <select name="type" id="type" class="form-control form-control-lg" v-model="data.type">
                    <option value="standard">Standard</option>
                    <option value="VIP">VIP</option>
                  </select>
                </div>

                <div class="form-check d-flex justify-content-center mb-5">
                  <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3cg" />
                  <label class="form-check-label" for="form2Example3g">
                    I agree all statements in <a href="" class="text-body"><u>Terms of service</u></a>
                  </label>
                </div>

                <div class="d-flex justify-content-center">
                  <button type="submit"
                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Have already an account?<router-link to="login">Login</router-link></p>

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      data: { firstname: '', lastname:'', email:'', password:'',type:'' }
    }
  },
  methods:{
    register(){
      axios
      .post('http://127.0.0.1:8000/api/register', this.data)
      .then((response) => {
        this.$router.push({name: 'login'})
      })
      .catch((error) => {
        console.error(error)
      })
    }
  }
}
</script>



<style scoped>
.gradient-custom-3 {
/* fallback for old browsers */
background: #84fab0;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, rgba(132, 250, 176, 0.5), rgba(143, 211, 244, 0.5));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, rgba(132, 250, 176, 0.5), rgba(143, 211, 244, 0.5))
}
.gradient-custom-4 {
/* fallback for old browsers */
background: #84fab0;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, rgba(132, 250, 176, 1), rgba(143, 211, 244, 1));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, rgba(132, 250, 176, 1), rgba(143, 211, 244, 1))
}
</style>
