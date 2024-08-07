<template>
  <div class="container">
    <h1 class="header">Students List</h1>
    <div class="controls">
      <input
        v-model="searchQuery"
        @input="searchStudents"
        placeholder="Search students by name, code, or email"
        class="search-input" style=" width: 500px; margin-right: 10px;"
      />
      <select
        v-model="selectedLevel"
        @change="filterByLevel"
        class="form-select "  style=" width: 300px; margin-right: 10px;"
      >
        <option value="">All Levels</option>
        <option v-for="level in levels" :key="level.id" :value="level.id">
          {{ level.name }}
        </option>
      </select>
      <select
        v-model="itemsPerPage"
        @change="updateItemsPerPage"
        class="form-select items-per-page-select" style="margin-right: 130px; width: 100px;"
      >
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="15">15</option>
      </select>
      <button @click="showAddStudentForm" class="btn btn-primary" > Add Student</button>

    </div>
    <div class="students-table">
      <table>
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Code</th>
            <th>Date of Birth</th>
            <th>Email</th>
            <th>Level</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="student in students.data" :key="student.id">
            <td>{{ student.full_name }}</td>
            <td>{{ student.code }}</td>
            <td>{{ student.date_of_birth }}</td>
            <td>{{ student.email }}</td>
            <td>{{ getLevelName(student.level_id) }}</td>
            <td class="actions-cell">
              <button @click="editStudent(student)" class="action-button edit-button">
                <i class="fas fa-edit"></i>
              </button>
              <button @click="deleteStudent(student.id)" class="action-button delete-button">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
          <tr v-if="!students.data.length">
            <td colspan="6" class="no-students">No students found</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="pagination-controls">
      <button
        :disabled="students.pagination.current_page === 1"
        @click="changePage(students.pagination.current_page - 1)"
        class="pagination-button"
      >
        Previous
      </button>
      <span class="pagination-info">
        Page {{ students.pagination.current_page }} of {{ students.pagination.last_page }}
      </span>
      <button
        :disabled="students.pagination.current_page === students.pagination.last_page"
        @click="changePage(students.pagination.current_page + 1)"
        class="pagination-button"
      >
        Next
      </button>
    </div>

    <div v-if="showForm" class="form-container">
      <h2 class="form-title">{{ editing ? 'Edit' : 'Add' }} Student</h2>
      <form @submit.prevent="saveStudent">
        <div class="form-field">
          <input v-model="studentForm.full_name" placeholder="Full Name" required class="form-input" />
        </div>
        <div class="form-field">
          <input v-model="studentForm.code" placeholder="Code" required class="form-input" />
        </div>
        <div class="form-field">
          <input v-model="studentForm.date_of_birth" type="date" required class="form-input" />
        </div>
        <div class="form-field">
          <input v-model="studentForm.email" type="email" placeholder="Email" required class="form-input" />
        </div>
        <div class="form-field">
          <select v-model="studentForm.level_id" required class="form-select">
            <option value="">Select Level</option>
            <option v-for="level in levels" :key="level.id" :value="level.id">{{ level.name }}</option>
          </select>
        </div>
        <div class="form-actions">
          <button type="submit" class="submit-button">{{ editing ? 'Update' : 'Add' }} Student</button>
          <button @click="cancelForm" class="cancel-button">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script src="./StudentManagement.js"></script>
<style src="./StudentManagement.css"></style>
