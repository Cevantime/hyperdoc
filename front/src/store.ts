import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user : null,
    authenticated : false
  },
  mutations: {
    connect(state, user) {
      state.user = user;
      state.authenticated = true;
    }
  },
  actions: {

  }
})
