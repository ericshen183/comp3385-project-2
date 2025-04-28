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
        <label for="photo">Photo:</label>
        <input type="file" id="photo" @change="handleFileUpload" />
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
      },
      photo: null,
      error: null,
    };
  },
  methods: {
    handleFileUpload(event) {
      this.photo = event.target.files[0];
    },
    async addCar() {
      try {
        this.error = null;
        const formData = new FormData();
        formData.append("make", this.form.make);
        formData.append("model", this.form.model);
        formData.append("year", this.form.year);
        formData.append("colour", this.form.colour);
        formData.append("transmission", this.form.transmission);
        formData.append("car_type", this.form.car_type);
        formData.append("price", this.form.price);
        formData.append("description", this.form.description);
        if (this.photo) {
          formData.append("photo", this.photo);
        }

        const response = await axios.post("/api/v1/cars", formData, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            "Content-Type": "multipart/form-data",
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
  margin: 20px auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f9f9f9;
}
.new-car-page h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}
.new-car-page form div {
  margin-bottom: 15px;
}
.new-car-page label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}
.new-car-page input,
.new-car-page textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.new-car-page button {
  display: block;
  width: 100%;
  padding: 10px 15px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}
.new-car-page button:hover {
  background-color: #0056b3;
}
.error {
  color: red;
  font-size: 14px;
  text-align: center;
  margin-top: 10px;
}
</style>
