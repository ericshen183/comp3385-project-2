<template>
  <div class="new-car-page">
    <h2>Add a New Car</h2>
    <form @submit.prevent="addCar">
      <div>
        <label for="make">Make:</label>
        <input type="text" id="make" v-model="form.make" required />
      </div>
      <div>
        <label for="model">Model:</label>
        <input type="text" id="model" v-model="form.model" required />
      </div>
      <div>
        <label for="year">Year:</label>
        <input type="number" id="year" v-model="form.year" required />
      </div>
      <div>
        <label for="colour">Colour:</label>
        <input type="text" id="colour" v-model="form.colour" required />
      </div>
      <div>
        <label for="transmission">Transmission:</label>
        <input type="text" id="transmission" v-model="form.transmission" required />
      </div>
      <div>
        <label for="car_type">Car Type:</label>
        <input type="text" id="car_type" v-model="form.car_type" required />
      </div>
      <div>
        <label for="price">Price:</label>
        <input type="number" id="price" v-model="form.price" required />
      </div>
      <div>
        <label for="description">Description:</label>
        <textarea id="description" v-model="form.description" required></textarea>
      </div>
      <div>
        <label for="photo">Photo URL:</label>
        <input type="text" id="photo" v-model="form.photo" />
      </div>
      <button type="submit">Add Car</button>
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
        make: "",
        model: "",
        year: "",
        colour: "",
        transmission: "",
        car_type: "",
        price: "",
        description: "",
        photo: "",
      },
      error: null,
    };
  },
  methods: {
    async addCar() {
      try {
        this.error = null;
        const response = await axios.post("/api/v1/cars", this.form, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
          },
        });
        alert("Car added successfully!");
        this.$router.push(`/cars/${response.data.id}`);
      } catch (err) {
        this.error = err.response?.data?.message || "An error occurred.";
      }
    },
  },
};
</script>

<style scoped>
.new-car-page {
  max-width: 600px;
  margin: 0 auto;
}
.new-car-page div {
  margin-bottom: 10px;
}
.error {
  color: red;
}
</style>
