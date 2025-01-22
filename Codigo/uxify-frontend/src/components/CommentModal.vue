<template>
    <div class="modal" v-if="visible">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>
        <h2>{{ title }}</h2>
        <textarea v-model="comment" placeholder="Ingrese el motivo"></textarea>
        <button @click="submitComment">Enviar</button>
      </div>
    </div>
  </template>
  
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
  
  <style scoped>
  .modal {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
  }
  
  .modal-content {
    background-color: #fefefe;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
  }
  
  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }
  
  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
  </style>