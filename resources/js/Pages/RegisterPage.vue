<template>
  <div class="register-page">
    <RegisterForm />
  </div>
</template>

<script>
import RegisterForm from "../components/RegisterForm.vue";

export default {
  components: {
    RegisterForm,
  },
};
</script>

<style scoped>
.register-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f9f9f9;
}
.register-form {
  max-width: 400px;
  width: 100%;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: white;
}
.register-form div {
  margin-bottom: 15px;
}
.register-form label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}
.register-form input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.register-form button {
  padding: 10px 15px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.register-form button:hover {
  background-color: #0056b3;
}
.error {
  color: red;
  font-size: 14px;
}
</style>
