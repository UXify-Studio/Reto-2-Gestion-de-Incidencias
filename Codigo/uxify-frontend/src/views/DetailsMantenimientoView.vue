<template>
    <CuadrosDatos />
    <DetailsMante :id="$route.query.id"/>

</template>
<script setup>
import { ref } from 'vue';
import axios from 'axios';

import CuadrosDatos from '@/components/CuadrosDatos.vue';
import DetailsMante from '@/components/DetailsMante.vue';


</script>