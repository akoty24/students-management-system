import axios from '../../axios';
import Swal from 'sweetalert2';
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';

export default {
    name: 'CourseDetails',
    components: { Multiselect },
    props: ['id'],
    data() {
        return {
            students: { data: [], pagination: { total: 0, per_page: 15, current_page: 1, last_page: 1 } },
            allStudents: [],
            gradeItems: [],
            selectedStudents: [],
            showForm: false,
            showGradesForm: false,
            currentStudent: null,
            currentGrades: {},
            itemsPerPage: 15,
            courseId: null,
            courses: []
        };
    },
    watch: {
        courseId: 'fetchStudents'
    },
    methods: {
        fetchCourseDetails() {
            axios.get(`/courses/${this.courseId}`)
                .then(response => {
                    this.currentCourseName = response.data.name;
                    this.fetchStudents();
                })
                .catch(error => console.error('Error fetching course details:', error));
        },
        fetchStudents(page = 1) {
            axios.get('students_with_grades', { params: { course_id: this.courseId, page, per_page: this.itemsPerPage } })
                .then(response => {
                    this.students.data = response.data.map(enrollment => ({
                        id: enrollment.student.id,
                        full_name: enrollment.student.full_name,
                        code: enrollment.student.code,
                        grades: enrollment.grades.reduce((acc, grade) => {
                            acc[grade.grade_item_id] = grade.score;
                            return acc;
                        }, {})
                    }));
                    this.students.pagination = response.data.pagination || this.students.pagination;
                })
                .catch(error => console.error('Error fetching students:', error));
        },
        fetchAllStudents() {
            axios.get('students')
                .then(response => this.allStudents = response.data.students.data)
                .catch(error => console.error('Error fetching all students:', error));
        },
        fetchGradeItems() {
            axios.get('grade-items')
                .then(response => this.gradeItems = response.data.gradeItems.data)
                .catch(error => console.error('Error fetching grade items:', error));
        },
        fetchCourses() {
            axios.get('courses')
                .then(response => {
                    this.courses = response.data.courses.data;
                    const selectedCourse = this.courses.find(course => course.id === this.courseId);
                    this.currentCourseName = selectedCourse ? selectedCourse.name : 'Select a course';
                })
                .catch(error => console.error('Error fetching courses:', error));
        },
        showAssignGradesForm(student) {
            this.currentStudent = student;
            this.currentGrades = { ...student.grades };
            this.showGradesForm = true;
        },
        assignGrades() {
            const payload = {
                student_id: this.currentStudent.id,
                course_id: this.courseId,
                grades: this.gradeItems.map(item => ({
                    grade_item_id: item.id,
                    score: this.currentGrades[item.id] || 0
                }))
            };
            axios.post('/add_grades', payload)
                .then(response => {
                    Swal.fire({ icon: 'success', title: 'Success!', text: response.data.message });
                    this.fetchStudents(this.students.pagination.current_page);
                    this.showGradesForm = false;
                    this.currentStudent = null;
                    this.currentGrades = {};
                })
                .catch(error => {
                    console.error('Error assigning grades:', error.response.data);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: `Failed to assign grades. ${error.response.data.message || 'Please try again.'}`
                    });
                });
        },
        cancelGradesForm() {
            this.showGradesForm = false;
            this.currentStudent = null;
            this.currentGrades = {};
        },
        showAttachStudentsForm() {
            this.showForm = true;
            this.fetchAllStudents();
        },
        cancelForm() {
            this.showForm = false;
            this.selectedStudents = [];
        },
        detachStudent(student) {
            axios.post(`/courses/${this.courseId}/detach/student`, { student_id: student.id })
                .then(response => {
                    Swal.fire({ icon: 'success', title: 'Success!', text: response.data.message });
                    this.fetchStudents(this.students.pagination.current_page);
                })
                .catch(error => {
                    console.error('Error detaching student:', error);
                    Swal.fire({ icon: 'error', title: 'Error!', text: 'Failed to detach student. Please try again.' });
                });
        },
        attachStudents() {
            axios.post(`/courses/${this.courseId}/attach/students`, {
                student_ids: this.selectedStudents.map(student => student.id)
            })
                .then(response => {
                    Swal.fire({ icon: 'success', title: 'Success!', text: response.data.message });
                    this.fetchStudents(this.students.pagination.current_page);
                    this.showForm = false;
                    this.selectedStudents = [];
                })
                .catch(error => {
                    console.error('Error attaching students:', error);
                    Swal.fire({ icon: 'error', title: 'Error!', text: 'Failed to attach students. Please try again.' });
                });
        },
        changePage(page) {
            if (page > 0 && page <= this.students.pagination.last_page) {
                this.fetchStudents(page);
            }
        }
    },
    mounted() {
        this.courseId = this.id;
        this.fetchCourseDetails();
        this.fetchGradeItems();
        this.fetchCourses();
    }
};
