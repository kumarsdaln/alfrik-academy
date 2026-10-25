import AdminOperationsController from './AdminOperationsController'
import AdminCourseController from './AdminCourseController'
import AdminStoryController from './AdminStoryController'
import AdminPublicPageController from './AdminPublicPageController'
import AdminWebinarEventController from './AdminWebinarEventController'
import AdminAssessmentController from './AdminAssessmentController'
const Staff = {
    AdminOperationsController: Object.assign(AdminOperationsController, AdminOperationsController),
AdminCourseController: Object.assign(AdminCourseController, AdminCourseController),
AdminStoryController: Object.assign(AdminStoryController, AdminStoryController),
AdminPublicPageController: Object.assign(AdminPublicPageController, AdminPublicPageController),
AdminWebinarEventController: Object.assign(AdminWebinarEventController, AdminWebinarEventController),
AdminAssessmentController: Object.assign(AdminAssessmentController, AdminAssessmentController),
}

export default Staff