<template>
  
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import AuthService from '@/services/AuthService';

@Component
export default class OAuthCallback extends Vue {
    created() {
        AuthService.getAccessTokenFromCode().then(()=> {
            window.location.href = process.env.VUE_APP_BASE_URL + '/';
        });
    }
}
</script>
