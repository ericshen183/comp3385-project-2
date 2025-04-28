<template>
  <div class="user-profile-page">
    <h1>User Profile</h1>
    <div v-if="user">
      <img v-if="user.photo" :src="user.photo" alt="User Photo" class="user-photo" />
      <p><strong>Name:</strong> {{ user.name }}</p>
      <p><strong>Email:</strong> {{ user.email }}</p>
      <p><strong>Location:</strong> {{ user.location }}</p>
      <p><strong>Biography:</strong> {{ user.biography }}</p>
    </div>
    <div v-else>
      <p>Loading user profile...</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      user: null,
    };
  },
  async created() {
    try {
      const response = await axios.get(`/api/v1/users/${this.$route.params.user_id}`);
      this.user = response.data;
    } catch (err) {
      console.error("Error fetching user profile:", err);
    }
  },
};
</script>

<style scoped>
.user-profile-page {
  max-width: 600px;
  margin: 20px auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f9f9f9;
}
.user-photo {
  max-width: 150px;
  border-radius: 50%;
  margin-bottom: 20px;
}
</style>
