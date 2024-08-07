<template>
  <div class="container">
    <h1 class="header">Courses List</h1>

    <div class="controls">
      <input
        v-model="searchQuery"
        @input="searchCourses"
        placeholder="Search courses by name, code"
        class="search-input" style=" width: 500px; margin-right: 10px;"
      />
      <select
        v-model="itemsPerPage"
        @change="updateItemsPerPage"
        class="items-per-page-select" style="margin-right: 450px; width:100px;"
      >
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="15">15</option>
      </select>
      <button @click="showAddCourseForm" class="btn btn-primary">
        Add Course
      </button>
    </div>

    <div class="courses-table">
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Code</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="course in courses.data" :key="course.id">
            <td>{{ course.name }}</td>
            <td>{{ course.code }}</td>
            <td>{{ course.description }}</td>
            <td class="actions">
              <button @click="goToCourseDetails(course.id)" class="btn btn-secondary" style="margin-right: 3px;">
                <i class="fas fa-eye"></i>
              </button>
              <button @click="editCourse(course)" class="btn btn-secondary" style="margin-right: 3px;">
                <i class="fas fa-edit"></i>
              </button>
              <button @click="deleteCourse(course.id)" class="btn btn-danger" style="margin-right: 3px;">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
          <tr v-if="!courses.data.length">
            <td colspan="4" class="no-courses">No courses found</td>
          </tr>
        </tbody>
      </table>


    </div>
    <div class="pagination-controls">
      <button
        :disabled="courses.pagination.current_page === 1"
        @click="changePage(courses.pagination.current_page - 1)"
        class="pagination-button"
      >
        Previous
      </button>
      <span class="pagination-info">
        Page {{ courses.pagination.current_page }} of {{ courses.pagination.last_page }}
      </span>
      <button
        :disabled="courses.pagination.current_page === courses.pagination.last_page"
        @click="changePage(courses.pagination.current_page + 1)"
        class="pagination-button"
      >
        Next
      </button>
    </div>

    <div v-if="showForm" class="form-container">
      <h2 class="form-title">{{ editing ? 'Edit' : 'Add' }} Course</h2>
      <form @submit.prevent="saveCourse">
        <div class="form-group">
          <input v-model="courseForm.name" placeholder="Course Name" required class="form-input" />
        </div>
        <div class="form-group">
          <input v-model="courseForm.code" placeholder="Course Code" required class="form-input" />
        </div>
        <div class="form-group">
          <textarea v-model="courseForm.description" placeholder="Course Description" rows="4" class="form-input"></textarea>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">{{ editing ? 'Update' : 'Add' }} Course</button>
          <button @click="cancelForm" class="btn btn-secondary">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script src="./CourseManagement.js"></script>
<style src="./CourseManagement.css"></style>
