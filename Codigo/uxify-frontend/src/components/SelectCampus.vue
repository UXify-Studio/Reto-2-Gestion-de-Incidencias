<script>
export default{
    data() {
        return {
            campuses: []
        };
    },
    created() {
        axios.get('http://127.0.0.1:8000/api/campus')
            .then(response => {
                this.campuses = response.data;
            })
            .catch(error => {
                console.error(error);
            });
    },
    // Usamos setup() para trabajar con Pinia
  setup() {
    const sectionsStore = useSectionsStore();

    // Llama al método para obtener los datos
    onMounted(() => {
      sectionsStore.fetchSectionsByCampus();
    });

    // Computed para acceder al estado de manera reactiva
    const sectionsByCampus = computed(() => sectionsStore.sections);

    return {
      sectionsByCampus
    };
  },
};


</script>
<template>
    <select name="campuses">
        <option v-for="campus in campuses" :key="campus.id" value={{ campus.id }}>{{ campus.nombre }}</option>
    </select>
</template>