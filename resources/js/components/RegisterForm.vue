<template>
  <div class="register-form">
    <h2>Register</h2>
    <form @submit.prevent="register">
      <div>
        <label for="name">Name:</label>
        <input type="text" id="name" v-model="form.name" required />
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="form.email" required />
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="form.password" required />
      </div>
      <div>
        <label for="location">Location:</label>
        <input type="text" id="location" v-model="form.location" />
      </div>
      <div>
        <label for="biography">Biography:</label>
        <textarea id="biography" v-model="form.biography"></textarea>
      </div>
      <div>
        <label for="photo">Photo:</label>
        <input type="file" id="photo" @change="handleFileUpload" />
      </div>
      <button type="submit">Register</button>
    </form>
    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      form: {
        name: "",
        email: "",
        password: "",
        location: "",
        biography: "",
      },
      photo: null,
      error: null,
    };
  },
  methods: {
    handleFileUpload(event) {
      this.photo = event.target.files[0];
    },
    async register() {
      try {
        this.error = null;
        const formData = new FormData();
        formData.append("name", this.form.name);
        formData.append("email", this.form.email);
        formData.append("password", this.form.password);
        formData.append("location", this.form.location);
        formData.append("biography", this.form.biography);
        if (this.photo) {
          formData.append("photo", this.photo);
        }

        const response = await axios.post("/api/v1/auth/register", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        });
        alert("Registration successful!");
        console.log(response.data);
      } catch (err) {
        this.error = err.response?.data?.message || "An error occurred.";
      }
    },
  },
};
</script>

<style scoped>
.register-form {
  max-width: 400px;
  margin: 20px auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f9f9f9;
}
.register-form div {
  margin-bottom: 15px;
}
.register-form label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}
.register-form input,
.register-form textarea {
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
