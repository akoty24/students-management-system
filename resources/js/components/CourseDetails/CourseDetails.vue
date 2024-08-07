<template>
  <div class="container">
    <h1 class="header">Students and Grades List</h1>

    <div class="controls">
      <select v-model="courseId" @change="fetchStudents" class="items-per-page-select" style="margin-right: 600px; width: 300px;">
        <option v-for="course in courses" :key="course.id" :value="course.id">
          {{ course.name }}
        </option>
      </select>
      <button @click="showAttachStudentsForm" class="btn btn-primary" style="float: right;">
        Attach Students
      </button>
    </div>

    <div class="students-table">
      <table>
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Code</th>
            <th v-for="item in gradeItems" :key="item.id">{{ item.name }}</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="student in students.data" :key="student.id">
            <td>{{ student.full_name }}</td>
            <td>{{ student.code }}</td>
            <td v-for="item in gradeItems" :key="item.id">
              {{ student.grades[item.id] || 0 }}
            </td>
            <td class="actions">
              <button @click="showAssignGradesForm(student)" class="btn btn-secondary" style="margin-right: 3px;">
                Assign Grades
              </button>
              <button @click="detachStudent(student)" class="btn btn-danger" style="margin-right: 3px;">
                Detach Student
              </button>
            </td>
          </tr>
          <tr v-if="students.data.length === 0">
            <td colspan="5" class="no-students">No students found</td>
          </tr>
        </tbody>
      </table>

      <div class="pagination-controls" v-if="students.pagination.total > itemsPerPage">
        <button @click="changePage(students.pagination.current_page - 1)" :disabled="students.pagination.current_page === 1">
          Previous
        </button>
        <button @click="changePage(students.pagination.current_page + 1)" :disabled="students.pagination.current_page === students.pagination.last_page">
          Next
        </button>
      </div>
    </div>

    <div v-if="showForm" class="form-container">
      <h2 class="form-title">Attach Students</h2>
      <form @submit.prevent="attachStudents">
        <div class="form-group">
          <multiselect
            v-model="selectedStudents"
            :options="allStudents"
            :multiple="true"
            :close-on-select="false"
            :clear-on-select="false"
            :preserve-search="true"
            placeholder="Select students"
            label="full_name"
            track-by="id"
          ></multiselect>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Attach Students</button>
          <button @click="cancelForm" class="btn btn-secondary">Cancel</button>
        </div>
      </form>
    </div>

    <div v-if="showGradesForm" class="form-container">
      <h2 class="form-title">Assign Grades to {{ currentStudent.full_name }}</h2>
      <form @submit.prevent="assignGrades">
        <div class="form-group" v-for="item in gradeItems" :key="item.id">
          <label :for="'grade-' + item.id">{{ item.name }}</label>
          <input
            type="number"
            v-model="currentGrades[item.id]"
            :id="'grade-' + item.id"
            class="form-input"
            placeholder="Enter grade"
          />
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Assign Grades</button>
          <button @click="cancelGradesForm" class="btn btn-secondary">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script src="./CourseDetails.js"></script>
<style src="./CourseDetails.css"></style>
