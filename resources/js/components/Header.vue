<template>
  <header class="header">
    <div class="header-content">
      <div class="title-container">
        <img src="/images/car.jpg" alt="Car Logo" class="logo" />
        <h1 class="title">United Auto Sales</h1>
      </div>
      <nav>
        <ul>
          <li v-if="isLoggedIn"><router-link to="/">Home</router-link></li>
          <li v-if="!isLoggedIn"><router-link to="/register">Register</router-link></li>
          <li v-if="!isLoggedIn"><router-link to="/login">Login</router-link></li>
          <li v-if="isLoggedIn"><router-link to="/explore">Explore</router-link></li>
          <li v-if="isLoggedIn"><router-link to="/cars/new">Add Car</router-link></li>
          <li v-if="isLoggedIn"><router-link to="/profile">Profile</router-link></li>
          <li v-if="isLoggedIn"><a href="#" @click.prevent="logout">Logout</a></li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<script>
export default {
  data() {
    return {
      isLoggedIn: !!localStorage.getItem("auth_token"),
    };
  },
  methods: {
    logout() {
      localStorage.removeItem("auth_token");
      this.isLoggedIn = false;
      this.$router.push("/login");
    },
  },
  watch: {
    $route() {
      this.isLoggedIn = !!localStorage.getItem("auth_token");
    },
  },
};
</script>

<style scoped>
.header {
  background-color: #030c14; /* Dark blue */
  color: #d3d3d3; /* Light grey */
  padding: 10px 20px;
}
.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.title-container {
  display: flex;
  align-items: center;
  gap: 10px;
}
.logo {
  width: 40px;
  height: 40px;
  border-radius: 50%;
}
.title {
  font-size: 24px;
  font-weight: bold;
  margin: 0;
}
.header nav ul {
  list-style: none;
  display: flex;
  gap: 15px;
  margin: 0;
  padding: 0;
}
.header nav ul li {
  display: inline;
}
.header nav ul li a {
  color: #d3d3d3; /* Light grey */
  text-decoration: none;
  font-weight: bold;
}
.header nav ul li a:hover {
  text-decoration: underline;
}
</style>
