<template>
    <table class="table table-bordered table-striped">
                <thead class="table-light">
                <tr>
                    <th class="p-1 text-center align-middle">ID Mantenimiento</th>
                    <th class="p-1 text-center align-middle">Descripcion</th>
                    <th class="p-1 text-center align-middle">Maquina</th>
                    <th class="p-1 text-center align-middle">Abierto Por</th>
                    <th class="p-1 text-center align-middle">Periodo</th>
                    <th class="p-1 text-center align-middle">Proxima Fecha</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="mantenimiento in mantenimientos" :key="mantenimiento.id">
                        <td class="fs-6 p-1 text-center align-middle">
                            <router-link :to="{ name: 'MantenimientosDetalles', query: { id: mantenimiento.id } }"
                                class="d-block text-decoration-none" style="color: inherit;">
                                {{ mantenimiento.id }}
                            </router-link>
                        </td>
                        <td class="fs-6 p-1 text-center align-middle">
                            <router-link :to="{ name: 'MantenimientosDetalles', query: { id: mantenimiento.id } }"
                                class="d-block text-decoration-none" style="color: inherit;">
                                {{mantenimiento.descripcion }}
                            </router-link>
                        </td>                        
                        <td class="fs-6 p-1 text-center align-middle">
                            <router-link :to="{ name: 'MantenimientosDetalles', query: { id: mantenimiento.id } }"
                                class="d-block text-decoration-none" style="color: inherit;">
                                {{mantenimiento.maquina.nombre }}
                            </router-link>
                        </td>
                        <td class="fs-6 p-1 text-center align-middle">
                            <router-link :to="{ name: 'MantenimientosDetalles', query: { id: mantenimiento.id } }"
                                class="d-block text-decoration-none" style="color: inherit;">
                                {{mantenimiento.usuario.username }}
                            </router-link>
                        </td>
                        <td class="fs-6 p-1 text-center align-middle">
                            <router-link :to="{ name: 'MantenimientosDetalles', query: { id: mantenimiento.id } }"
                                class="d-block text-decoration-none" style="color: inherit;">
                                {{mantenimiento.periodo }}
                            </router-link>
                        </td>
                        <td class="fs-6 p-1 text-center align-middle">
                            <router-link :to="{ name: 'MantenimientosDetalles', query: { id: mantenimiento.id } }"
                                class="d-block text-decoration-none" style="color: inherit;">
                                {{mantenimiento.proxima_fecha }}
                            </router-link>
                        </td>

                    </tr>
                </tbody>
            </table>
</template>

<script>
import { computed, onMounted } from 'vue';
import { useMantenimientosStore } from '@/stores/mantenimientos';

export default{
    name: 'MantenimientosList',

    setup(){
    const mantenimientosStore = useMantenimientosStore();

    // Llama al método para obtener los datos
    onMounted(() => {
      mantenimientosStore.fetchMantenimientosTotal();
    });

    // Computed para acceder al estado de manera reactiva
    const mantenimientos = computed(() => mantenimientosStore.mantenimientos);

    return {
      mantenimientos,
    };
  },
}
</script>