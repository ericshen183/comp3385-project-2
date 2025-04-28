<template>
  <div class="car-details-page">
    <h2>Car Details</h2>
    <div v-if="car">
      <p><strong>Make:</strong> {{ car.make }}</p>
      <p><strong>Model:</strong> {{ car.model }}</p>
      <p><strong>Year:</strong> {{ car.year }}</p>
      <p><strong>Colour:</strong> {{ car.colour }}</p>
      <p><strong>Transmission:</strong> {{ car.transmission }}</p>
      <p><strong>Type:</strong> {{ car.car_type }}</p>
      <p><strong>Price:</strong> ${{ car.price }}</p>
      <p><strong>Description:</strong> {{ car.description }}</p>
      <img v-if="car.photo" :src="car.photo" alt="Car photo" />

      <div class="actions">
        <button @click="emailOwner">Email Owner</button>
        <button @click="toggleFavourite">
          <span :class="{'favourited': isFavourited}">❤️</span> Favourite
        </button>
      </div>
    </div>
    <p v-else>Loading car details...</p>

    <div class="recent-cars" v-if="recentCars.length">
      <h3>Recently Added Cars</h3>
      <div class="card-container">
        <div class="card" v-for="car in recentCars" :key="car.id">
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
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      car: null,
      isFavourited: false,
      recentCars: [],
    };
  },
  async created() {
    const carId = this.$route.params.car_id;
    try {
      const response = await axios.get(`/api/v1/cars/${carId}`);
      this.car = response.data;

      // Check if the car is already favourited by the user
      const favouriteResponse = await axios.get(`/api/v1/cars/${carId}/favourite-status`);
      this.isFavourited = favouriteResponse.data.isFavourited;

      // Fetch the last 3 cars
      const recentCarsResponse = await axios.get("/api/v1/cars?limit=3");
      this.recentCars = recentCarsResponse.data;
    } catch (err) {
      console.error("Error fetching car details or recent cars:", err);
    }
  },
  methods: {
    async emailOwner() {
      if (this.car && this.car.user) {
        const email = this.car.user.email;
        window.location.href = `mailto:${email}`;
      } else {
        alert("Owner's email is not available.");
      }
    },
    async toggleFavourite() {
      try {
        const carId = this.car.id;
        if (this.isFavourited) {
          await axios.delete(`/api/v1/cars/${carId}/favourite`);
          this.isFavourited = false;
        } else {
          await axios.post(`/api/v1/cars/${carId}/favourite`);
          this.isFavourited = true;
        }
      } catch (err) {
        console.error("Error toggling favourite:", err);
      }
    },
    viewCarDetails(carId) {
      this.$router.push(`/cars/${carId}`);
    },
  },
};
</script>

<style scoped>
.car-details-page {
  max-width: 600px;
  margin: 20px auto;
  padding: 20px;
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 8px;
}
.car-details-page img {
  max-width: 100%;
  height: auto;
  margin-top: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
}
.actions {
  margin-top: 20px;
}
.actions button {
  margin-right: 10px;
  padding: 10px 15px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.actions button:hover {
  background-color: #0056b3;
}
.favourited {
  color: red;
  font-size: 18px;
}
.recent-cars {
  margin-top: 30px;
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
