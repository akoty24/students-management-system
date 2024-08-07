<template>
  <div class="container">
    <h1>Welcome to the Students Management System</h1>
    <p>This is the home page of the application.</p>
    <router-link to="/students" class="btn">Go to Students</router-link>
  </div>
</template>

<script>
export default {
  name: 'Home'
};
</script>

<style scoped>
.container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 50vh; 
  text-align: center;
  padding: 1rem;
}

h1 {
  color: #2c3e50;
  font-size: 2rem; 
  margin-bottom: 1rem;
}

p {
  font-size: 1rem;
  margin-bottom: 2rem;
}

.btn {
  display: inline-block;
  padding: 0.5rem 1rem;
  font-size: 1rem;
  color: #fff;
  background-color: #3498db;
  text-decoration: none;
  border-radius: 4px;
}

.btn:hover {
  background-color: #2980b9;
}
</style>
