<template>
    <div class="modal fade show d-block" tabindex="-1" role="dialog" v-if="visible">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-head-color text-white">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="btn-close text-white" @click="closeModal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <textarea v-model="comment" class="form-control" rows="4"
                        placeholder="Ingrese el motivo"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Cancelar</button>
                    <button type="button" class="btn btn-head-color" @click="submitComment">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
/* Opcional: Puedes agregar estilos personalizados para mejorar la apariencia */
.modal.fade.show {
    background: rgba(0, 0, 0, 0.5);
    /* Fondo semitransparente */
}
</style>


<script>
export default {
    props: {
        visible: Boolean,
        title: String,
    },
    data() {
        return {
            comment: '',
        };
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        submitComment() {
            this.$emit('submit', this.comment);
            this.comment = '';
            this.closeModal();
        },
    },
};
</script>