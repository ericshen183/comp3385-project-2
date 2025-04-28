<template>
  <div class="dashboard-page">
    <h2>Welcome to the Dashboard</h2>

    <div v-if="!isLoggedIn" class="login-section">
      <h3>Login</h3>
      <form @submit.prevent="login">
        <div>
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="loginForm.email" required />
        </div>
        <div>
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="loginForm.password" required />
        </div>
        <button type="submit">Login</button>
      </form>
      <p v-if="loginError" class="error">{{ loginError }}</p>
    </div>

    <div v-else>
      <div class="search-box">
        <h3>Search Cars</h3>
        <form @submit.prevent="searchCars">
          <input type="text" v-model="searchQuery.make" placeholder="Search by make" />
          <input type="text" v-model="searchQuery.model" placeholder="Search by model" />
          <button type="submit">Search</button>
        </form>
      </div>

      <div class="car-results">
        <h3 v-if="searchPerformed">Search Results</h3>
        <h3 v-else>Recently Added Cars</h3>
        <div class="card-container">
          <div class="card" v-for="car in displayedCars" :key="car.id">
            <img v-if="car.photo" :src="car.photo" alt="Car photo" />
            <div class="card-body">
              <h4>{{ car.make }} {{ car.model }}</h4>
              <p>{{ car.year }} - ${{ car.price }}</p>
              <button @click="viewCarDetails(car.id)">View Details</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import apiClient from "../axios";

export default {
  data() {
    return {
      isLoggedIn: !!localStorage.getItem("auth_token"),
      loginForm: {
        email: "",
        password: "",
      },
      loginError: null,
      cars: [],
      searchQuery: {
        make: "",
        model: "",
      },
      searchPerformed: false,
    };
  },
  computed: {
    displayedCars() {
      if (this.searchPerformed) {
        return this.cars;
      }
      return this.cars.slice(0, 3); // Show only the last 3 cars if no search is performed
    },
  },
  methods: {
    async login() {
      try {
        this.loginError = null;
        const response = await apiClient.post("/auth/login", this.loginForm);
        localStorage.setItem("auth_token", response.data.token);
        this.isLoggedIn = true;
        this.fetchCars();
      } catch (err) {
        this.loginError = err.response?.data?.message || "An error occurred.";
      }
    },
    async fetchCars() {
      try {
        const response = await apiClient.get("/cars");
        this.cars = response.data;
      } catch (err) {
        console.error("Error fetching cars:", err);
      }
    },
    async searchCars() {
      try {
        this.searchPerformed = true;
        const response = await apiClient.get("/search", {
          params: this.searchQuery,
        });
        this.cars = response.data;
      } catch (err) {
        console.error("Error searching cars:", err);
      }
    },
    viewCarDetails(carId) {
      this.$router.push(`/cars/${carId}`);
    },
  },
  mounted() {
    if (this.isLoggedIn) {
      this.fetchCars();
    }
  },
};
</script>

<style scoped>
.dashboard-page {
  max-width: 800px;
  margin: 0 auto;
}
.login-section {
  margin-bottom: 20px;
}
.login-section div {
  margin-bottom: 10px;
}
.login-section label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}
.login-section input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.login-section button {
  padding: 8px 12px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.login-section button:hover {
  background-color: #0056b3;
}
.error {
  color: red;
  font-size: 14px;
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
.card-container {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
}
.card {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 10px;
  width: 180px;
  background-color: #fff;
  text-align: center;
}
.card img {
  max-width: 100%;
  height: auto;
  border-radius: 8px;
  margin-bottom: 10px;
}
.card-body h4 {
  font-size: 16px;
  margin-bottom: 5px;
}
.card-body p {
  font-size: 14px;
  margin-bottom: 10px;
}
.card-body button {
  padding: 8px 12px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.card-body button:hover {
  background-color: #0056b3;
}
</style>
