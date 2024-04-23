import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import Login from '../views/Login.vue'
import Wallets from '../views/Wallets.vue'
import Transactions from '../views/Transactions.vue'



const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/wallets',
      name: 'wallets',
      component: Wallets
    },
    {
      path: '/transactions',
      name: 'transactions',
      component: Transactions
    },

  ]
})

export default router
