<template>
    <CuadrosDatos />
    <DetailsMante :id="$route.query.id"/>
    <TimerComponentMantenimiento/>
</template>
<script setup>
import { ref } from 'vue';
import axios from 'axios';

import CuadrosDatos from '@/components/CuadrosDatos.vue';
import DetailsMante from '@/components/DetailsMante.vue';
import TimerComponentMantenimiento from '@/components/TimerComponentMantenimiento.vue';


</script>