<template>
    <div>
        <p>
            <button @click="logout">Logout</button>
        </p>
    </div>
</template>
<script lang="ts">
import authService from "@/services/AuthService";
import Component from "vue-class-component";
import Vue from "vue";

@Component
export default class Logout extends Vue {
  public logout() {
    authService.logout();
  }
}
</script>
