<template>
    <div>
        <p>
            <button @click="login">Login</button>
        </p>
    </div>
</template>
<script lang="ts">
import authService from "@/services/AuthService";
import Component from "vue-class-component";
import Vue from "vue";

@Component
export default class Login extends Vue {
  public login() {
    authService.login();
  }
}
</script>

