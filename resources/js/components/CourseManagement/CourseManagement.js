import axios from '../../axios';
import Swal from 'sweetalert2';

export default {
    name: 'CourseDetails',
    props: {
        course: Object
    },
    data() {
        return {
            courses: {
                data: [],
                pagination: {
                    total: 0,
                    per_page: 15,
                    current_page: 1,
                    last_page: 1
                }
            },
            courseForm: {
                name: '',
                code: '',
                description: ''
            },
            searchQuery: '',
            showForm: false,
            editing: false,
            editingCourseId: null,
            itemsPerPage: 15
        };
    },
    methods: {
        goToCourseDetails(courseId) {
            this.$router.push({ name: 'CourseDetails', params: { id: courseId } });
        },
        fetchCourses(page = 1) {
            axios.get('courses', {
                params: {
                    search: this.searchQuery,
                    page: page,
                    per_page: this.itemsPerPage
                }
            }).then(response => {
                console.log('Courses Data:', response.data);
                this.courses = response.data.courses;
            }).catch(error => {
                console.error('Error fetching courses:', error);
            });
        },
        saveCourse() {
            if (this.validateForm()) {
                const url = this.editing ? `courses/${this.editingCourseId}` : 'courses';
                const method = this.editing ? 'put' : 'post';

                axios({ method, url, data: this.courseForm })
                    .then(response => {
                        console.log('Response Data:', response.data);
                        if (response.data.message) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.data.message
                            });
                            this.fetchCourses(this.courses.pagination.current_page);
                            this.showForm = false;
                            this.resetForm();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to save course. Please try again.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error Saving Course:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: this.editing ? 'Failed to update course. Please try again.' : 'Failed to add course. Please try again.'
                        });
                    });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error!',
                    text: 'Please fill out all required fields.'
                });
            }
        },
        deleteCourse(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this course data!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`courses/${id}`)
                        .then(() => {
                            this.fetchCourses(this.courses.pagination.current_page);
                            Swal.fire('Deleted!', 'The course has been deleted.', 'success');
                        }).catch(error => {
                            console.error('Error deleting course:', error);
                            Swal.fire('Error!', 'Failed to delete course. Please try again.', 'error');
                        });
                }
            });
        },
        resetForm() {
            this.courseForm = {
                name: '',
                code: '',
                description: ''
            };
        },
        cancelForm() {
            this.showForm = false;
            this.resetForm();
        },
        changePage(page) {
            if (page > 0 && page <= this.courses.pagination.last_page) {
                this.fetchCourses(page);
            }
        },
        updateItemsPerPage() {
            this.fetchCourses();
        },
        searchCourses() {
            this.fetchCourses();
        },
        showAddCourseForm() {
            this.showForm = true;
            this.editing = false;
            this.resetForm();
        },
        editCourse(course) {
            this.showForm = true;
            this.editing = true;
            this.editingCourseId = course.id;
            this.courseForm = { ...course };
        },
        validateForm() {
            return (
                this.courseForm.name.trim() !== '' &&
                this.courseForm.code.trim() !== '' &&
                this.courseForm.description.trim() !== ''
            );
        }
    },
    mounted() {
        this.fetchCourses();
    }
};
