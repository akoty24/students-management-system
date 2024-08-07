import axios from '../../axios';
import Swal from 'sweetalert2';
import 'vue-multiselect/dist/vue-multiselect.css';


export default {
    name: 'StudentManagement',
    data() {
        return {
            students: {
                data: [],
                pagination: {
                    total: 0,
                    per_page: 15,
                    current_page: 1,
                    last_page: 1
                }
            },
            levels: [],
            studentForm: {
                full_name: '',
                code: '',
                date_of_birth: '',
                email: '',
                level_id: ''
            },
            searchQuery: '',
            selectedLevel: '',
            showForm: false,
            editing: false,
            editingStudentId: null,
            itemsPerPage: 15
        };
    },
    methods: {
        fetchStudents(page = 1) {
            axios.get('students', {
                params: {
                    search: this.searchQuery,
                    level: this.selectedLevel,
                    page: page,
                    per_page: this.itemsPerPage
                }
            }).then(response => {
                console.log('Students Data:', response.data);
                this.students = response.data.students;
            }).catch(error => {
                console.error('Error fetching students:', error);
            });
        },
        fetchLevels() {
            axios.get('levels')
                .then(response => {
                    this.levels = response.data.levels.data;
                })
                .catch(error => {
                    console.error('Error fetching levels:', error);
                });
        },
        validateForm() {
            return (
                this.studentForm.full_name.trim() !== '' &&
                this.studentForm.code.trim() !== '' &&
                this.studentForm.date_of_birth !== '' &&
                this.studentForm.email.trim() !== '' &&
                this.studentForm.level_id !== ''
            );
        },
        saveStudent() {
            if (this.validateForm()) {
                const url = this.editing ? `students/${this.editingStudentId}` : 'students';
                const method = this.editing ? 'put' : 'post';

                axios({ method, url, data: this.studentForm })
                    .then(response => {
                        console.log('Update Response:', response.data);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: this.editing ? 'Student updated successfully.' : 'Student added successfully.'
                        });
                        this.fetchStudents(this.students.pagination.current_page);
                        this.showForm = false;
                        this.resetForm();
                    })
                    .catch(error => {
                        console.error('Error saving student:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: this.editing ? 'Failed to update student. Please try again.' : 'Failed to add student. Please try again.'
                        });
                    });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error!',
                    text: 'Please fill out all required fields.'
                });
            }
        }






        ,
        deleteStudent(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this student data!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`students/${id}`)
                        .then(() => {
                            this.fetchStudents(this.students.pagination.current_page);
                            Swal.fire('Deleted!', 'The student has been deleted.', 'success');
                        }).catch(error => {
                            console.error('Error deleting student:', error);
                            Swal.fire('Error!', 'Failed to delete student. Please try again.', 'error');
                        });
                }
            });
        },
        resetForm() {
            this.studentForm = {
                full_name: '',
                code: '',
                date_of_birth: '',
                email: '',
                level_id: ''
            };
        },
        cancelForm() {
            this.showForm = false;
            this.resetForm();
        },
        changePage(page) {
            if (page > 0 && page <= this.students.pagination.last_page) {
                this.fetchStudents(page);
            }
        },
        updateItemsPerPage() {
            this.fetchStudents();
        },
        getLevelName(levelId) {
            const level = this.levels.find(l => l.id === levelId);
            return level ? level.name : 'Unknown';
        },
        searchStudents() {
            this.fetchStudents();
        },
        filterByLevel() {
            this.fetchStudents();
        },
        showAddStudentForm() {
            this.showForm = true;
            this.editing = false;
            this.resetForm();
        },
        editStudent(student) {
            this.showForm = true;
            this.editing = true;
            this.editingStudentId = student.id;
            this.studentForm = { ...student };
        }
    },
    mounted() {
        this.fetchStudents();
        this.fetchLevels();
    }
};
