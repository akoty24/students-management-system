<template>
  <div>
    <header>
      <div class="navbar">
        <div class="logo">
          <h1 style="margin-left: 15px">Students Management</h1>
        </div>
        <nav class="nav-links">
          <router-link to="/" class="highlighted">Home</router-link>
          <router-link to="/students" class="highlighted">Students</router-link>
          <router-link to="/courses" class="highlighted">Courses</router-link>
         
        </nav>
      </div>
    </header>

    <main>
      <router-view></router-view>
    </main>

    <!-- <footer>
      <p>&copy; 2024 Your Website Name. All rights reserved.</p>
    </footer> -->
  </div>
</template>

<script>
export default {
  name: 'LayoutComponent',
}
</script>

<style scoped>
header {
  background-color: #333;
  color: #fff;
  padding: 0.5rem 1rem; 
}

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo {
  flex: 1;
}

.nav-links {
  display: flex;
  gap: 30px; 
  margin-right: 13%;
}

.nav-links a {
  color: #fff;
  text-decoration: none;
  font-size: 14px;
  line-height: 1; 
}

.nav-links .highlighted {
  font-size: 25px;
 }

main {
  padding: 1rem;
}

footer {
  background-color: #333;
  color: #fff;
  text-align: center;
  padding: 1rem;
}
</style>
