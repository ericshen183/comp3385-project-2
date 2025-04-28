<template>
  <div class="explore-page">
    <h2>Explore Cars</h2>
    <div class="search-box">
      <h3>Search Cars</h3>
      <form @submit.prevent="searchCars">
        <input type="text" v-model="searchQuery.make" placeholder="Search by make" />
        <input type="text" v-model="searchQuery.model" placeholder="Search by model" />
        <button type="submit">Search</button>
      </form>
    </div>

    <div class="search-results" v-if="searchResults.length">
      <h3>Search Results</h3>
      <ul>
        <li v-for="car in searchResults" :key="car.id">
          <strong>{{ car.make }} {{ car.model }}</strong> - {{ car.year }} - ${{ car.price }}
          <button @click="viewCarDetails(car.id)">View More Details</button>
        </li>
      </ul>
    </div>
    <p v-else-if="searchPerformed">No cars found.</p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      searchQuery: {
        make: "",
        model: "",
      },
      searchResults: [],
      searchPerformed: false,
    };
  },
  methods: {
    async searchCars() {
      try {
        this.searchPerformed = true;
        const response = await axios.get("/api/v1/search", {
          params: this.searchQuery,
        });
        this.searchResults = response.data;
      } catch (err) {
        console.error("Error searching cars:", err);
      }
    },
    viewCarDetails(carId) {
      this.$router.push(`/cars/${carId}`);
    },
  },
};
</script>

<style scoped>
.explore-page {
  max-width: 800px;
  margin: 20px auto;
  padding: 20px;
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 8px;
}
.search-box {
  margin-bottom: 20px;
}
.search-box input {
  margin-right: 10px;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.search-box button {
  padding: 8px 12px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.search-box button:hover {
  background-color: #0056b3;
}
.search-results ul {
  list-style-type: none;
  padding: 0;
}
.search-results li {
  margin-bottom: 15px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  background-color: #fff;
}
.search-results button {
  margin-top: 10px;
  padding: 8px 12px;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.search-results button:hover {
  background-color: #218838;
}
</style>
