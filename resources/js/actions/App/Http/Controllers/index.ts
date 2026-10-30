import HomeController from './HomeController'
import PublicController from './PublicController'
import ContactController from './ContactController'
import WebinarEventController from './WebinarEventController'
import Insights from './Insights'
import Careers from './Careers'
import AuthController from './AuthController'
import NotificationController from './NotificationController'
import StudentProfileController from './StudentProfileController'
import StudentLearningController from './StudentLearningController'
import StudentBillingController from './StudentBillingController'
import StaffController from './StaffController'
import Staff from './Staff'
import StaffPublishingController from './StaffPublishingController'
const Controllers = {
    HomeController: Object.assign(HomeController, HomeController),
PublicController: Object.assign(PublicController, PublicController),
ContactController: Object.assign(ContactController, ContactController),
WebinarEventController: Object.assign(WebinarEventController, WebinarEventController),
Insights: Object.assign(Insights, Insights),
Careers: Object.assign(Careers, Careers),
AuthController: Object.assign(AuthController, AuthController),
NotificationController: Object.assign(NotificationController, NotificationController),
StudentProfileController: Object.assign(StudentProfileController, StudentProfileController),
StudentLearningController: Object.assign(StudentLearningController, StudentLearningController),
StudentBillingController: Object.assign(StudentBillingController, StudentBillingController),
StaffController: Object.assign(StaffController, StaffController),
Staff: Object.assign(Staff, Staff),
StaffPublishingController: Object.assign(StaffPublishingController, StaffPublishingController),
}

export default Controllers