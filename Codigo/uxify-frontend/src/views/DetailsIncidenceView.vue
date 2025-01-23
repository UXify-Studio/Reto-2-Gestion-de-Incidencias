<template>
    <CuadrosDatos />
    <DetailsIncidence :id="$route.query.id" />
    <TimerComponent />
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

import DetailsIncidence from '@/components/DetailsIncidence.vue';
import CuadrosDatos from '@/components/CuadrosDatos.vue';
import TimerComponent from '@/components/TimerComponentIncidence.vue';
import { API_BASE_URL } from '@/config.js';
</script>