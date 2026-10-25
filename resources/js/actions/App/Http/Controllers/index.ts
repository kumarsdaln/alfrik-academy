import PublicController from './PublicController'
import WebinarEventController from './WebinarEventController'
import DiscoveryController from './DiscoveryController'
import ContactController from './ContactController'
import AuthController from './AuthController'
import NotificationController from './NotificationController'
import StudentProfileController from './StudentProfileController'
import StudentLearningController from './StudentLearningController'
import StudentBillingController from './StudentBillingController'
import StaffController from './StaffController'
import Staff from './Staff'
import StaffPublishingController from './StaffPublishingController'
const Controllers = {
    PublicController: Object.assign(PublicController, PublicController),
WebinarEventController: Object.assign(WebinarEventController, WebinarEventController),
DiscoveryController: Object.assign(DiscoveryController, DiscoveryController),
ContactController: Object.assign(ContactController, ContactController),
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