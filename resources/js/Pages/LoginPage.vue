<template>
  <div class="login-page">
    <div class="login-form">
      <h2>Login</h2>
      <form @submit.prevent="login">
        <div>
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="form.email" required />
        </div>
        <div>
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="form.password" required />
        </div>
        <button type="submit">Login</button>
      </form>
      <p v-if="error" class="error">{{ error }}</p>
    </div>
  </div>
</template>

<script>
import apiClient from "../axios";

export default {
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      error: null,
    };
  },
  methods: {
    async login() {
      try {
        this.error = null;
        const response = await apiClient.post("/auth/login", this.form);
        localStorage.setItem("auth_token", response.data.token);
        this.$router.push("/");
      } catch (err) {
        this.error = err.response?.data?.message || "An error occurred.";
      }
    },
  },
};
</script>

<style scoped>
.login-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f9f9f9;
}
.login-form {
  max-width: 400px;
  width: 100%;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: white;
}
.login-form div {
  margin-bottom: 15px;
}
.login-form label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}
.login-form input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.login-form button {
  padding: 10px 15px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.login-form button:hover {
  background-color: #0056b3;
}
.error {
  color: red;
  font-size: 14px;
}
</style>
