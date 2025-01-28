<template>
    <div v-if="show" class="modal-overlay" @click.self="close" style="z-index:9999999;">
        <div class="modal-container">
            <div class="modal-header">
                <h5 class="modal-title">{{ title }}</h5>
                <button type="button" class="btn-close" @click="close"></button>
            </div>
            <div class="modal-body">
                <slot></slot>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="close">Cerrar</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
            required: true
        },
        title: {
            type: String,
            required: true
        }
    },
    methods: {
        close() {
            this.$emit('close');
        }
    }
};
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-container {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 500px;
    max-width: 100%;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-body {
    margin-top: 10px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    margin-top: 10px;
}
</style>