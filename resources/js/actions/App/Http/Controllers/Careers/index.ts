import JobController from './JobController'
import JobSubmissionController from './JobSubmissionController'
import JobApplicationController from './JobApplicationController'
const Careers = {
    JobController: Object.assign(JobController, JobController),
JobSubmissionController: Object.assign(JobSubmissionController, JobSubmissionController),
JobApplicationController: Object.assign(JobApplicationController, JobApplicationController),
}

export default Careers