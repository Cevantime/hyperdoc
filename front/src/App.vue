<template>
  <div id="container">
    <div id="nav">
      <ul id="menu">
        <li><router-link to="/">Home</router-link></li>
        <li><router-link to="/about">About</router-link></li>
      </ul>
      <div>
        <div v-if="user">Bienvenue, {{ user.username }} ! <Logout></Logout></div>
        <div v-else><Login></Login></div>
      </div>
    </div>
    <router-view/>
  </div>
</template>

<script lang="ts">
import Login from "@/components/Login.vue";
import Logout from "@/components/Logout.vue";
import Component from "vue-class-component";
import Vue from "vue";
import authService from '@/services/AuthService';
import ProfileService from '@/services/ProfileService';

@Component({
  components: {
    Login, Logout
  }
})
export default class App extends Vue {
  public user = null;

  mounted() {
    ProfileService.getProfile().then((json : any)=>{
      this.user = json.data;
    }).catch(e => {
      this.user = null;
    });
  }
}
</script>

