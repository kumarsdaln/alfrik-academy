import InsightController from './InsightController'
import SurveyController from './SurveyController'
import ReportController from './ReportController'
const Insights = {
    InsightController: Object.assign(InsightController, InsightController),
SurveyController: Object.assign(SurveyController, SurveyController),
ReportController: Object.assign(ReportController, ReportController),
}

export default Insights