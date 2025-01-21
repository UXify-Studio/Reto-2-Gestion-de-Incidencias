<template>
    <CuadrosDatos />
    
    <DetailsIncidence />
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

import DetailsIncidence from '@/components/DetailsIncidence.vue';
import CuadrosDatos from '@/components/CuadrosDatos.vue';
import { API_BASE_URL } from '@/config.js';


</script>